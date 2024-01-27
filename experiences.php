<?php
/*
Template Name: Experiences Page
*/

get_header();
?>
<section id="experiences-section">
    <div class="content">
    <!--?php
        $current_date = current_time('Ymd'); 

        $args = array(
            'post_type' => array('cities', 'experiences'),
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
            )
        );

        $latest_travel = new WP_Query( $args );
        if ( $latest_travel->have_posts() ) {
            while ( $latest_travel->have_posts() ) {
                $latest_travel->the_post();
                $current_post_type = get_post_type(get_the_ID());
                if ($current_post_type == 'cities') {
                    $data = get_data(["cover-photo", "location-lang", "location-en", "city", "get-permalink"], array());
                } elseif ($current_post_type == 'experiences') {
                    $data = get_data(["cover-photo", "experience", "get-permalink", "location-post", ["location-en", "city"]], array());
                }
                
                if ( !empty($data["cover-photo"]) ) {
                    $bg = "url('" . $data["cover-photo"]["url"] . "')";
                    echo '<a href="' . $data["get-permalink"] . '" class="card" style="--bg: ' . $bg . '">
                        <p class="location-name">';
                    echo ($current_post_type == 'cities') ? $data['location-en'] : $data['location-post-location-en'];
                    echo '</p><h5>' ;
                    echo ($current_post_type == 'cities') ? $data['location-lang'] : $data['experience'];
                    echo '</h5><div class="button"><p>';
                    echo ($current_post_type == 'cities') ? 'Explore ' . $data['city'] : 'More About ' . $data['experience'];
                    echo '</p></div></a>';
                } 
            }
        }
    ?--> 
    </div>
</section>
<?php get_footer();