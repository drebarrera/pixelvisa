<?php
/*
Template Name: Experiences Page
*/

get_header();
?>
<section id="experiences-section">
    <div class="content">
        <h2><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"><path d="M480-390Zm-132-53 55 37 77-39 77 39 53-35-40-79H386l-38 77ZM209-160h541L646-369l-83 55-83-41-83 41-85-56-103 210ZM80-80l234-475q10-20 29.5-32.5T386-600h54v-280h280l-40 80 40 80H520v120h50q23 0 42 12t30 32L880-80H80Z"/></svg> All the Best Experiences</h2>
        <div id="locations" class="place">
        <?php
            $current_date = current_time('Ymd'); 

            $args = array(
                'post_type' => array('cities', 'experiences'),
                'posts_per_page' => 20000,
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
        ?> 
        </div>
    </div>
</section>
<?php get_footer();