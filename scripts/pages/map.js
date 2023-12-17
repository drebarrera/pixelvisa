function filter(button) {
    if (button.classList.contains("filter-button-toggled")) {
        button.classList.remove("filter-button-toggled");
    } else {
        button.classList.add("filter-button-toggled");
    }
}