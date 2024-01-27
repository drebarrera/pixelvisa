<?php wp_footer(); ?>
        <footer>
            <div class="content">
                <h2>PIXEL VISA</h2>
                <nav>
                <?php 
                    $links = array("Home" => "/", "Map" => "/map", "Destinations" => "/destinations", "Experiences" => "/experiences",/*"Coworking" => "/coworking",*/ "Food" => "/bites", /*"Stays" => "/stays", "Videos" => "/videos",*/ "About Me" => "/#about-section");
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