/*jQuery(document).ready(function($) {
    function header_color() {
        const header = $('header')[0];
        if (window.scrollY > 100) {
            if (header.style.backgroundColor != '#FAF2DB') {
                $('header')[0].animate({
                    'backgroundColor': '#FAF2DB'
                }, 1000);
                $('header #bar')[0].animate({
                    'backgroundColor': 'black'
                }, 1000);
                $('header #title').css({'color': 'black'});
                $('header .navlink').css({'color': 'black'});
            }
        } else {
            $('header')[0].animate({
                'backgroundColor': 'rgba(0,0,0,0.5)'
            }, 1000);
            $('header #bar')[0].animate({
                'backgroundColor': 'white'
            }, 1000);
            $('header #title').css({'color': 'white'});
            $('header .navlink').css({'color': 'white'});
        }
    }


    header_color();
    
});*/

function scrollLock() {
    const elements = ["map-section", "places-section"];
    for (let i = 0; i < elements.length; i++) {
        const anchor = document.getElementById(elements[i]).getBoundingClientRect().top + window.scrollY - document.getElementById(elements[i]).computedStyleMap().get('margin-top').value;
        if ((window.scrollY >= anchor - 15) && (window.scrollY <= anchor + 5)) {
            window.scrollTo(0, anchor);
        }
    }
}

window.addEventListener('scroll', function() {
    scrollLock();
});