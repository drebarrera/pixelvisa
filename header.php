<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="utf-8">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
        <?php wp_head(); ?>
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
