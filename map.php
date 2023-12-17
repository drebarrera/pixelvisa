<?php
/*
Template Name: Map Page
*/

$portrait_url = "";
$travel_icon_url = "";
$biography = "";
$travel_start = "";
$args = array(
    'post_type' => 'general_assets',
    'posts_per_page' => 1,
);
$general_assets = new WP_Query( $args );
if ( $general_assets->have_posts() ) {
    while ( $general_assets->have_posts() ) {
        $general_assets->the_post();
        $portrait = get_field("portrait-image");
        if ( !empty($portrait) ) $portrait_url = $portrait["url"];
        $travel_icon = get_field("icon-image");
        if ( !empty($travel_icon) ) $travel_icon_url = $travel_icon["url"];
        $biography = get_field("biography");
        $travel_start = get_field("travel-start");
    }
}

get_header();
?>
<section id="map-section">
    <div class="content">
        <div id="map" style="--bg: url(' <?php echo $travel_icon_url ?> ')"></div>
        <div id="panel-outer">
            <div id="panel-control">
                <div class="filter-button" id="search" style="--color: var(--orange);"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"><path d="M200-80v-800h80v80h560l-80 200 80 200H280v320h-80Zm80-640v240-240Zm220 200q33 0 56.5-23.5T580-600q0-33-23.5-56.5T500-680q-33 0-56.5 23.5T420-600q0 33 23.5 56.5T500-520Zm-220 40h442l-48-120 48-120H280v240Z"/></svg>City: <input type="text"></input></div>
                <div class="filter-button" style="--color: var(--blue);"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"><path d="M480-390Zm-132-53 55 37 77-39 77 39 53-35-40-79H386l-38 77ZM209-160h541L646-369l-83 55-83-41-83 41-85-56-103 210ZM80-80l234-475q10-20 29.5-32.5T386-600h54v-280h280l-40 80 40 80H520v120h50q23 0 42 12t30 32L880-80H80Z"/></svg>Experiences</div>
                <div class="filter-button" style="--color: var(--red);"><svg xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd" viewBox="0 0 24 24"><path d="M23.999 12.149a11.985 11.985 0 0 1-4.706 9.378A11.951 11.951 0 0 1 12.095 24 12.005 12.005 0 0 1 0 12c3.966 1.066 7.682-1.993 6-6 4.668.655 6.859-2.389 6.077-6a12.003 12.003 0 0 1 11.922 12.149zM8.423 8.026c-.065 3.393-2.801 5.868-6.182 6.166 1.008 4.489 5.015 7.807 9.759 7.807 5.262 0 9.576-4.072 9.97-9.229.369-4.818-2.755-9.357-7.796-10.534-.277 2.908-2.381 5.357-5.751 5.79zM13.5 17a1.5 1.5 0 1 1-.001 3.001A1.5 1.5 0 0 1 13.5 17zM8 14.147a2 2 0 1 1-.001 4.001A2 2 0 0 1 8 14.147zM18 12a2 2 0 1 1-.001 4.001A2 2 0 0 1 18 12zm-5 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm2.5-5a1.5 1.5 0 1 1-.001 3.001A1.5 1.5 0 0 1 15.5 7zM3 7a1 1 0 1 1 0 2 1 1 0 0 1 0-2zM1.5 3a1.5 1.5 0 1 1-.001 3.001A1.5 1.5 0 0 1 1.5 3zm6-2a1.5 1.5 0 1 1-.001 3.001A1.5 1.5 0 0 1 7.5 1zM4 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>Local Bites</div>
            </div>
            <div id="panel"></div>
        </div>
    </div>
</section>
<?php get_footer();