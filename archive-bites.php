<?php
/*
Template Name: Experiences Page
*/

get_header();
?>
<section id="experiences-section">
    <div class="content">
        <h2><svg xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd" viewBox="0 0 24 24"><path d="M23.999 12.149a11.985 11.985 0 0 1-4.706 9.378A11.951 11.951 0 0 1 12.095 24 12.005 12.005 0 0 1 0 12c3.966 1.066 7.682-1.993 6-6 4.668.655 6.859-2.389 6.077-6a12.003 12.003 0 0 1 11.922 12.149zM8.423 8.026c-.065 3.393-2.801 5.868-6.182 6.166 1.008 4.489 5.015 7.807 9.759 7.807 5.262 0 9.576-4.072 9.97-9.229.369-4.818-2.755-9.357-7.796-10.534-.277 2.908-2.381 5.357-5.751 5.79zM13.5 17a1.5 1.5 0 1 1-.001 3.001A1.5 1.5 0 0 1 13.5 17zM8 14.147a2 2 0 1 1-.001 4.001A2 2 0 0 1 8 14.147zM18 12a2 2 0 1 1-.001 4.001A2 2 0 0 1 18 12zm-5 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm2.5-5a1.5 1.5 0 1 1-.001 3.001A1.5 1.5 0 0 1 15.5 7zM3 7a1 1 0 1 1 0 2 1 1 0 0 1 0-2zM1.5 3a1.5 1.5 0 1 1-.001 3.001A1.5 1.5 0 0 1 1.5 3zm6-2a1.5 1.5 0 1 1-.001 3.001A1.5 1.5 0 0 1 7.5 1zM4 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg> World Class Bites</h2>
        <div id="locations" class="place">
        <?php
            $current_date = current_time('Ymd'); 

            $args = array(
                'post_type' => array('bites'),
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
                    $data = get_data(["cover-photo", "restaurant", "cuisine", "location-post", ["location-en"], "get-permalink"], array());                    
                    if ( !empty($data["cover-photo"]) ) {
                        $bg = "url('" . $data["cover-photo"]["url"] . "')";
                        echo '<a href="' . $data["get-permalink"] . '" class="card" style="--bg: ' . $bg . '">
                            <p class="location-name">';
                        echo $data['location-post-location-en'];
                        echo '</p><h5>' ;
                        echo $data['restaurant'];
                        echo '</h5><p class="cuisine">';
                        echo $data['cuisine'];
                        echo '</p><div class="button"><p>';
                        echo 'Taste ' . $data['restaurant'];
                        echo '</p></div></a>';
                    } 
                }
            }
        ?> 
        </div>
    </div>
</section>
<?php get_footer();