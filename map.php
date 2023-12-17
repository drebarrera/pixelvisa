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
                <p style="width: 100%;">Filter By:</p>
                <div class="filter-button" id="search" style="--color: var(--orange);">City: <input type="text"></input></div>
                <div class="filter-button" style="--color: var(--blue);">Experiences</div>
                <div class="filter-button" style="--color: var(--red);">Food</div>
            </div>
            <div id="panel"></div>
        </div>
    </div>
</section>
<?php get_footer();