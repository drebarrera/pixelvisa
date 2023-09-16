<?php

    function register_post_types() {
        register_post_type( 'travel_locations',
            array(
                'labels' => array(
                    'name' => __( 'Travel Locations' ),
                    'singular_name' => __( 'Travel Location' )
                ),
                'public' => true,
                'has_archive' => true,
            )
        );
        register_post_type( 'countries',
            array(
                'labels' => array(
                    'name' => __( 'Countries' ),
                    'singular_name' => __( 'Country' )
                ),
                'public' => true,
                'has_archive' => true,
            )
        );
        register_post_type( 'videos',
            array(
                'labels' => array(
                    'name' => __( 'Videos' ),
                    'singular_name' => __( 'Video' )
                ),
                'public' => true,
                'has_archive' => true,
            )
        );
        register_post_type( 'bites',
            array(
                'labels' => array(
                    'name' => __( 'Bites' ),
                    'singular_name' => __( 'Bites' )
                ),
                'public' => true,
                'has_archive' => true,
            )
        );
        register_post_type( 'travel_logs',
            array(
                'labels' => array(
                    'name' => __( 'Travel Logs' ),
                    'singular_name' => __( 'Travel Log' )
                ),
                'public' => false,
                'show_ui' => true,
                'has_archive' => true,
            )
        );
        register_post_type( 'experiences',
            array(
                'labels' => array(
                    'name' => __( 'Experiences' ),
                    'singular_name' => __( 'Experience' )
                ),
                'public' => true,
                'has_archive' => true,
            )
        );
    }

    function latest_travel_content($content) {
        $current_date = current_time('Ymd');  // Get current date in 'Ymd' format

        $args = array(
            'post_type' => 'travel_locations',
            'posts_per_page' => 1,
            'orderby' => 'meta_value_num',
            'order' => 'DESC',
            'meta_key' => 'active-date',
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
                return get_field($content);
            }
        }
    }

    function leaflet() {
        global $post;
        if (is_front_page()) {
            wp_enqueue_style('leaflet-css', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css');
            wp_enqueue_script('leaflet-js', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js', array(), null, true);
            wp_enqueue_script('leaflet-geodesic-js', 'https://cdn.jsdelivr.net/npm/leaflet.geodesic', array('leaflet-js'), null, true);
            wp_enqueue_script('custom-leaflet', get_template_directory_uri() . '/scripts/leaflet/index-leaflet.js', array('leaflet-js', 'leaflet-geodesic-js'), null, true);
        } else {
            $template_name = str_replace(".php", "", get_post_meta( $post->ID, '_wp_page_template', true ));
            if ( $template_name === 'map' ) {
                wp_enqueue_style('leaflet-css', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css');
                wp_enqueue_script('leaflet-js', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js', array(), null, true);
                wp_enqueue_script('leaflet-geodesic-js', 'https://cdn.jsdelivr.net/npm/leaflet.geodesic', array('leaflet-js'), null, true);
                wp_enqueue_script('custom-leaflet', get_template_directory_uri() . '/scripts/leaflet/' . $template_name . '-leaflet.js', array('leaflet-js', 'leaflet-geodesic-js'), null, true);
            }
        }
    }

    function styles() {
        wp_enqueue_style('main_styles', get_stylesheet_uri());
        wp_enqueue_style('fonts', get_template_directory_uri() . '/styles/fonts.css');
    }

    function scripts() {
        wp_enqueue_script('jquery');
    }

    function page_style($page) {
        wp_enqueue_style('page_style', get_template_directory_uri() . '/styles/pages/' . $page . '.css', array(), '1.0.0');
    }

    function page_script($page) {
        wp_enqueue_script('page_script', get_template_directory_uri() . '/scripts/pages/' . $page . '.js', array('jquery'), '1.0.0', true);
    }

    function get_data($fields, $ret_arr, $prefix="") {
        global $post;
        $curr = null;
        $new_prefix = null;
        for ($i = 0; $i < count($fields); $i++) {
            if ( $fields[$i] == "get-permalink") $ret_arr[$prefix . $fields[$i]] = get_permalink();
            else if ( !is_array($fields[$i]) ) {
                $curr = get_field($fields[$i]);
                if ( !($curr instanceof WP_Post) ) $ret_arr[$prefix . $fields[$i]] = $curr;
                else $new_prefix = $fields[$i];
            }
            else if ( !empty($curr) ) {
                $orig_post = $post;
                $post = $curr;
                $ret_arr = get_data($fields[$i], $ret_arr, $prefix . $new_prefix . "-");
                $post = $orig_post;
            }
        }

        return $ret_arr;
    }

    function localize_map_data() {
        global $post;
        $template_name = str_replace(".php", "", get_post_meta( $post->ID, '_wp_page_template', true ));
        if (is_front_page() || $template_name === 'map') {
            $current_date = current_time('Ymd');  // Get current date in 'Ymd' format
            $map_data = array();
            
            $args = array(
                'post_type' => 'travel_logs',
                'orderby' => 'meta_value_num',
                'order' => 'ASC',
                'meta_key' => 'active-date',
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
            $state_last = "";
            if ( $latest_travel->have_posts() ) {
                while ( $latest_travel->have_posts() ) {
                    $latest_travel->the_post();
                    $map_data[] = get_data(["active-date","location-post", ["location-en", "latitude", "longitude", "location-lang", "city", "get-permalink", "country-post", ["country", "flag"]],"video-post", ["title", "get-permalink", "type", "latitude", "longitude"], "experience-post", ["experience", "get-permalink", "latitude", "longitude"]], array());
                }
            }

            if (is_front_page()) {
                for ($i = 0; $i < count($map_data); $i++) {
                    if ($i > 1 && $map_data[$i]["location-post-country-post-country"] == $map_data[$i - 1]["location-post-country-post-country"]) unset($map_data[$i]);
                }
            }

            wp_localize_script('custom-leaflet', 'map_data', $map_data);
        }
    }

    add_action( 'init', 'register_post_types' );
    add_action('wp_enqueue_scripts', 'styles');
    add_action('wp_enqueue_scripts', 'scripts');
    add_action('wp_enqueue_scripts', 'leaflet');
    add_action('wp_enqueue_scripts', 'localize_map_data');
    add_filter('show_admin_bar', '__return_false');

?>