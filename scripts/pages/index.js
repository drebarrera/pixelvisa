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
        const anchor = document.getElementById(elements[i]).getBoundingClientRect().top + window.scrollY - 60;
        if ((window.scrollY >= anchor - 15) && (window.scrollY <= anchor + 5)) {
            window.scrollTo(0, anchor);
        }
    }
}

window.addEventListener('scroll', function() {
    scrollLock();
});

/*document.addEventListener("DOMContentLoaded", function() {
    const cards = document.querySelectorAll('#places-section .place .card');
    for (let i = 0; i < cards.length; i++) {
        let container = cards[i];
        const svg = container.querySelector('svg');
        const textPath = container.querySelector('#textPath');
        const bbox = container.getBoundingClientRect();
        svg.setAttribute('width', bbox.width);
        svg.setAttribute('height', bbox.height);
        const path = document.querySelector('#rectPath');
        const text_offset = 14;
        const d = `M${0 + text_offset} ${0 + text_offset} H ${bbox.width - text_offset - 4} V ${bbox.height - text_offset - 4} H ${0 + text_offset} Z`;
        path.setAttribute('d', d);
        svg.style.position = 'absolute';
        svg.style.top = '0';
        svg.style.left = '0';
        svg.style.pointerEvents = 'none';
        container.appendChild(svg);
    }
    
});*/