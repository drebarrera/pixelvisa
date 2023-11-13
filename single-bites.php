<?php
    /*
    Template Name: Bites
    */
    get_header();
    global $post;
    if ( have_posts() ) :
        while ( have_posts() ) : the_post();
            $photo = get_field("cover-photo");
            if ( !empty($photo) ) :
                function toUSD($value) {
                    $exchange_rate = get_data(["country-post", ["exchange-rate"]], array())["country-post-exchange-rate"];
                    return round(floatval($value) / floatval($exchange_rate), 2);
                    
                }
                $url = "url('" . $photo["url"] . "')";
?>
                <section id="title-section" style="--bg: <?php echo $url ?>;">
                    <h2><?php echo strtoupper(get_field("restaurant")); ?></h2>
                </section>
                <section id="basic-info-section" class="content section">
                    <div id="info-panel">
<?php
                        echo '<h3>' . strtoupper(get_field("city")) . ' AT A GLANCE</h3>';
                        $location_keys = array("RESTAURANT" => ["restaurant"], "CITY" => ["location-post", ["location-en"]], "CUISINE" => "cuisine", "SPECIALTY DISH" => "dish", "AVERAGE MEAL PRICE" => ["meal-price", "expensiveness"], "RATING" => "rating", "WEBSITE" => "website", "ADDRESS" => "address", "HOURS" => "hours", "LAST UPDATED" => "active-date");
                        foreach ($location_keys as $header => $field) {
                            $value = [];
                            if (is_array($field)) {
                                $field_items = explode("-", $field[0]);
                                $field_item = [];
                                $is_post = false;
                                for ($i = 0; $i < count($field_items); $i++) {
                                    if ($field_items[$i] != "post") {
                                        $field_item[] = $field_items[$i];
                                    } else {
                                        $field_item[] = "post";
                                        $field_item = implode("-", $field_item);
                                        $post = get_field($field_item);
                                        $is_post = true;
                                        $field_item = [];
                                    }
                                }
                                if ( $is_post ) {
                                    $is_link = false;
                                    for ($j = 0; $j < count($field[1]); $j++) {
                                        if ($field[1][$j] == "get-permalink") {
                                            $value[] = '<a href="' . get_permalink() . '">';
                                            $is_link = true;
                                        } else $value[] = get_field($field[1][$j]);
                                    }
                                    if ( $is_link ) $value[] = '</a>';
                                    wp_reset_postdata();
                                } else {
                                    for ($i = 0; $i < count($field); $i++) {
                                        if (is_array($field[$i])) {
                                            for ($j = 0; $j < count($field); $j++) {
                                                $value[] = get_field($field[$i]);
                                            }
                                        } else {
                                            $value[] = get_field($field[$i]);
                                        }
                                    }
                                }
                                
                                $value = implode(" ", $value);
                            } else $value = get_field($field);

                            // Field-Specific Formatting
                            if ($header == "LAST UPDATED") {
                                $value = preg_replace('/(\d{4})(\d{2})(\d{2})/', '$3/$2/$1', $value);
                            } else if ($header == "WEBSITE") {
                                $value = '<a href="' . $value . '">' . $value . '</a>';
                            } else if ($header == "AVERAGE MEAL PRICE") {
                                if (!empty($value)) {
                                    $value = explode(" ", $value);
                                    $cost = $value[0];
                                    if (!empty($cost)) {
                                        $currency = explode("-", explode(",", get_data(["location-post", ["country-post", ["currency"]]], array())["location-post-country-post-currency"])[0]);
                                        if ($currency[0] != "USD") $value[0] = $currency[2] . $cost . " " . $currency[0] . " / $" . toUSD($cost) . " USD";
                                        else $value[0] = $currency[2] . $cost . " " . $currency[0];
                                    }
                                    $value[1] = "(" . $value[1] . ")";
                                    $value = implode(" ", $value);
                                }
                            }
                            if ( !empty($value) ) echo '<h4>' . $header . '</h4><p>' . $value . '</p>';
                        }
?>
                    </div>
                    <div id="dynamic-section">
                        <div id="map"></div>
                </section>
<?php
                $post_id = get_the_ID();
                $post_content = get_post_field('post_content', $post_id);
                if ( !empty($post_content) ) {
                    echo '<section id="images-section" class="content section">
                    <h3>PHOTOS</h3>
                    <div id="media">';
                    $dom = new DOMDocument;
                    @$dom->loadHTML($post_content);
                    $image_urls = [];
                    foreach ($dom->getElementsByTagName('img') as $img) {
                        echo '<img class="media" src="' . $img->getAttribute('src') . '" onclick="showLightbox(' . "'" . $img->getAttribute('src') . "'" . ', ' . "'" . $img->getAttribute('alt') . "'" . ');"/>';
                    }
                    echo '</div>
                    </section>';
                }
                $content = ["ABOUT THE ESTABLISHMENT" => "description"];
                foreach ($content as $title => $field) {
                    if (is_array($field)) {
                        $data = [];
                        foreach ( $field as $t => $f ) {
                            $datum = get_field($f);
                            $photo = get_field($f . "-photo");
                            if ( !empty($datum) ) {
                                $data[] = [$t, $datum, $photo];
                            }
                        }
                        if ( count($data) > 0 ) {
                            echo '<section id="' . str_replace(" ", "-", strtolower($title)) . '-section" class="content section description-section">
                            <h3>' . $title . '</h3>';
                            foreach ( $data as [$t, $datum, $photo] ) {
                                echo '<h4>' . $t . '</h4>';
                                if ($photo) echo '<img src="' . $photo['url'] . '"/>
                                <em style="width:60%; text-align: center;">'. $photo['alt'] . '</em>';
                                echo '<div class="item">' . parseText($datum, ['list' => '<h4>$1</h4>', 'sublist' => '<b>$1</b>', 'topic' => '<div><span style="font-weight: 600;">$2</span>$3</div>']) . '</div>';
                            }
                            echo '</section>';
                        }
                    } else {
                        $data = get_field($field);
                        if ( !empty($data) ) {
                            $photo = get_field($field . "-photo");
                            echo '<section id="' . str_replace(" ", "-", strtolower($title)) . '-section" class="content section description-section">
                            <h3>' . $title . '</h3>';
                            if ($photo) echo '<img src="' . $photo['url'] . '"/>
                            <em style="width:60%; text-align: center;">'. $photo['alt'] . '</em>';
                            echo '<div class="item">' . parseText($data, ['list' => '<h4>$1</h4>', 'sublist' => '<b>$1</b>', 'topic' => '<div><span style="font-weight: 600; color: var(--blue);">$2</span>$3</div>']) . '</div>
                            </section>';
                        }
                    }
                    
                }
?>
                <div id="photo-lightbox" class="content">
                    <svg onclick="hideLightbox();" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18M6 6l12 12"/></svg>
                    <img />
                    <p></p>
                </div>
<?php
            endif;
        endwhile;
    endif;
get_footer();