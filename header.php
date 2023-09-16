<!DOCTYPE html>
<html>
    <head>
        <?php wp_head(); ?>
    </head>
    <body>
        <header>
            <nav>
                <?php 
                    $links = array("Home" => "/", "Map" => "/map", "Videos" => "videos.php", "Places" => "places.php", "Food" => "food.php", "About Me" => "about.php");
                    foreach ($links as $text => $url) echo "<a href='$url' class='navlink'>$text</a>";
                ?>
            </nav>
            <div id="title">
                <h1>PIXEL VISA</h1>
                <div id="bar"></div>
            </div>
        </header>
