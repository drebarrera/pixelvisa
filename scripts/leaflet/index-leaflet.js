document.addEventListener("DOMContentLoaded", function() {
    for (let i = 0; i < map_data.length; i++) {
        map_data[i]["coordinates"] = [parseFloat(map_data[i]["location-post-latitude"]), parseFloat(map_data[i]["location-post-longitude"])];
    }
    const location_svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 0C7.802 0 4 3.403 4 7.602 4 11.8 7.469 16.812 12 24c4.531-7.188 8-12.2 8-16.398C20 3.403 16.199 0 12 0zm0 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6z" fill="#FF9505"/><circle cx="12" cy="8" r="3" fill="white"/></svg>';
    const location_icon = L.divIcon({
        className: 'location',
        html: location_svg,
        iconSize: [30, 30],
        iconAnchor: [15, 30],
        popupAnchor: [0, -30]
    });

    let center = (map_data.length > 0) ? map_data[map_data.length - 1].coordinates : [0, 0];
    let zoom = (map_data.length > 0) ? 5 : 2
    var map = L.map('map', {center: center, zoom: zoom, attributionControl: false});

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a>',
        maxZoom: 19
    }).addTo(map);

    L.control.attribution({
        position: 'bottomleft'
    }).addTo(map);

    for (let i = 0; i < map_data.length; i++) {
        let data = map_data[i];
        let coordinates = data.coordinates;
        var marker = L.marker(coordinates, {icon: location_icon}).addTo(map);
        if (i == map_data.length - 1) marker.bindPopup("<b>Catch me in " + data["location-post-country-post-country"] + " "  +  data["location-post-country-post-flag"] + "!</b>").openPopup();
        else {
            let path = [coordinates, map_data[i + 1].coordinates];
            var geodesic = L.geodesic([path], {
                weight: 2,
                opacity: 1,
                color: '#CE272A'
            }).addTo(map);
        }
    }
});