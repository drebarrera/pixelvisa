<?php wp_footer(); ?>
        <footer>
            <div class="content">
                <h2>PIXEL VISA</h2>
                <nav>
                <?php 
                    $links = array("Home" => "/", "Map" => "/map", "Videos" => "videos.php", "Places" => "places.php", "Food" => "food.php", "About Me" => "about.php");
                    foreach ($links as $text => $url) echo "<a href='$url' class='navlink'>$text</a>";
                ?>
                </nav>
                <div id="credit">
                    <!--img src="http://pixel-visa.local/wp-content/themes/pixel-visa/assets/images/centerpiece.png"-->
                    <p>Website Created by&nbsp;&nbsp;<a href="https://www.drebarrera.com">Andrés Barrera</a></p>
                </div>
            </div>
        </footer>
    </body>
</html>