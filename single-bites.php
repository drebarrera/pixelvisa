<?php
    /*
    Template Name: Bites
    */
    get_header();
    global $post;
    if ( have_posts() ) :
        while ( have_posts() ) : the_post();
            $photo = get_field("cover-photo");
            if ( !empty($photo) ) :
                function toUSD($value) {
                    $exchange_rate = get_data(["country-post", ["exchange-rate"]], array())["country-post-exchange-rate"];
                    return round(floatval($value) / floatval($exchange_rate), 2);
                    
                }
                $url = "url('" . $photo["url"] . "')";
?>
                <section id="title-section" style="--bg: <?php echo $url ?>;">
                    <h2><?php echo strtoupper(get_field("restaurant")); ?></h2>
                </section>
                
<?php
            endif;
        endwhile;
    endif;
get_footer();