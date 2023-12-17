var toggled = [];

function filter(button) {
    if (button.classList.contains("filter-button-toggled")) {
        button.classList.remove("filter-button-toggled");
        var index = toggled.indexOf(button.dataset.entrytype);
        if (index !== -1) toggled.splice(index, 1);
        console.log(toggled);
    } else {
        button.classList.add("filter-button-toggled");
        toggled.push(button.dataset.entrytype);
        console.log(toggled);
    }
}