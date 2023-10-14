function headerDown(header) {
    if (window.innerWidth < 768) {
        header.classList.add("headerDown");
    }
}

document.addEventListener('click', (event) => {
    const header = document.getElementsByTagName("header")[0];
    if (!event.target.closest('.headerDown')) {
        header.classList.remove('headerDown');
    }
});