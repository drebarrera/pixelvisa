<?php
    /*
    Template Name: Countries
    */
    get_header();

    if ( have_posts() ) :
        while ( have_posts() ) : the_post();
            $photo = get_field("cover-photo");
            if ( !empty($photo) ) :
                $url = "url('" . $photo["url"] . "')";
?>
                <section id="title-section" style="--bg: <?php echo $url ?>;">
                    <h2><?php echo strtoupper(get_field("country")); ?></h2>
                </section>
                <section id="basic-info-section" class="content section">
                    <div id="info-panel">
                        <h3>QUICK FACTS</h3>
<?php
                        $country_keys = array("COUNTRY" => ["country", "country-lang"], "REGION" => "region", "CAPITAL CITY" => "capital-city", "FLAG" => "flag", "LANGUAGES SPOKEN" => "language", "MAJOR RELIGIONS" => "religion", "GOVERNMENT" => "government", "CURRENCY" => "currency", "EXCHANGE RATE" => "exchange-rate", "TIMEZONES" => "timezones", "ABBREVIATIONS" => ["abbrv-2","abbrv-3"], "TELEPHONE COUNTRY CODE" => "phone-cc", "EMERGENCY TELEPHONE NUMBER" => "emergency-number", "TALLEST PEAKS" => "peaks", "BUS SERVICES" => "bus-networks", "TRAIN SERVICES" => "train-networks", "POPULAR AIRLINES" => "air-networks", "ECOSYSTEM" => "habitats", "DANGEROUS WILDLIFE" => "dangerous-wildlife", "POPULAR MOBILE CARRIER" => "mobile-carrier", "LOCAL PINT" => "beer", "LAST UPDATED" => "active-date");
                        foreach ($country_keys as $header => $field) {
                            $value = [];
                            if (is_array($field)) {
                                for ($i = 0; $i < count($field); $i++) {
                                    $value[] = get_field($field[$i]);
                                }
                                $value = implode(" ", $value);
                            } else $value = get_field($field);

                            // Field-Specific Formatting
                            if ($header == "CURRENCY") {
                                $currencies = explode(",", $value);
                                $value = [];
                                for ($i = 0; $i < count($currencies); $i++) {
                                    $currency_info = explode("-", $currencies[$i]);
                                    $value[] = $currency_info[1] . " (" . $currency_info[0] . "-" . $currency_info[2] . ")";
                                }
                                $value = implode(", ", $value);
                            } else if ($header == "LAST UPDATED") {
                                $value = preg_replace('/(\d{4})(\d{2})(\d{2})/', '$3/$2/$1', $value);
                            } else if ($header == "EXCHANGE RATE") {
                                $currency = explode("-", explode(",", get_field("currency"))[0])[0];
                                $value = "1.00 USD" . " = " . $value . " " . $currency;
                            }
                            
                            if ( !empty($value) ) echo '<h4>' . $header . '</h4><p>' . $value . '</p>';
                        }
?>
                    </div>
                    <div id="dynamic-section">
                        <div id="map"></div>
<?php
                        $current_date = current_time('Ymd'); 
                        $country = get_field("country");

                        $args = array(
                            'post_type' => 'cities',
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
                                $data = get_data(["cover-photo", "location-lang", "city", "get-permalink", "country-post", ["country"]], array());
                                if ($data["country-post-country"] == $country) {
                                    $filtered[] = $data;
                                }
                            }
                            wp_reset_postdata();
                        }

                        if ( !empty($filtered) ) {
                            echo '<div id="travel-locations-panel" class="panel-outer">
                            <h3><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve"><path d="M503.551 449.951h-43.377V146.709a8.449 8.449 0 0 0-8.449-8.449H441.59V87.565a8.449 8.449 0 0 0-8.449-8.449h-12.673V58.839a8.449 8.449 0 0 0-8.449-8.449h-7.603V38.561c0-4.666-3.782-8.449-8.449-8.449s-8.449 3.783-8.449 8.449v11.828h-7.603a8.449 8.449 0 0 0-8.449 8.449v20.277h-12.673a8.449 8.449 0 0 0-8.449 8.449v50.696h-10.136a8.449 8.449 0 0 0-8.449 8.449v220.998h-58.018V189.898a8.449 8.449 0 0 0-8.449-8.449H215.16v-38.734c32.34-3.744 57.534-31.283 57.534-64.61 0-35.874-29.185-65.059-65.059-65.059-29.129 0-54.315 19.203-62.388 46.564H118.85a8.45 8.45 0 0 0-8.449 8.449v144.86H60.277a8.45 8.45 0 0 0-8.449 8.449v228.583H8.449a8.45 8.45 0 0 0 0 16.898h495.102c4.667 0 8.449-3.783 8.449-8.449s-3.782-8.449-8.449-8.449zm-393.154 0H68.725v-24.414h21.844a8.45 8.45 0 0 0 0-16.898H68.725v-14.871h21.844a8.45 8.45 0 0 0 0-16.898H68.725v-14.871h21.844a8.45 8.45 0 0 0 0-16.898H68.725V330.23h21.844a8.45 8.45 0 0 0 0-16.898H68.725V298.46h21.844a8.45 8.45 0 0 0 0-16.898H68.725v-14.871h21.844a8.45 8.45 0 0 0 0-16.898H68.725v-19.976h41.672v220.134zM388.362 67.289h15.206v11.828h-15.206V67.289zM367.24 96.014h57.45v42.243h-57.45V96.014zM207.631 29.943c26.555 0 48.161 21.604 48.161 48.161 0 23.996-17.642 43.945-40.635 47.569V68.059a8.45 8.45 0 0 0-8.449-8.449h-43.573c7.317-17.663 24.675-29.667 44.496-29.667zm-30.209 52.624a8.45 8.45 0 0 0-8.449 8.449v344.431c0 .037.005.072.006.109v14.394h-41.683V76.509h70.962v104.94h-12.387V91.016a8.45 8.45 0 0 0-8.449-8.449zm50.129 293.589v73.795h-41.675V198.347h70.962v169.36H236a8.45 8.45 0 0 0-8.449 8.449zm178.553 73.795H244.45v-65.345h161.653v65.345zm37.17 0h-20.273v-73.795a8.449 8.449 0 0 0-8.449-8.449h-65.897V155.159h94.619v294.792zm60.277 32.105H8.449a8.45 8.45 0 0 0 0 16.898h495.102a8.45 8.45 0 0 0 0-16.898z"/><path d="M148.133 82.567a8.45 8.45 0 0 0-8.449 8.449v344.431a8.45 8.45 0 0 0 16.898 0V91.016a8.448 8.448 0 0 0-8.449-8.449zm58.579 121.486a8.45 8.45 0 0 0-8.449 8.449v223.294a8.45 8.45 0 0 0 16.898 0V212.502a8.45 8.45 0 0 0-8.449-8.449zm29.289 0a8.45 8.45 0 0 0-8.449 8.449v133.613a8.45 8.45 0 0 0 16.898-.001V212.502a8.45 8.45 0 0 0-8.449-8.449zm141.381-37.626a8.449 8.449 0 0 0-8.449 8.449v171.238c0 4.666 3.782 8.449 8.449 8.449s8.449-3.783 8.449-8.449V174.876a8.449 8.449 0 0 0-8.449-8.449zm37.171-.003a8.449 8.449 0 0 0-8.449 8.449v171.24c0 4.666 3.782 8.449 8.449 8.449s8.449-3.782 8.449-8.449v-171.24a8.449 8.449 0 0 0-8.449-8.449zm-30.979-63.001a8.449 8.449 0 0 0-8.449 8.449v10.527a8.449 8.449 0 0 0 8.449 8.449 8.449 8.449 0 0 0 8.449-8.449v-10.527a8.449 8.449 0 0 0-8.449-8.449zm24.783 0a8.449 8.449 0 0 0-8.449 8.449v10.527a8.449 8.449 0 0 0 8.449 8.449 8.449 8.449 0 0 0 8.449-8.449v-10.527a8.45 8.45 0 0 0-8.449-8.449zm-21.12 292.073H263.315a8.45 8.45 0 0 0 0 16.898h123.922c4.667 0 8.449-3.783 8.449-8.449s-3.781-8.449-8.449-8.449zm0 25.535H263.315a8.45 8.45 0 0 0 0 16.898h123.922c4.667 0 8.449-3.783 8.449-8.449s-3.781-8.449-8.449-8.449z"/></svg>My Favorite Cities in ' . $country . '</h3>
                            <div class="panel">';
                            foreach ($filtered as $i => $data) {
                                if ( !empty($data['cover-photo']) ) {
                                    $bg = "url('" . $data["cover-photo"]["url"] . "')";
                                    echo '<a href="' . $data["get-permalink"] . '" class="card-outer" style="--bg: ' . $bg . '"><div class="card"></div>
                                    <h5>' . $data["city"] . '</h5>
                                    <p>' . $data["location-lang"] . '</p>
                                    </a>';
                                }
                            }
                            echo '</div></div>';
                        }

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
                                if ($data["location-post-country-post-country"] == $country) {
                                    $filtered[] = $data;
                                }
                            }
                            wp_reset_postdata();
                        }

                        if ( !empty($filtered) ) {
                            echo '<div id="experiences-panel" class="panel-outer">
                            <h3><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"><path d="M480-390Zm-132-53 55 37 77-39 77 39 53-35-40-79H386l-38 77ZM209-160h541L646-369l-83 55-83-41-83 41-85-56-103 210ZM80-80l234-475q10-20 29.5-32.5T386-600h54v-280h280l-40 80 40 80H520v120h50q23 0 42 12t30 32L880-80H80Z"/></svg>Top Experiences in ' . $country . '</h3>
                            <div class="panel">';
                            foreach ($filtered as $i => $data) {
                                if ( !empty($data['cover-photo']) ) {
                                    $bg = "url('" . $data["cover-photo"]["url"] . "')";
                                    echo '<a href="' . $data["get-permalink"] . '" class="card-outer" style="--bg: ' . $bg . '"><div class="card"></div>
                                    <h5>' . $data["experience"] . '</h5>
                                    <p>' . $data["location-post-location-en"] . '</p>
                                    </a>';
                                }
                            }
                            echo '</div></div>';
                            
                        }

                        $args = array(
                            'post_type' => 'bites',
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
                                $data = get_data(["cover-photo", "restaurant", "dish", "get-permalink", "location-post", ["location-en", "country-post", ["country"]]], array());
                                if ($data["location-post-country-post-country"] == $country) {
                                    $filtered[] = $data;
                                }
                            }
                            wp_reset_postdata();
                        }

                        if ( !empty($filtered) ) {
                            echo '<div id="experiences-panel" class="panel-outer">
                            <h3><svg xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd" viewBox="0 0 24 24"><path d="M23.999 12.149a11.985 11.985 0 0 1-4.706 9.378A11.951 11.951 0 0 1 12.095 24 12.005 12.005 0 0 1 0 12c3.966 1.066 7.682-1.993 6-6 4.668.655 6.859-2.389 6.077-6a12.003 12.003 0 0 1 11.922 12.149zM8.423 8.026c-.065 3.393-2.801 5.868-6.182 6.166 1.008 4.489 5.015 7.807 9.759 7.807 5.262 0 9.576-4.072 9.97-9.229.369-4.818-2.755-9.357-7.796-10.534-.277 2.908-2.381 5.357-5.751 5.79zM13.5 17a1.5 1.5 0 1 1-.001 3.001A1.5 1.5 0 0 1 13.5 17zM8 14.147a2 2 0 1 1-.001 4.001A2 2 0 0 1 8 14.147zM18 12a2 2 0 1 1-.001 4.001A2 2 0 0 1 18 12zm-5 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm2.5-5a1.5 1.5 0 1 1-.001 3.001A1.5 1.5 0 0 1 15.5 7zM3 7a1 1 0 1 1 0 2 1 1 0 0 1 0-2zM1.5 3a1.5 1.5 0 1 1-.001 3.001A1.5 1.5 0 0 1 1.5 3zm6-2a1.5 1.5 0 1 1-.001 3.001A1.5 1.5 0 0 1 7.5 1zM4 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>The Best Bites in ' . $country . '</h3>
                            <div class="panel">';
                            foreach ($filtered as $i => $data) {
                                if ( !empty($data['cover-photo']) ) {
                                    $bg = "url('" . $data["cover-photo"]["url"] . "')";
                                    echo '<a href="' . $data["get-permalink"] . '" class="card-outer" style="--bg: ' . $bg . '"><div class="card"></div>
                                    <h5>' . $data["dish"] . '</h5>
                                    <p>' . $data["location-post-location-en"] . '</p>
                                    </a>';
                                }
                            }
                            echo '</div></div>';
                            
                        }
?>
                    </div>
                </section>
<?php
                        $post_id = get_the_ID();
                        $post_content = get_post_field('post_content', $post_id);
                        if ( !empty($post_content) ) {
                            echo '<section id="images-section" class="content section">
                            <h3>COUNTRY LANDSCAPE</h3>
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
                $content = ["TRAVELER'S NOTES" => "travelers-notes", "NOTABLE FEATURES" => "known-for", "DESTINATIONS" => ["Popular Destinations" => "destinations", "Underrated Destinations" => "underrated"], "HOLIDAYS" => "holidays", "MONEY" => ["" => "currency-description", "Spending Power" => "spending-power"], "LANGUAGE" => ["Language Structure" => "language-description", "Beginners Guide" => "language-guide"], "GREEN CULTURE" => "green-culture", "SEX CULTURE" => "sex-culture"];
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
                            echo '<div class="item">' . parseText($data, ['list' => '<h4>$1</h4>', 'sublist' => '<p class="subtopic">$2</p><b>$3</b>', 'topic' => '<div><span style="font-weight: 600; color: var(--green);">$3</span>$4</div>']) . '</div>
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