var toggled = [];

function filter(button) {
    if (button.classList.contains("filter-button-toggled")) {
        button.classList.remove("filter-button-toggled");
        toggled.remove(button.dataset.entrytype);
        console.log(toggled);
    } else {
        button.classList.add("filter-button-toggled");
        toggled.add(button.dataset.entrytype);
        console.log(toggled);
    }
}