function select_region(region) {
    const region_cards = document.getElementsByClassName("region-card");
    for (let i = 0; i < region_cards.length; i++) {
        region_cards[i].style.display = "none";
    };
    
    const choose_identifier = document.getElementById("choose-identifier");
    choose_identifier.textContent = "Choose a Country";

    const back_button = document.getElementById("back-button");
    back_button.style.display = "flex";

    const country_cards = document.getElementsByClassName("country-card");
    var j = 0;
    for (let i = 0; i < country_cards.length; i++) {
        if (country_cards[i].dataset.region == region) {
            setTimeout(function() {
                country_cards[i].style.display = "flex";
            }, j * 100);
            j++;
        }
    };
}

function back_to_regions() {
    const country_cards = document.getElementsByClassName("country-card");
    for (let i = 0; i < country_cards.length; i++) {
        country_cards[i].style.display = "none";
    };

    const choose_identifier = document.getElementById("choose-identifier");
    choose_identifier.textContent = "Choose a Region";

    const back_button = document.getElementById("back-button");
    back_button.style.display = "none";

    const region_cards = document.getElementsByClassName("region-card");
    for (let i = 0; i < region_cards.length; i++) {
        region_cards[i].style.display = "flex";
    };
}