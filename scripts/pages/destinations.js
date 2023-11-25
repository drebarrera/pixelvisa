function select_region(region) {
    const region_cards = document.getElementsByClassName("region-card");
    for (let i = 0; i < region_cards.length; i++) {
        region_cards[i].style.display = "none";
    };
    
    const choose_identifier = document.getElementById("choose-identifier");
    choose_identifier.textContent = "Choose a Country";

    const back_button_regions = document.getElementById("back-button-regions");
    back_button_regions.style.display = "flex";

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

    const back_button_regions = document.getElementById("back-button-regions");
    back_button_regions.style.display = "none";

    const region_cards = document.getElementsByClassName("region-card");
    for (let i = 0; i < region_cards.length; i++) {
        region_cards[i].style.display = "flex";
    };
}

function back_to_countries(region) {
    const city_cards = document.getElementsByClassName("city-card");
    for (let i = 0; i < city_cards.length; i++) {
        city_cards[i].style.display = "none";
    };

    const choose_identifier = document.getElementById("choose-identifier");
    choose_identifier.textContent = "Choose a Region";

    const back_button_regions = document.getElementById("back-button-regions");
    back_button_regions.style.display = "flex";

    const back_button_countries = document.getElementById("back-button-countries");
    back_button_countries.style.display = "none";

    const country_cards = document.getElementsByClassName("country-card");
    for (let i = 0; i < country_cards.length; i++) {
        if (country_cards[i].dataset.region == region) {
            country_cards[i].style.display = "flex";
        }
    };
}

function select_country(country, region) {
    const country_cards = document.getElementsByClassName("country-card");
    for (let i = 0; i < country_cards.length; i++) {
        country_cards[i].style.display = "none";
    };

    const choose_identifier = document.getElementById("choose-identifier");
    choose_identifier.textContent = "Choose a City";

    const back_button_regions = document.getElementById("back-button-regions");
    back_button_regions.style.display = "none";

    const back_button_countries = document.getElementById("back-button-countries");
    back_button_countries.style.display = "flex";
    back_button_countries.dataset.region = region;

    const city_cards = document.getElementsByClassName("city-card");
    for (let i = 0; i < city_cards.length; i++) {
        if (city_cards[i].dataset.country == country) {
            city_cards[i].style.display = "flex";
        }
    };
}