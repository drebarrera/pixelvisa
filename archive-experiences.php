<?php
/*
Template Name: Experiences Page
*/

get_header();
?>
<section id="experiences-section">
    <div class="content">
        <h2><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"><path d="M480-390Zm-132-53 55 37 77-39 77 39 53-35-40-79H386l-38 77ZM209-160h541L646-369l-83 55-83-41-83 41-85-56-103 210ZM80-80l234-475q10-20 29.5-32.5T386-600h54v-280h280l-40 80 40 80H520v120h50q23 0 42 12t30 32L880-80H80Z"/></svg> All the Best Experiences</h2>
        <a href="/map"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 0C8.852 0 6 2.553 6 5.702c0 4.682 4.783 5.177 6 12.298 1.217-7.121 6-7.616 6-12.298C18 2.553 15.149 0 12 0zm0 8a2 2 0 1 1-.001-3.999A2 2 0 0 1 12 8zm12 16-6.707-2.427L12 24l-5.581-2.427L0 24l4-9 3.96-1.584c.38.516.741 1.08 1.061 1.729l-3.523 1.41-1.725 3.88 2.672-1.01 1.506-2.687-.635 3.044 4.189 1.789L12 19.55l.465 2.024 4.15-1.89-.618-3.033 1.572 2.896 2.732.989-1.739-3.978-3.581-1.415c.319-.65.681-1.215 1.062-1.731L20.064 15 24 24z"></path></svg><p>View the Map</p></a>
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
                        $data = get_data(["cover-photo", "location-en", "city", "get-permalink"], array());
                    } elseif ($current_post_type == 'experiences') {
                        $data = get_data(["cover-photo", "experience", "get-permalink", "location-post", ["location-en", "city"]], array());
                    }
                    
                    if ( !empty($data["cover-photo"]) ) {
                        $bg = "url('" . $data["cover-photo"]["url"] . "')";
                        echo '<a href="' . $data["get-permalink"] . '" class="card" style="--bg: ' . $bg . '">
                            <p class="location-name">';
                        echo ($current_post_type == 'cities') ? $data['location-en'] : $data['location-post-location-en'];
                        echo '</p><h5>' ;
                        echo ($current_post_type == 'cities') ? $data['city'] : $data['experience'];
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