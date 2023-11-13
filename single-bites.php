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
                </section>
<?php
            endif;
        endwhile;
    endif;
get_footer();