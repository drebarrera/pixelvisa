function showLightbox(url, text) {
    const lightbox = document.getElementById('photo-lightbox');
    const img = lightbox.querySelector('img');
    const p = lightbox.querySelector('p');
    url = url.replace(/-\d+x\d+/g, "");
    img.src = url;
    lightbox.style.display = 'flex';
    p.textContent = text;
}

function hideLightbox() {
    const lightbox = document.getElementById('photo-lightbox');
    const img = lightbox.querySelector('img');
    const p = lightbox.querySelector('p');
    img.src = '';
    lightbox.style.display = 'none';
    p.textContent = "";
}