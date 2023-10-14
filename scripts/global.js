function headerDown(header) {
    if (window.innerWidth < 768 && !header.classList.contains("headerDown")) {
            header.classList.add("headerDown");
    }
}

document.addEventListener('click', (event) => {
    const header = document.getElementsByTagName("header")[0];
    if (header.classList.contains("headerDown")) {
        header.classList.remove('headerDown');
    }
});