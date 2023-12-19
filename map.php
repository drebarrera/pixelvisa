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
                <div id="country-search" class="filter-button" style="--color: var(--green);" data-entrytype="country" onclick="toggle(this)"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 2c5.514 0 10 4.486 10 10s-4.486 10-10 10S2 17.514 2 12 6.486 2 12 2zm0-2C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm1.608 9.476L12 4l-1.611 5.477a3.019 3.019 0 0 0-1.019 1.107L4 12l5.37 1.416c.243.449.589.833 1.019 1.107L12 20l1.618-5.479a3.004 3.004 0 0 0 1.014-1.109L20 12l-5.368-1.413a2.996 2.996 0 0 0-1.024-1.111zM12 13.5a1.5 1.5 0 1 1 .001-3.001A1.5 1.5 0 0 1 12 13.5zm5.25 3.75-2.573-1.639c.356-.264.67-.579.935-.934l1.638 2.573zm-2.641-8.911 2.64-1.588-1.588 2.639a4.486 4.486 0 0 0-1.052-1.051zm-5.215 7.325L6.75 17.25l1.589-2.641c.29.408.646.764 1.055 1.055zm-1.005-6.34L6.751 6.751l2.573 1.638a4.456 4.456 0 0 0-.935.935z"/></svg>Filter By Country: <div class="search-column"><input type="text"></input><div class="search-items"></div></div></div>
                <div id="city-search" class="filter-button" style="--color: var(--orange);" data-entrytype="city" onclick="toggle(this)"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"><path d="M200-80v-800h80v80h560l-80 200 80 200H280v320h-80Zm80-640v240-240Zm220 200q33 0 56.5-23.5T580-600q0-33-23.5-56.5T500-680q-33 0-56.5 23.5T420-600q0 33 23.5 56.5T500-520Zm-220 40h442l-48-120 48-120H280v240Z"/></svg>Filter By City: <div class="search-column"><input type="text"></input><div class="search-items"></div></div></div>
                <div class="filter-button" style="--color: var(--blue);" data-entrytype="experience" onclick="filter(this)"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"><path d="M480-390Zm-132-53 55 37 77-39 77 39 53-35-40-79H386l-38 77ZM209-160h541L646-369l-83 55-83-41-83 41-85-56-103 210ZM80-80l234-475q10-20 29.5-32.5T386-600h54v-280h280l-40 80 40 80H520v120h50q23 0 42 12t30 32L880-80H80Z"/></svg>Filter Experiences</div>
                <div class="filter-button" style="--color: var(--red);" data-entrytype="bites" onclick="filter(this)"><svg xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd" viewBox="0 0 24 24"><path d="M23.999 12.149a11.985 11.985 0 0 1-4.706 9.378A11.951 11.951 0 0 1 12.095 24 12.005 12.005 0 0 1 0 12c3.966 1.066 7.682-1.993 6-6 4.668.655 6.859-2.389 6.077-6a12.003 12.003 0 0 1 11.922 12.149zM8.423 8.026c-.065 3.393-2.801 5.868-6.182 6.166 1.008 4.489 5.015 7.807 9.759 7.807 5.262 0 9.576-4.072 9.97-9.229.369-4.818-2.755-9.357-7.796-10.534-.277 2.908-2.381 5.357-5.751 5.79zM13.5 17a1.5 1.5 0 1 1-.001 3.001A1.5 1.5 0 0 1 13.5 17zM8 14.147a2 2 0 1 1-.001 4.001A2 2 0 0 1 8 14.147zM18 12a2 2 0 1 1-.001 4.001A2 2 0 0 1 18 12zm-5 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm2.5-5a1.5 1.5 0 1 1-.001 3.001A1.5 1.5 0 0 1 15.5 7zM3 7a1 1 0 1 1 0 2 1 1 0 0 1 0-2zM1.5 3a1.5 1.5 0 1 1-.001 3.001A1.5 1.5 0 0 1 1.5 3zm6-2a1.5 1.5 0 1 1-.001 3.001A1.5 1.5 0 0 1 7.5 1zM4 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>Filter Local Bites</div>
            </div>
            <div id="panel"></div>
        </div>
    </div>
</section>
<?php get_footer();