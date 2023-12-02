<?php
    /*
    Template Name: Cities
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
                    <h2><?php echo strtoupper(get_field("location-en")); ?></h2>
                </section>
                <section id="basic-info-section" class="content section">
                    <div id="info-panel">
<?php
                        echo '<h3>' . strtoupper(get_field("city")) . ' AT A GLANCE</h3>';
                        $location_keys = array("CITY" => ["city", "city-lang"], "COUNTRY" => ["country-post", ["get-permalink", "country", "country-lang"]], "TIMEZONE" => "timezone", "TRAIN" => ["train", "train-cost"], "BUS" => ["bus", "bus-cost"], "TERRAIN" => "terrain", "WEATHER" => "weather", "AVERAGE MEAL COST" => "meal-cost", "AVERAGE HOSTEL COST" => "hostel-cost", "LAST UPDATED" => "active-date");
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
                            } else if ($header == "TRAIN" || $header == "BUS" || $header == "AVERAGE MEAL COST" || $header == "AVERAGE HOSTEL COST") {
                                if ( !empty($value) ) {
                                    $value = explode(" ", $value);
                                    $cost = $value[count($value) - 1];
                                    if ( !empty($cost) ) {
                                        $currency = explode("-", explode(",", get_data(["country-post", ["currency"]], array())["country-post-currency"])[0]);
                                        if ($header == "TRAIN" || $header == "BUS") {
                                            if ($currency[0] != "USD") $value[count($value) - 1] = "(" . $currency[2] . $cost . " " . $currency[0] . " / $" . toUSD($cost) . " USD)";
                                            else $value[count($value) - 1] = "(" . $currency[2] . $cost . " " . $currency[0] . ")";
                                        } else {
                                            if ($currency[0] != "USD") $value[count($value) - 1] = $currency[2] . $cost . " " . $currency[0] . " / $" . toUSD($cost) . " USD";
                                            else $value[count($value) - 1] = $currency[2] . $cost . " " . $currency[0];
                                        }
                                    }
                                    $value = implode(" ", $value);
                                }
                            } else if ($header == "TIMEZONE") {
                                if ($value == "") $value = get_data(["country-post", ["timezones"]], array())["country-post-timezones"];
                            }
                            
                            if ( !empty($value) ) echo '<h4>' . $header . '</h4><p>' . $value . '</p>';
                        }
?>
                    </div>
                    <div id="dynamic-section">
                        <div id="map"></div>
<?php
                        $current_date = current_time('Ymd'); 
                        $location = get_field("location-en");

                        $args = array(
                            'post_type' => 'experiences',
                            'orderby' => 'meta_value_num',
                            'order' => 'DESC',
                            'meta_key' => 'rating',
                            'meta_query' => array(
                                array(
                                    'key' => 'active-date',
                                    'compare' => '<=',
                                    'value' => $current_date,
                                    'type' => 'NUMERIC'
                                ),
                            )
                        );
                    
                        $latest_travel = new WP_Query( $args );
                        $filtered = [];
                        if ( $latest_travel->have_posts() ) {
                            while ( $latest_travel->have_posts() ) {
                                $latest_travel->the_post();
                                $data = get_data(["cover-photo", "experience", "get-permalink", "location-post", ["location-en", "country-post", ["country"]]], array());
                                if ($data["location-post-location-en"] == $location) {
                                    $filtered[] = $data;
                                }
                            }
                            wp_reset_postdata();
                        }

                        if ( !empty($filtered) ) {
                            echo '<div id="experiences-panel" class="panel-outer">
                            <h3><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"><path d="M480-390Zm-132-53 55 37 77-39 77 39 53-35-40-79H386l-38 77ZM209-160h541L646-369l-83 55-83-41-83 41-85-56-103 210ZM80-80l234-475q10-20 29.5-32.5T386-600h54v-280h280l-40 80 40 80H520v120h50q23 0 42 12t30 32L880-80H80Z"/></svg>Top Experiences in ' . $location . '</h3>
                            <div class="panel">';
                            foreach ($filtered as $i => $data) {
                                if ( !empty($data['cover-photo']) ) {
                                    $bg = "url('" . $data["cover-photo"]["url"] . "')";
                                    echo '<a href="' . $data["get-permalink"] . '" class="card-outer" style="--bg: ' . $bg . '"><div class="card"></div>
                                    <h5>' . $data["experience"] . '</h5>
                                    </a>';
                                }
                            }
                            echo '</div></div>';
                            
                        }

                        $args = array(
                            'post_type' => 'bites',
                            'posts_per_page' => 12,
                            'orderby' => 'meta_value_num',
                            'order' => 'DESC',
                            'meta_key' => 'rating',
                            'meta_query' => array(
                                array(
                                    'key' => 'active-date',
                                    'compare' => '<=',
                                    'value' => $current_date,
                                    'type' => 'NUMERIC'
                                ),
                                array(
                                    'key' => 'location-post', // Adjust the key to your actual meta key
                                    'value' => serialize(get_post()), // Serialize the post object
                                    'compare' => '=', // Change the comparison as needed
                                    'type' => 'BINARY' // Use BINARY type for serialized data
                                ),
                            )
                        );
                    
                        $latest_travel = new WP_Query( $args );
                        $filtered = [];
                        if ( $latest_travel->have_posts() ) {
                            while ( $latest_travel->have_posts() ) {
                                $latest_travel->the_post();
                                $data = get_data(["cover-photo", "restaurant", "dish", "get-permalink", "location-post", ["location-en", "country-post", ["country"]]], array());
                                if ($data["location-post-location-en"] == $location) {
                                    $filtered[] = $data;
                                }
                            }
                            wp_reset_postdata();
                        }

                        if ( !empty($filtered) ) {
                            echo '<div id="experiences-panel" class="panel-outer">
                            <h3><svg xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd" viewBox="0 0 24 24"><path d="M23.999 12.149a11.985 11.985 0 0 1-4.706 9.378A11.951 11.951 0 0 1 12.095 24 12.005 12.005 0 0 1 0 12c3.966 1.066 7.682-1.993 6-6 4.668.655 6.859-2.389 6.077-6a12.003 12.003 0 0 1 11.922 12.149zM8.423 8.026c-.065 3.393-2.801 5.868-6.182 6.166 1.008 4.489 5.015 7.807 9.759 7.807 5.262 0 9.576-4.072 9.97-9.229.369-4.818-2.755-9.357-7.796-10.534-.277 2.908-2.381 5.357-5.751 5.79zM13.5 17a1.5 1.5 0 1 1-.001 3.001A1.5 1.5 0 0 1 13.5 17zM8 14.147a2 2 0 1 1-.001 4.001A2 2 0 0 1 8 14.147zM18 12a2 2 0 1 1-.001 4.001A2 2 0 0 1 18 12zm-5 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm2.5-5a1.5 1.5 0 1 1-.001 3.001A1.5 1.5 0 0 1 15.5 7zM3 7a1 1 0 1 1 0 2 1 1 0 0 1 0-2zM1.5 3a1.5 1.5 0 1 1-.001 3.001A1.5 1.5 0 0 1 1.5 3zm6-2a1.5 1.5 0 1 1-.001 3.001A1.5 1.5 0 0 1 7.5 1zM4 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>The Best Bites in ' . $location . '</h3>
                            <div class="panel">';
                            foreach ($filtered as $i => $data) {
                                echo $data["restaurant"];
                                if ( !empty($data['cover-photo']) ) {
                                    $bg = "url('" . $data["cover-photo"]["url"] . "')";
                                    echo '<a href="' . $data["get-permalink"] . '" class="card-outer" style="--bg: ' . $bg . '"><div class="card"></div>
                                    <h5>' . $data["restaurant"] . '</h5>
                                    </a>';
                                }
                            }
                            echo '</div></div>';
                            
                        }
?>
                    <!--/div-->
                </section>
<?php
                $post_id = get_the_ID();
                $post_content = get_post_field('post_content', $post_id);
                if ( !empty($post_content) ) {
                    echo '<section id="images-section" class="content section">
                    <h3>LANDSCAPE</h3>
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
                $content = ["TRAVELER'S NOTES" => "travelers-notes", "NOTABLE FEATURES" => "known-for", "ACTIVITIES" => ["Popular Activities" => "activities", "Underrated Destinations" => "underrated"], "NEIGHBORHOODS" => "neighborhoods", "HOW TO GET HERE" => "arrival"];
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