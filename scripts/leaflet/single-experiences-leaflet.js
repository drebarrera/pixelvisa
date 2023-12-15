document.addEventListener("DOMContentLoaded", function() {
    console.log(map_context);
    map_coordinates = [parseFloat(map_context['coordinates'][0]), parseFloat(map_context['coordinates'][1])];

    // Create map
    let center = (map_context != null) ? map_coordinates : [0, 0];
    let zoom = (map_context != null) ? 16 : 2;
    var map = L.map('map', {center: center, zoom: zoom, attributionControl: false, minZoom: 2});

    // Adjust attribution on bottom left
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a>',
        maxZoom: 20
    }).addTo(map);
    L.control.attribution({
        position: 'bottomleft'
    }).addTo(map);

    // Set map bounds
    let bounds = L.latLngBounds(L.latLng(-90, -180), L.latLng(90, 180));
    map.setMaxBounds(bounds);

    // Create svg icon for location pin
    const location_svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="location_icon"><path d="M12 0C7.802 0 4 3.403 4 7.602 4 11.8 7.469 16.812 12 24c4.531-7.188 8-12.2 8-16.398C20 3.403 16.199 0 12 0zm0 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6z" fill="#FF9505"/><circle cx="12" cy="8" r="3" fill="white"/></svg>';

    const experiences_svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="location_icon"><path d="M12 0C7.802 0 4 3.403 4 7.602 4 11.8 7.469 16.812 12 24c4.531-7.188 8-12.2 8-16.398C20 3.403 16.199 0 12 0zm0 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6z" fill="#0DA1BF"/><circle cx="12" cy="8" r="3" fill="white"/></svg>';
    const experiences_icon = L.divIcon({
        className: 'experiences',
        html: experiences_svg,
        iconSize: [30, 30],
        iconAnchor: [15, 30],
        popupAnchor: [0, -30]
    });

    const experience_svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"><path d="M480-390Zm-132-53 55 37 77-39 77 39 53-35-40-79H386l-38 77ZM209-160h541L646-369l-83 55-83-41-83 41-85-56-103 210ZM80-80l234-475q10-20 29.5-32.5T386-600h54v-280h280l-40 80 40 80H520v120h50q23 0 42 12t30 32L880-80H80Z"/></svg>'

    e_marker = L.marker(map_coordinates, {icon: experiences_icon}).addTo(map);
    e_marker.bindPopup("<b style='display: flex; justify-content: center; align-items: center; column-gap: 5px;'>" + experience_svg + " " + map_context["experience"] + "</b>", { autoPan: false }).openPopup();
    e_marker.on('click', function(e) {
        map.flyTo(e.latlng, 16);
    });
});