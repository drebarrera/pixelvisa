<?php
    get_header();
    page_style("index");
    page_script("index");
?>

    <section id="hero" class="window" style="--bg: url('<?php $photo = latest_travel_content("cover-photo"); if ( !empty($photo) ){ echo $photo["url"]; }?>')">
        <h2 id="pixelvisa-lang"><?php echo latest_travel_content("pixel-visa-lang") ?></h2>
        <em id="subtitle">Hello From</em>
        <div id="location">
            <span class="material-symbols-outlined">pin_drop</span>
            <p id="location-lang"><?php echo latest_travel_content("location-lang") ?></p>
        </div>
        <p id="location-en"><?php echo latest_travel_content("location-en") ?></p>
    </section>
    <section id="map-section">
        <h3>Travel the World With Me <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill-rule="evenodd" clip-rule="evenodd"><path d="M23 8a1 1 0 0 0-1-1H10a1 1 0 0 0-1 1v15a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V8zm-3 12h-8v1h8v-1zM10 5a3 3 0 0 0-3 3v11.583L1.094 6.917a.996.996 0 0 1 .484-1.329L13.36.094a1 1 0 0 1 1.329.484L16.751 5H10zm7.082 10.667h-2.164c.309 1.234.849 2 1.082 2.333.233-.333.773-1.1 1.082-2.333zm2.555 0h-1.87a7.073 7.073 0 0 1-.926 2.244 4.011 4.011 0 0 0 2.796-2.244zm-5.404 0h-1.87a4.011 4.011 0 0 0 2.796 2.244 7.103 7.103 0 0 1-.926-2.244zM17.214 13h-2.427a6.91 6.91 0 0 0 0 2h2.426a6.945 6.945 0 0 0 .001-2zm-3.1 0h-1.988a4.024 4.024 0 0 0 0 2h1.988a7.609 7.609 0 0 1 0-2zm5.76 0h-1.988a7.609 7.609 0 0 1 0 2h1.988a4.018 4.018 0 0 0 0-2zm-2.792-.667A6.687 6.687 0 0 0 16 10c-.233.333-.774 1.099-1.082 2.333h2.164zm-2.849 0a7.09 7.09 0 0 1 .926-2.244 4.013 4.013 0 0 0-2.796 2.244h1.87zm5.404 0a4.013 4.013 0 0 0-2.796-2.244c.422.661.74 1.423.926 2.244h1.87z"/></svg></h3>
        <div id="underlayer" class="map">
            <div id="ring1" class="ring"></div>
            <div id="ring2" class="ring"></div>
            <div id="ring3" class="ring"></div>
        </div>
        <div id="map" class="map"></div>
        <div id="overlayer" class="map">
            <a href="/map" class="button"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"><path d="m600-120-240-84-186 72q-20 8-37-4.5T120-170v-560q0-13 7.5-23t20.5-15l212-72 240 84 186-72q20-8 37 4.5t17 33.5v560q0 13-7.5 23T812-192l-212 72Zm-40-98v-468l-160-56v468l160 56Zm80 0 120-40v-474l-120 46v468Zm-440-10 120-46v-468l-120 40v474Zm440-458v468-468Zm-320-56v468-468Z"/></svg>Explore the Pixel Visa Map</a>
            <div id="dre-travel"></div>
        </div>
    </section>
    <section id="about-section">
        <div class="content">
            <div id="self-portrait"></div>
            <div id="text-info">
                <h3>Hello World.</h3>
                <p>Ever since I was a kid, I've had an obsession with the world.</p>
                <p>Now I am finally traveling it!</p>
                <br>
                <p>My name is Dre and I am a lifelong adventurer, ambitious software engineer, and creative mind. Pixel Visa is a creation of mine to document my travels around the globe. I have visited over 20 different countries in my lifetime, but I am now embarking on a journey which will take me across the world.</p>
                <br>
                <p style="font-weight: 500; font-family: Lora; font-size: 17px;line-height: 1.2;">Follow me while I explore what this world has to offer.<br><br></p>
                <a href="/map" class="button"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 0C8.852 0 6 2.553 6 5.702c0 4.682 4.783 5.177 6 12.298 1.217-7.121 6-7.616 6-12.298C18 2.553 15.149 0 12 0zm0 8a2 2 0 1 1-.001-3.999A2 2 0 0 1 12 8zm12 16-6.707-2.427L12 24l-5.581-2.427L0 24l4-9 3.96-1.584c.38.516.741 1.08 1.061 1.729l-3.523 1.41-1.725 3.88 2.672-1.01 1.506-2.687-.635 3.044 4.189 1.789L12 19.55l.465 2.024 4.15-1.89-.618-3.033 1.572 2.896 2.732.989-1.739-3.978-3.581-1.415c.319-.65.681-1.215 1.062-1.731L20.064 15 24 24z"/></svg></svg>Where am I now?</a>
            </div>
        </div>
    </section>
    <!--section id="video-section">
        <div class="content">
            <div id="text-info">
                <h3>Capturing the Moment</h3>
                <p>Follow me as I capture moments from around the globe.</p>
                <p>I post video content of my travels weekly.</p>
                <br>
                <p>My name is Dre and I am a lifelong adventurer, ambitious software engineer, and creative mind. Pixel Visa is a creation of mine to document my travels around the globe. I have visited over 20 different countries in my lifetime, but I am now embarking on a journey which will take me across the world.</p>
                <br>
                <p style="font-weight: 500; font-family: Lora;">Follow me while I explore what this world has to offer.</p>
            </div>
            <div id="self-portrait"></div>
        </div>
    </section-->
    <section id="places-section">
        <p id="places-supertitle">~ Some of My Favorite Places ~</p>
        <h3>On Planet Earth <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M11.239 7.237c-.004-.009-.288-.017-.24-.078l.137-.085c.013-.077.072-.162-.007-.304l.047-.125-.1.029s.141-.606.33-.332l-.08.093c.122.122.155.426.195.623.115.06.294.071.088.175.106-.018-.561.286-.648.161-.065-.076.288-.127.278-.157zm-.715-.159c-.077.078.003.128.082.094.114-.05.269-.048.284-.202l.073-.091-.101-.135c-.06-.012-.1.064-.137.095l-.066.017-.062.08.007.044-.08.098zm7 9.167l-.733-1.206-.724-1.186c-.73-1.194-1.388-2.276-1.961-3.296l-.07.067c-.376.156-.942-.509-1.339-.531.192.03.018-.49.018-.524-.153-.189-1.123.021-1.378.055-.479.063-.979.057-1.346.355-.258.21-.262.551-.524.716-.17.106-.356.072-.502.209-.258.245-.553.607-.697.929-.062.135.077.458.043.632-.336 1.063.085 2.538 1.375 2.701.312.039.638.209.955.114.252-.076.474-.248.745-.268.377-.025.22.529.737.379.251-.074.365.172.365.359-.084.391-.268.609.088.883.242.188.442.456.486.78.026.182.196.494-.015.602-.149.075-.259.507-.257.649.031.165.365.481.466.621.146.2.039.436.158.663.122.232.237.41.323.645.111.324.958-.007 1.156-.006.673.004 1.014-.944 1.487-1.235.267-.165.192-.616.51-.848.296-.215.608-.344.636-.741.021-.344-.259-1.062-.104-1.353l.102-.165zm-7.301-7.76c.041.172-.119.645-.154.795-.031.138.442.226.415.295.004-.008.642-.22.705-.275l.144-.323c.121-.081.248-.146.384-.196l.164-.285c.056-.021.71-.123.756-.101.165.075.469.389.583.531l.041.032c-.326-.67-.59-1.314-.796-1.942l-.083.036c-.222 0-.528.251-.663.405-.095.104-.669.337-.732.33.33.035.314.276.288.482-.068.476-1.096.035-1.052.216zm10.904 5.049c-.277 4.807-4.253 8.623-9.13 8.623-2.603 0-4.951-1.086-6.618-2.83-.198-.208-.346-.7-.02-.9l.331-.085c.259-.22-.242-1.111-.044-1.254.617-.441.324-.982-.055-1.429-.161-.19-1.043-1.1-1.143-.937.074-.249-.16-.85-.302-1.087-.239-.398-.553-.643-.679-1.081-.05-.174-.05-.704-.153-.826-.041-.05-.358-.185-.347-.257.305-1.82 1.147-3.458 2.364-4.751l.821-.33c.515-.773.545-.173 1.008-.375.154 0 .331-.634.496-.734.289-.185.068-.185.015-.27-.112-.184 2.411-1.103 2.453-.938.034.14-1.249.809-1.108.788-.326.043-.388.627-.328.625.163-.005 1.182-.774 1.657-.61.466.161 1.301-.37 1.627-.64l.04-.038c.029-.761.195-1.494.481-2.172l-.493-.026c-6.075 0-11 4.925-11 11s4.925 11 11 11c6.074 0 11-4.925 11-11 0-.764-.078-1.509-.227-2.229-.491.864-1.044 1.779-1.646 2.763zm1.873-9.1c0 2.45-1.951 5.373-4.5 9.566-2.549-4.193-4.5-7.116-4.5-9.566 0-2.449 2.139-4.434 4.5-4.434s4.5 1.985 4.5 4.434zm-2.75.066c0-.966-.784-1.75-1.75-1.75s-1.75.784-1.75 1.75.784 1.75 1.75 1.75 1.75-.784 1.75-1.75z"/></svg></h3>
        <div id="countries-outer" class="place-outer">
            <h4><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="white" d="M12 2c5.514 0 10 4.486 10 10s-4.486 10-10 10S2 17.514 2 12 6.486 2 12 2zm0-2C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm1.608 9.476L12 4l-1.611 5.477a3.019 3.019 0 0 0-1.019 1.107L4 12l5.37 1.416c.243.449.589.833 1.019 1.107L12 20l1.618-5.479a3.004 3.004 0 0 0 1.014-1.109L20 12l-5.368-1.413a2.996 2.996 0 0 0-1.024-1.111zM12 13.5a1.5 1.5 0 1 1 .001-3.001A1.5 1.5 0 0 1 12 13.5zm5.25 3.75-2.573-1.639c.356-.264.67-.579.935-.934l1.638 2.573zm-2.641-8.911 2.64-1.588-1.588 2.639a4.486 4.486 0 0 0-1.052-1.051zm-5.215 7.325L6.75 17.25l1.589-2.641c.29.408.646.764 1.055 1.055zm-1.005-6.34L6.751 6.751l2.573 1.638a4.456 4.456 0 0 0-.935.935z"/></svg> Countries I've Explored</h4>
            <div id="countries" class="place">
<?php
                $current_date = current_time('Ymd');  // Get current date in 'Ymd' format

                $args = array(
                    'post_type' => 'countries',
                    'posts_per_page' => 15,
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
                if ( $latest_travel->have_posts() ) {
                    while ( $latest_travel->have_posts() ) {
                        $latest_travel->the_post();
                        $photo = get_field("cover-photo");
                        $country = get_field("country");
                        $flag = get_field("flag");
                        if ( !empty($photo) ) {
                            $bg = "url('" . $photo["url"] . "')";
                            echo '<a href="' . get_permalink() . '" class="card" style="--bg: ' . $bg . '">
                                <h5>' . $country . ' ' . $flag . '</h5>
                            </a>';
                        } 
                    }
                }
?>  
            </div>
        </div>
        <div id="bites-outer" class="place-outer">
            <h4><svg xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd" viewBox="0 0 24 24"><path fill="white" d="M23.999 12.149a11.985 11.985 0 0 1-4.706 9.378A11.951 11.951 0 0 1 12.095 24 12.005 12.005 0 0 1 0 12c3.966 1.066 7.682-1.993 6-6 4.668.655 6.859-2.389 6.077-6a12.003 12.003 0 0 1 11.922 12.149zM8.423 8.026c-.065 3.393-2.801 5.868-6.182 6.166 1.008 4.489 5.015 7.807 9.759 7.807 5.262 0 9.576-4.072 9.97-9.229.369-4.818-2.755-9.357-7.796-10.534-.277 2.908-2.381 5.357-5.751 5.79zM13.5 17a1.5 1.5 0 1 1-.001 3.001A1.5 1.5 0 0 1 13.5 17zM8 14.147a2 2 0 1 1-.001 4.001A2 2 0 0 1 8 14.147zM18 12a2 2 0 1 1-.001 4.001A2 2 0 0 1 18 12zm-5 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm2.5-5a1.5 1.5 0 1 1-.001 3.001A1.5 1.5 0 0 1 15.5 7zM3 7a1 1 0 1 1 0 2 1 1 0 0 1 0-2zM1.5 3a1.5 1.5 0 1 1-.001 3.001A1.5 1.5 0 0 1 1.5 3zm6-2a1.5 1.5 0 1 1-.001 3.001A1.5 1.5 0 0 1 7.5 1zM4 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg> Global Bites - Some of My Favorite Dishes</h4>
            <div id="countries" class="place">
<?php
                $current_date = current_time('Ymd');  // Get current date in 'Ymd' format

                $args = array(
                    'post_type' => 'bites',
                    'posts_per_page' => 15,
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
                            'key' => 'rating',
                            'compare' => '>=',
                            'value' => 4.0,
                            'type' => 'NUMERIC'
                        ),
                    )
                );

                $latest_travel = new WP_Query( $args );
                if ( $latest_travel->have_posts() ) {
                    while ( $latest_travel->have_posts() ) {
                        $latest_travel->the_post();
                        $photo = get_field("cover-photo");
                        $dish = get_field("dish");
                        $flag = get_field("flag");
                        if ( empty($flag) ) {
                            $location_post = get_field("location-post");
                            if ( !empty($location_post) ) {
                                $post = get_post($location_post);
                                $flag = get_field('flag');
                                if ( empty($flag) ) {
                                    $country_post = get_field("country-post");
                                    if ( !empty($country_post) ) {
                                        $post = get_post($country_post);
                                        $flag = get_field('flag');
                                        wp_reset_postdata();
                                    }
                                }
                                wp_reset_postdata();
                            }
                        }
                        
                        if ( !empty($photo) ) {
                            $bg = "url('" . $photo["url"] . "')";
                            echo '<a href="' . get_permalink() . '" class="card" style="--bg: ' . $bg . '">
                                <h5>' . $dish . ' ' . $flag . '</h5>
                            </a>';
                        } 
                    }
                }
?>  
            </div>
        </div>
        <div class="content">
            <h4>All the Best Experiences <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M18.028 24h-.018a.5.5 0 0 1-.499-.483c-.05-1.462.19-2.847 2.265-3.08.795-.089.858-.367.996-.977.229-1.008.607-1.922 2.701-2.032a.49.49 0 0 1 .526.473.5.5 0 0 1-.473.526c-1.512.079-1.618.547-1.778 1.254-.152.667-.359 1.581-1.861 1.751-1.016.113-1.432.423-1.377 2.051a.5.5 0 0 1-.482.517zM9.686 5.286c.241.213.53.366.842.444l3.566.896c.3.076.617.051.903-.07 1.082-.461 3.862-1.684 5.062-2.155.76-.299 1.268.63.655 1.097C19.324 6.56 15 9.584 15 9.584l-.862 3.648s1.785 1.86 2.544 2.7c.423.469.696.919.421 1.595-.481 1.181-1.457 3.477-1.908 4.547-.255.605-1.164.453-1.015-.322.217-1.128.781-4.016.781-4.016l-3.558-1.62s-.253 5.953-.327 7.296c-.019.341-.253.589-.582.588-.249-.001-.508-.173-.612-.596-.534-2.178-2.142-8.99-2.142-8.99-.209-.837-.329-1.53-.053-2.564L8.602 8S5.876 4.016 4.893 2.524c-.402-.611.356-1.18.808-.78l3.985 3.542zm-7.178 8.489-.853.511 2.708 4.524c-1.788.306-2.917 1.904-2.048 3.356.537.897 1.753 1.106 2.622.586 1.034-.619 1.774-1.952.979-3.284l-3.408-5.693zm17.721-5.193.904 1.669 1.867.344-1.308 1.376.249 1.882-1.712-.819-1.713.819.25-1.882-1.309-1.376 1.867-.344.905-1.669zM2.931 5.647-.003 8.582l2.934 2.935 2.935-2.935-2.935-2.935zM11.986.249a2.712 2.712 0 1 1 2.267 4.928A2.712 2.712 0 0 1 11.986.249z" fill="black"/></svg></h4>
            <div id="locations">
<?php
                $current_date = current_time('Ymd');  // Get current date in 'Ymd' format

                $args = array(
                    'post_type' => array('travel_locations', 'experiences'),
                    'posts_per_page' => 15,
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
                if ( $latest_travel->have_posts() ) {
                    while ( $latest_travel->have_posts() ) {
                        $latest_travel->the_post();
                        $current_post_type = get_post_type(get_the_ID());
                        if ($current_post_type == 'travel_locations') {
                            $photo = get_field("cover-photo");
                            $location = get_field("location-lang");
                            $name = get_field("location-en");
                            $city = get_field("city");
                        } elseif ($current_post_type == 'experiences') {
                            $photo = get_field("cover-photo");
                            $name = get_field("experience");
                            $location_post = get_field("location-post");
                            if ( !empty($location_post) ) {
                                $post = get_post($location_post);
                                $location = get_field("location-en");
                                $city = get_field("city");
                                wp_reset_postdata();
                            }
                        }
                        
                        if ( !empty($photo) ) {
                            $bg = "url('" . $photo["url"] . "')";
                            echo '<div class="card" style="--bg: ' . $bg . '">
                                <p class="location-name">' . $location . '</p>
                                <h5>' . $name . '</h5>
                                <a href="' . get_permalink() . '" class="button"><p>Explore ' . $city . '</p></a>
                            </div>';
                        } 
                    }
                }
?> 
            </div>
        </div>      
    </section>
<?php
    get_footer();
