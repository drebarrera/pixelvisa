var toggled = [];
var filtered = [];

function filter(button) {
    if (button.classList.contains("filter-button-toggled")) {
        button.classList.remove("filter-button-toggled");
        var index = toggled.indexOf(button.dataset.entrytype);
        if (index !== -1) toggled.splice(index, 1);
    } else {
        button.classList.add("filter-button-toggled");
        toggled.push(button.dataset.entrytype);
    }

    var entries = document.querySelectorAll('.entry-item');
    entries.forEach(function(entry) {
        if (toggled.length > 0) {
            entry.style.display = "none";
            toggled.forEach(function(entrytype) {
                if (entrytype == entry.dataset.entrytype) toggle = entry.style.display = "flex";
            });
        } else {
            entry.style.display = "flex";
        }
    });
}

function search(searchtype, input) {
    console.log(searchtype + " .search-items");
    //document.querySelector(searchtype + " .search-items").style.display = "block";
    console.log(input.value);

}

document.getElementById('country-search').addEventListener('input', function() {
    search("country-search", document.querySelector('#country-search input'));
});

document.getElementById('city-search').addEventListener('input', function() {
    search("city-search", document.querySelector('#city-search input'));
});