<?php

    function register_post_types() {
        register_post_type( 'cities',
            array(
                'labels' => array(
                    'name' => __( 'Cities' ),
                    'singular_name' => __( 'City' )
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
        register_post_type( 'general_assets',
            array(
                'labels' => array(
                    'name' => __( 'General Assets' ),
                    'singular_name' => __( 'General Asset' )
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
        register_post_type( 'coworking',
            array(
                'labels' => array(
                    'name' => __( 'Coworking Spaces' ),
                    'singular_name' => __( 'Coworking Space' )
                ),
                'public' => true,
                'has_archive' => true,
            )
        );
        register_post_type( 'stays',
            array(
                'labels' => array(
                    'name' => __( 'Stays' ),
                    'singular_name' => __( 'Stay' )
                ),
                'public' => true,
                'has_archive' => true,
            )
        );
    }

    function leaflet() {
        global $post;
        global $template;
        if (is_front_page()) {
            wp_enqueue_style('leaflet-css', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css');
            wp_enqueue_script('leaflet-js', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js', array(), null, true);
            wp_enqueue_script('leaflet-geodesic-js', 'https://cdn.jsdelivr.net/npm/leaflet.geodesic', array('leaflet-js'), null, true);
            wp_enqueue_script('custom-leaflet', get_template_directory_uri() . '/scripts/leaflet/index-leaflet.js', array('leaflet-js', 'leaflet-geodesic-js'), null, true);
        } else {
            $template_name = str_replace(".php", "", get_post_meta( $post->ID, '_wp_page_template', true ));
            if ( empty($template_name) ) $template_name = basename($template, '.php');
            if ( $template_name === 'map' || $template_name == 'single-countries' || $template_name == 'single-cities' ) {
                wp_enqueue_style('leaflet-css', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css');
                wp_enqueue_script('leaflet-js', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js', array(), null, true);
                wp_enqueue_script('leaflet-geodesic-js', 'https://cdn.jsdelivr.net/npm/leaflet.geodesic', array('leaflet-js'), null, true);
                wp_enqueue_script('custom-leaflet', get_template_directory_uri() . '/scripts/leaflet/' . $template_name . '-leaflet.js', array('leaflet-js', 'leaflet-geodesic-js'), null, true);
            }
        }
    }

    function styles() {
        global $post;
        global $template;
        wp_enqueue_style('main_styles', get_stylesheet_uri());
        wp_enqueue_style('fonts', get_template_directory_uri() . '/styles/fonts.css');
        if ( !empty($post) ) $template_name = str_replace(".php", "", get_post_meta( $post->ID, '_wp_page_template', true ));
        else $template_name = "";
        if ( empty($template_name) ) $template_name = basename($template, '.php');
        page_style($template_name);
    }

    function scripts() {
        global $post;
        global $template;
        if ( !empty($post) ) $template_name = str_replace(".php", "", get_post_meta( $post->ID, '_wp_page_template', true ));
        else $template_name = "";
        if ( empty($template_name) ) $template_name = basename($template, '.php');
        page_script($template_name);
        wp_enqueue_script('jquery');
        wp_enqueue_script('global_js', get_template_directory_uri() . '/scripts/global.js');
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

    function parseText($text, $replacement) {
        if (substr($text, 0, 2) == "- ") {
            $items = explode("- ", $text);
            $text = [];
            for ($i = 0; $i < count($items); $i++) {
                if ($items[$i] != "") $text[] = preg_replace('/- ([^:-]+):/', $replacement['list'], "- " . $items[$i]);
            }
            $text = implode('<br>', $text);
        } else {
            $text = preg_replace('/(^|\n)([^-]+)- ([^:-]+):/', $replacement['sublist'], $text);
            $text = preg_replace('/(^|\n)([^:\n]+:)([^\n]+)/', $replacement['topic'], $text);
        }
        return $text;
    }

    function localize_map_data() {
        global $post;
        global $template;
        if ( !empty($post) ) $template_name = str_replace(".php", "", get_post_meta( $post->ID, '_wp_page_template', true ));
        else $template_name = "";
        if ( empty($template_name) ) $template_name = basename($template, '.php');
        if (is_front_page() || $template_name === 'map' || $template_name === 'single-countries'  || $template_name === 'single-cities') {
            $filter = [];
            $map_context = null;
            if ($template_name == 'single-countries') {
                $filter['location-post-country-post-country'] = get_field('country');
                $map_context['coordinates'] = [floatval(get_field('latitude')), floatval(get_field('longitude'))];
                $map_context['country'] = get_field('country');
                $map_context['ISO_A3'] = get_field('abbrv-3');
            } else if ($template_name == 'single-cities') {
                $filter['location-post-city'] = get_field('city');
                $map_context['coordinates'] = [floatval(get_field('latitude')), floatval(get_field('longitude'))];
            } 
            $current_date = current_time('Ymd'); 
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
                    $map_data[] = get_data(["geojson", "transportation", "active-date","location-post", ["location-en", "latitude", "longitude", "location-lang", "city", "get-permalink", "country-post", ["country", "flag", "get-permalink"]],"video-post", ["title", "get-permalink", "type", "latitude", "longitude"], "experience-post", ["experience", "get-permalink", "latitude", "longitude"], "food-post", ["restaurant", "rating", "latitude", "longitude", "meal-price"]], array());
                }
            }

            if (is_front_page()) {
                $filtered_map_data = [];
                for ($i = 0; $i < count($map_data); $i++) {
                    if ($i <= 1 || $map_data[$i]["location-post-country-post-country"] !== $map_data[$i - 1]["location-post-country-post-country"]) $filtered_map_data[] = $map_data[$i];
                }
                $map_data = array_values($filtered_map_data);
            } else if ($template_name === 'single-countries' || $template_name === 'single-cities') {
                
                foreach ($filter as $f => $v) {
                    $filtered_map_data = [];
                    for ($i = 0; $i < count($map_data); $i++) {
                        if ($map_data[$i][$f] == $v) {
                            $filtered_map_data[] = $map_data[$i];
                        }
                    }
                    $map_data = array_values($filtered_map_data);
                }
            }

            wp_localize_script('custom-leaflet', 'map_data', $map_data);
            if ($map_context != null) wp_localize_script('custom-leaflet', 'map_context', $map_context);
        }
    }

    add_action( 'init', 'register_post_types' );
    add_action('wp_enqueue_scripts', 'styles');
    add_action('wp_enqueue_scripts', 'scripts');
    add_action('wp_enqueue_scripts', 'leaflet');
    add_action('wp_enqueue_scripts', 'localize_map_data');
    add_filter('show_admin_bar', '__return_false');

?>