<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="utf-8">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
        <?php wp_head(); 
            global $post;
            global $template;
            if ( !empty($post) ) $template_name = str_replace(".php", "", get_post_meta( $post->ID, '_wp_page_template', true ));
            else $template_name = "";
            if ( empty($template_name) ) $template_name = basename($template, '.php');
            if ($template_name == "map") echo "<title>Map | Pixel Visa</title>";
            else if ($template_name == "destinations" || $template_name == "archive-destinations") {
                echo "<title>Destinations | Pixel Visa</title>";
                echo "<meta name='description' content='";
                echo "Learn about all the top backpacking destinations in Asia, Europe, and beyond! How much does it cost to travel to these countries, what to do, and how to get there.";
                echo "' />";
            }
            else if ($template_name == "experiences" || $template_name == "archive-experiences") {
                echo "<title>Experiences | Pixel Visa</title>";
                echo "<meta name='description' content='";
                echo "Learn about all the top backpacking experiences in Asia, Europe, and beyond! Where to go to explore Asia and Europe and how much it costs.";
                echo "' />";
            }
            else if ($template_name == "coworking" || $template_name == "archive-coworking") {
                echo "<title>Coworking | Pixel Visa</title>";
                echo "<meta name='description' content='";
                echo "Learn about all the top coworking spaces in Asia, Europe, and beyond! Where to go to meet other entrepreneurs, engineers, and digital nomads in Asia and Europe.";
                echo "' />";
            }
            else if ($template_name == "bites" || $template_name == "archive-bites") {
                echo "<title>Bites | Pixel Visa</title>";
                echo "<meta name='description' content='";
                echo "Learn about all the best budget restaurants and dining experiences in Asia, Europe, and beyond!";
                echo "' />";
            }
            else if ($template_name == "stays" || $template_name == "archive-stays") {
                echo "<title>Stays | Pixel Visa</title>";
                echo "<meta name='description' content='";
                echo "Learn about all the top hostels and hotels in Asia, Europe, and beyond! How much do they cost and what to expect.";
                echo "' />";
            }
            else if ($template_name == "videos" || $template_name == "archive-videos") {
                echo "<title>Videos | Pixel Visa</title>";
            }
            else if ($template_name == "about" || $template_name == "archive-about") {
                echo "<title>About Me | Pixel Visa</title>";
            }
            else if ($template_name == "single-cities" && have_posts()) {
                while ( have_posts() ) { 
                    the_post();
                    $title = get_the_title();
                    echo ($title != "") ? "<title>$title | Pixel Visa</title>" : "<title>Pixel Visa | Backpackers Atlas</title>";
                    echo "<meta name='description' content='";
                    echo "How much does it cost to travel to $title, what to do in $title, and how to get to $title.";
                    echo "' />";
                }
            }
            else if ($template_name == "single-bites" && have_posts()) {
                while ( have_posts() ) { 
                    the_post();
                    $title = get_the_title();
                    $location = get_data(["location-post", ["location-en"]], []);
                    if (count($location)) $location = $location['location-post-location-en'];
                    else $location = "";
                    echo ($title != "") ? ($location != "") ? "<title>$title, $location | Pixel Visa</title>" : "<title>$title | Pixel Visa</title>" : "<title>Pixel Visa | Backpackers Atlas</title>";
                    echo "<meta name='description' content='";
                    echo "Taste $title! How much does food at $title cost, where is $title , and what are the hours of $title.";
                    echo "' />";
                }
            }
            else if ($template_name == "single-countries" && have_posts()) {
                while ( have_posts() ) { 
                    the_post();
                    $title = get_the_title();
                    echo ($title != "") ? "<title>$title | Pixel Visa</title>" : "<title>Pixel Visa | Backpackers Atlas</title>";
                    echo "<meta name='description' content='";
                    echo "Everything you need to know when traveling to $title. How much does it cost to travel to $title, most popular destinations in $title, is weed legal in $title, and more!";
                    echo "' />";
                }
            }
            else if ($template_name == "single-experiences" && have_posts()) {
                while ( have_posts() ) { 
                    the_post();
                    $title = get_the_title();
                    echo ($title != "") ? "<title>$title | Pixel Visa</title>" : "<title>Pixel Visa | Backpackers Atlas</title>";
                    echo "<meta name='description' content='";
                    echo "Experience $title. How much does $title cost, where to go for $title, and what is $title like?";
                    echo "' />";
                }
            }
            else {
                echo "<title>Pixel Visa | Backpackers Atlas</title>";
                echo "<meta name='description' content='";
                echo "Backpacking Asia, Europe, and beyond! Join me on my journey and learn about countries, cities, local restaurants, and activities around the world!";
                echo "' />";
            }
        ?>
    </head>
    <body>
        <header onclick="headerDown(this)">
            <nav>
                <?php 
                    $links = array("Home" => "/", "Map" => "/map", "Destinations" => "/destinations", "Experiences" => "/experiences",/*"Coworking" => "/coworking",*/ "Food" => "/bites", /*"Stays" => "/stays", "Videos" => "/videos",*/ "About Me" => "/#about-section");
                    foreach ($links as $text => $url) echo "<a href='$url' class='navlink'>$text</a>";
                ?>
            </nav>
            <div id="title">
                <h1>PIXEL VISA</h1>
                <div id="bar"></div>
            </div>
        </header>
