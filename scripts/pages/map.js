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
    const searchItems = document.querySelector(searchtype + " .search-items");
    document.querySelectorAll(".search-item").forEach(function(searchItem) {
        searchItems.removeChild(searchItem);
    })
    if (input.value != "") {
        if (searchtype == "#city-search") entries = Object.entries(cities);
        const filteredEntries = entries.filter(([key, value]) => key.startsWith(input.value.toLowerCase()));
        filteredEntries.forEach(function(entry) {
            var searchItem = document.createElement("p");
            searchItem.classList.add("search-item");
            searchItem.textContent = entry[1][1];
            searchItem.dataset.entryid = entry[1][0];
            searchItems.appendChild(searchItem);
            searchItems.addEventListener("click", function(e) {
                alert(e.target.dataset.entryid);
            })
        });
        searchItems.style.padding = "4px";
    } else {
        searchItems.style.padding = "0px";
    }

}

document.getElementById('country-search').addEventListener('input', function() {
    search("#country-search", document.querySelector('#country-search input'));
});

document.getElementById('city-search').addEventListener('input', function() {
    search("#city-search", document.querySelector('#city-search input'));
});