<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php wp_head(); ?>
    </head>
    <body>
        <header>
            <nav>
                <?php 
                    $links = array("Home" => "/", "Map" => "/map", "Videos" => "/videos", "Destinations" => "/destinations", "Food" => "/food", "About Me" => "/#about-section");
                    foreach ($links as $text => $url) echo "<a href='$url' class='navlink'>$text</a>";
                ?>
            </nav>
            <div id="title">
                <h1>PIXEL VISA</h1>
                <div id="bar"></div>
            </div>
        </header>
