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

    const bites_svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="location_icon"><path d="M12 0C7.802 0 4 3.403 4 7.602 4 11.8 7.469 16.812 12 24c4.531-7.188 8-12.2 8-16.398C20 3.403 16.199 0 12 0zm0 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6z" fill="#CE272A"/><circle cx="12" cy="8" r="3" fill="white"/></svg>';
    const bites_icon = L.divIcon({
        className: 'bites',
        html: bites_svg,
        iconSize: [30, 30],
        iconAnchor: [15, 30],
        popupAnchor: [0, -30]
    });

    const food_svg = '<svg xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd" viewBox="0 0 24 24"><path d="M23.999 12.149a11.985 11.985 0 0 1-4.706 9.378A11.951 11.951 0 0 1 12.095 24 12.005 12.005 0 0 1 0 12c3.966 1.066 7.682-1.993 6-6 4.668.655 6.859-2.389 6.077-6a12.003 12.003 0 0 1 11.922 12.149zM8.423 8.026c-.065 3.393-2.801 5.868-6.182 6.166 1.008 4.489 5.015 7.807 9.759 7.807 5.262 0 9.576-4.072 9.97-9.229.369-4.818-2.755-9.357-7.796-10.534-.277 2.908-2.381 5.357-5.751 5.79zM13.5 17a1.5 1.5 0 1 1-.001 3.001A1.5 1.5 0 0 1 13.5 17zM8 14.147a2 2 0 1 1-.001 4.001A2 2 0 0 1 8 14.147zM18 12a2 2 0 1 1-.001 4.001A2 2 0 0 1 18 12zm-5 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm2.5-5a1.5 1.5 0 1 1-.001 3.001A1.5 1.5 0 0 1 15.5 7zM3 7a1 1 0 1 1 0 2 1 1 0 0 1 0-2zM1.5 3a1.5 1.5 0 1 1-.001 3.001A1.5 1.5 0 0 1 1.5 3zm6-2a1.5 1.5 0 1 1-.001 3.001A1.5 1.5 0 0 1 7.5 1zM4 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>'

    e_marker = L.marker(map_coordinates, {icon: bites_icon}).addTo(map);
    e_marker.bindPopup("<b style='display: flex; justify-content: center; align-items: center; column-gap: 5px;'>" + food_svg + " Test</b>", { autoPan: false }).openPopup();
    e_marker.on('click', function(e) {
        map.flyTo(e.latlng, 16);
    });
});