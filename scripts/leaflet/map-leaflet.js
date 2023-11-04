function scrollIntoParentView(element, parent) {
    const elementRect = element.getBoundingClientRect();
    const parentRect = parent.getBoundingClientRect();
    if (elementRect.top < parentRect.top) {
        parent.scrollTop -= (parentRect.top - elementRect.top);
    } else if (elementRect.bottom > parentRect.bottom) {
        parent.scrollTop += (elementRect.bottom - parentRect.bottom);
    }
}

document.addEventListener("DOMContentLoaded", function() {
    let entry_count = 0;
    for (let i = 0; i < map_data.length; i++) {
        map_data[i]["entry-key"] = null;
        map_data[i]["coordinates"] = [parseFloat(map_data[i]["location-post-latitude"]), parseFloat(map_data[i]["location-post-longitude"])];
        if (map_data[i]["video-post-latitude"] != map_data[i]["location-post-latitude"] || map_data[i]["video-post-longitude"] != map_data[i]["location-post-longitude"]) {
            map_data[i]["video-post-coordinates"] = [parseFloat(map_data[i]["video-post-latitude"]), parseFloat(map_data[i]["video-post-longitude"])];
            if (map_data[i]["video-post-coordinates"][0] && map_data[i]["video-post-coordinates"][1]) {
                map_data[i]["entry-key"] = entry_count;
                entry_count += 1;
            }
        } else map_data[i]["video-post-coordinates"] = [NaN, NaN];
        if (map_data[i]["experience-post-latitude"] != map_data[i]["location-post-latitude"] || map_data[i]["experience-post-longitude"] != map_data[i]["location-post-longitude"]) {
            map_data[i]["experience-post-coordinates"] = [parseFloat(map_data[i]["experience-post-latitude"]), parseFloat(map_data[i]["experience-post-longitude"])];
            if (map_data[i]["experience-post-coordinates"][0] && map_data[i]["experience-post-coordinates"][1]) {
                map_data[i]["entry-key"] = entry_count;
                entry_count += 1;
            }
        } else map_data[i]["experience-post-coordinates"] = [NaN, NaN];
        if (map_data[i]["food-post-latitude"] != map_data[i]["location-post-latitude"] || map_data[i]["food-post-longitude"] != map_data[i]["location-post-longitude"]) {
            map_data[i]["food-post-coordinates"] = [parseFloat(map_data[i]["food-post-latitude"]), parseFloat(map_data[i]["food-post-longitude"])];
            if (map_data[i]["food-post-coordinates"][0] && map_data[i]["food-post-coordinates"][1]) {
                map_data[i]["entry-key"] = entry_count;
                entry_count += 1;
            }
        } else map_data[i]["food-post-coordinates"] = [NaN, NaN];
    }

    // Parse data
    var panel_data = {}; // Panel data holds data grouped by location
    var marker_data = new Array(); // Marker data holds keyed data for markers
    var marker_keys = [{},{}]; // Marker keys holds a location: key and key: location dictionaries
    for (let i = 0; i < map_data.length; i++) {
        let datum = map_data[i];
        let location = datum["location-post-location-en"];
        if (location in panel_data) panel_data[location]["entry"].push({"video-url": datum["video-post-get-permalink"], "video-title": datum["video-post-title"], "video-type": datum["video-post-type"], "video-coordinates": datum["video-post-coordinates"], "experience-url": datum["experience-post-get-permalink"], "experience-title": datum["experience-post-experience"], "experience-coordinates": datum["experience-post-coordinates"], "active-date": datum["active-date"], "entry-key": datum["entry-key"], "food-coordinates": datum["food-post-coordinates"], "food-restaurant": datum["food-post-restaurant"], "food-rating": datum["food-post-rating"]});
        else {
            panel_data[location] = {"country": datum["location-post-country-post-country"], "country-url": datum["location-post-country-post-get-permalink"], "flag": datum["location-post-country-post-flag"], "city": datum["location-post-city"], "location-url": datum["location-post-get-permalink"], "coordinates": datum.coordinates, "entry": [{"video-url": datum["video-post-get-permalink"], "video-title": datum["video-post-title"], "video-type": datum["video-post-type"], "video-coordinates": datum["video-post-coordinates"], "experience-url": datum["experience-post-get-permalink"], "experience-title": datum["experience-post-experience"], "experience-coordinates": datum["experience-post-coordinates"], "active-date": datum["active-date"], "entry-key": datum["entry-key"], "food-coordinates": datum["food-post-coordinates"], "food-restaurant": datum["food-post-restaurant"], "food-rating": datum["food-post-rating"]}]};
            marker_keys[0][location] = Object.keys(marker_keys[0]).length;
            marker_keys[1][Object.keys(marker_keys[1]).length] = location;
        }
        if ((marker_data.length == 0) || (marker_data[marker_data.length - 1][0][0] != datum.coordinates[0]) || (marker_data[marker_data.length - 1][0][1] != datum.coordinates[1])) marker_data.push([datum.coordinates, location, datum["location-post-country-post-flag"], marker_keys[0][location]]);
    }

    // Create svg icon for location pin
    const location_svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="location_icon"><path d="M12 0C7.802 0 4 3.403 4 7.602 4 11.8 7.469 16.812 12 24c4.531-7.188 8-12.2 8-16.398C20 3.403 16.199 0 12 0zm0 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6z" fill="#FF9505"/><circle cx="12" cy="8" r="3" fill="white"/></svg>';
    const location_icon = L.divIcon({
        className: 'location',
        html: location_svg,
        iconSize: [30, 30],
        iconAnchor: [15, 30],
        popupAnchor: [0, -30]
    });

    const vlog_svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="location_icon"><path d="M12 0C7.802 0 4 3.403 4 7.602 4 11.8 7.469 16.812 12 24c4.531-7.188 8-12.2 8-16.398C20 3.403 16.199 0 12 0zm0 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6z" fill="#88498F"/><circle cx="12" cy="8" r="3" fill="white"/></svg>';
    const video_icon = L.divIcon({
        className: 'video',
        html: vlog_svg,
        iconSize: [30, 30],
        iconAnchor: [15, 30],
        popupAnchor: [0, -30]
    });

    const exp_svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="location_icon"><path d="M12 0C7.802 0 4 3.403 4 7.602 4 11.8 7.469 16.812 12 24c4.531-7.188 8-12.2 8-16.398C20 3.403 16.199 0 12 0zm0 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6z" fill="#0DA1BF"/><circle cx="12" cy="8" r="3" fill="white"/></svg>';
    const experience_icon = L.divIcon({
        className: 'experience',
        html: exp_svg,
        iconSize: [30, 30],
        iconAnchor: [15, 30],
        popupAnchor: [0, -30]
    });

    const bites_svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="location_icon"><path d="M12 0C7.802 0 4 3.403 4 7.602 4 11.8 7.469 16.812 12 24c4.531-7.188 8-12.2 8-16.398C20 3.403 16.199 0 12 0zm0 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6z" fill="#CE272A"/><circle cx="12" cy="8" r="3" fill="white"/></svg>';
    const bites_icon = L.divIcon({
        className: 'bites',
        html: bites_svg,
        iconSize: [30, 30],
        iconAnchor: [15, 30],
        popupAnchor: [0, -30]
    });

    // Create icon for current location pin
    const current_html = '<div id="dre-current"><div class="ring" id="ring1"></div><div class="ring" id="ring2"></div><div class="ring" id="ring3"></div><div id="dre-travel"></div></div>';
    const current_icon = L.divIcon({
        className: 'current',
        html: current_html,
        iconSize: [72, 72],
        iconAnchor: [36, 36],
        popupAnchor: [0, -36]
    });

    const visit_svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"><path d="M200-80v-800h80v80h560l-80 200 80 200H280v320h-80Zm80-640v240-240Zm220 200q33 0 56.5-23.5T580-600q0-33-23.5-56.5T500-680q-33 0-56.5 23.5T420-600q0 33 23.5 56.5T500-520Zm-220 40h442l-48-120 48-120H280v240Z"/></svg>'
    const video_svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"><path d="M160-160q-33 0-56.5-23.5T80-240v-480q0-33 23.5-56.5T160-800h480q33 0 56.5 23.5T720-720v180l160-160v440L720-420v180q0 33-23.5 56.5T640-160H160Zm0-80h480v-480H160v480Zm0 0v-480 480Z"/></svg>';
    const experience_svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"><path d="M480-390Zm-132-53 55 37 77-39 77 39 53-35-40-79H386l-38 77ZM209-160h541L646-369l-83 55-83-41-83 41-85-56-103 210ZM80-80l234-475q10-20 29.5-32.5T386-600h54v-280h280l-40 80 40 80H520v120h50q23 0 42 12t30 32L880-80H80Z"/></svg>';
    const food_svg = '<svg xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd" viewBox="0 0 24 24"><path d="M23.999 12.149a11.985 11.985 0 0 1-4.706 9.378A11.951 11.951 0 0 1 12.095 24 12.005 12.005 0 0 1 0 12c3.966 1.066 7.682-1.993 6-6 4.668.655 6.859-2.389 6.077-6a12.003 12.003 0 0 1 11.922 12.149zM8.423 8.026c-.065 3.393-2.801 5.868-6.182 6.166 1.008 4.489 5.015 7.807 9.759 7.807 5.262 0 9.576-4.072 9.97-9.229.369-4.818-2.755-9.357-7.796-10.534-.277 2.908-2.381 5.357-5.751 5.79zM13.5 17a1.5 1.5 0 1 1-.001 3.001A1.5 1.5 0 0 1 13.5 17zM8 14.147a2 2 0 1 1-.001 4.001A2 2 0 0 1 8 14.147zM18 12a2 2 0 1 1-.001 4.001A2 2 0 0 1 18 12zm-5 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm2.5-5a1.5 1.5 0 1 1-.001 3.001A1.5 1.5 0 0 1 15.5 7zM3 7a1 1 0 1 1 0 2 1 1 0 0 1 0-2zM1.5 3a1.5 1.5 0 1 1-.001 3.001A1.5 1.5 0 0 1 1.5 3zm6-2a1.5 1.5 0 1 1-.001 3.001A1.5 1.5 0 0 1 7.5 1zM4 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>'

    // Create map
    let center = (map_data.length > 0) ? map_data[map_data.length - 1].coordinates : [0, 0];
    let zoom = (map_data.length > 0) ? 5 : 2;
    var map = L.map('map', {center: center, zoom: zoom, attributionControl: false, minZoom: 2});

    // Adjust attribution on bottom left
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a>',
        maxZoom: 19
    }).addTo(map);
    L.control.attribution({
        position: 'bottomleft'
    }).addTo(map);

    // Set map bounds
    let bounds = L.latLngBounds(L.latLng(-90, -180), L.latLng(90, 180));
    map.setMaxBounds(bounds);

    // Place markers, popups, and geodesic paths
    var markers_placed = [];
    var last_key = "";
    var marker = null;
    var markers = {};
    var e_markers = {};
    for (let i = 0; i < marker_data.length; i++) {
        marker_datum = marker_data[i];
        // If marker has not already been placed
        if ( !(marker_data[i][3] in markers_placed) ) {
            markers_placed.push(marker_data[i][3]);
            marker = L.marker(marker_datum[0], {zIndexOffset: 20000, icon: location_icon}).addTo(map);
            marker._leaflet_id = marker_data[i][3].toString();
            // Give element a markerid
            var markerElement = marker.getElement();
            markerElement.dataset.markerid = marker_data[i][3].toString();
            markers[marker_data[i][3].toString()] = marker;
            // Bind popup to marker
            marker.bindPopup("<b>" + visit_svg + marker_datum[1] + " " + marker_datum[2] + "</b>", { autoPan: false }).openPopup();
            
            // Bind marker click event
            marker.on('click', function(e) {
                map.flyTo(e.latlng, 12);
                let clicked_elements = document.querySelectorAll('.location-entry-click');
                clicked_elements.forEach(element => {
                    element.classList.remove('location-entry-click');
                });
                clicked_elements = document.querySelectorAll('.entry-item-click');
                clicked_elements.forEach(element => {
                    element.classList.remove('entry-item-click');
                });
                document.querySelectorAll('.location-entry[data-markerid="' + marker_data[i][3].toString() + '"]')[0].classList.add('location-entry-click');
                var location_entries = document.querySelectorAll('.location-entry[data-markerid="' + marker_data[i][3].toString() + '"] div:not([data-entrykey])');
                location_entries[0].classList.add('entry-item-click');
                scrollIntoParentView(document.querySelectorAll('.location-entry[data-markerid="' + marker_data[i][3].toString() + '"]')[0], panel);
            });

            last_key = marker_data[i][3].toString();
        }
        // Create geodesic paths between markers
        var geojson = "";
        if (i > 0) {
            var coords = [[marker_datum[0][0], marker_datum[0][1]], [marker_data[i - 1][0][0], marker_data[i - 1][0][1]]]
            if (map_data[i]["geojson"] != null && map_data[i]["geojson"] != "") {
                geojson = JSON.parse(map_data[i]["geojson"]);
                var geojsonLayer = L.geoJSON(geojson["route"], {
                    style: {
                              fillColor: 'transparent',
                              color: geojson["color"],
                            }
                }).addTo(map);
                var routePopup = geojsonLayer.bindPopup("<b>" + map_data[i]["transportation"] + "</b>", { autoPan: false });
                geojsonLayer.addEventListener("hover", function() {
                    routePopup.openPopup();
                    console.log("hi");
                });
            } else {
                var geodesic = L.geodesic([coords], {
                    weight: 2,
                    opacity: 1,
                    color: '#CE272A'
                }).addTo(map);
                var routePopup = geodesic.bindPopup("<b>" + map_data[i]["transportation"] + "</b>", { autoPan: false });
                geodesic.addEventListener("hover", function() {
                    console.log("hi");
                    routePopup.openPopup();
                });
            }
        }
    }
    // Change last marker to current icon
    marker.setIcon(current_icon);

    // Add data to panel
    const panel = document.getElementById("panel");
    for (let datum in panel_data) {
        // Create entry
        const location_entry = document.createElement("div");
        location_entry.className = "location-entry";
        location_entry.dataset.markerid = marker_keys[0][datum];
        const location_entry_h3 = document.createElement("h3"); // Location header
        location_entry_h3.textContent = datum;
        location_entry.appendChild(location_entry_h3);
        const location_country_a = document.createElement("a"); // Flag & Country subheader
        location_country_a.textContent = panel_data[datum].flag + " "  + panel_data[datum].country;
        location_country_a.href = panel_data[datum]["country-url"];
        location_country_a.className = "location-country-p";
        location_entry.appendChild(location_country_a);
        for (let i = 0; i < panel_data[datum].entry.length; i++) {
            let entry = panel_data[datum].entry[i];
            let entry_item = document.createElement("div");
            entry_item.className = "entry-item";
            // Generate entry marker if experience or video
            if (entry["entry-key"] != null) {
                e_marker = undefined;
                if (entry["video-title"]) {
                    e_marker = L.marker(entry["video-coordinates"], {icon: video_icon}).addTo(map);
                    e_marker.getElement().dataset.entrykey = entry["entry-key"];
                    e_markers[entry["entry-key"]] = e_marker;
                    e_marker.bindPopup("<b style='display: flex; justify-content: center; align-items: center; column-gap: 5px;'>" + video_svg + " " + entry["video-title"] + "</b>", { autoPan: false });
                } else if (entry["experience-title"]) {
                    e_marker = L.marker(entry["experience-coordinates"], {icon: experience_icon}).addTo(map);
                    e_marker.getElement().dataset.entrykey = entry["entry-key"];
                    e_markers[entry["entry-key"]] = e_marker;
                    e_marker.bindPopup("<b style='display: flex; justify-content: center; align-items: center; column-gap: 5px;'>" + experience_svg + " " + entry["experience-title"] + "</b>", { autoPan: false });
                } else if (entry["food-restaurant"]) {
                    e_marker = L.marker(entry["food-coordinates"], {icon: bites_icon}).addTo(map);
                    e_marker.getElement().dataset.entrykey = entry["entry-key"];
                    e_markers[entry["entry-key"]] = e_marker;
                    e_marker.bindPopup("<b style='display: flex; justify-content: center; align-items: center; column-gap: 5px;'>" + food_svg + " " + entry["food-restaurant"] + "</b>", { autoPan: false });
                }
                e_marker.on('click', function(e) {
                    map.flyTo(e.latlng, 16);
                    let clicked_elements = document.querySelectorAll('.location-entry-click');
                    clicked_elements.forEach(element => {
                        element.classList.remove('location-entry-click');
                    });
                    clicked_elements = document.querySelectorAll('.entry-item-click');
                    clicked_elements.forEach(element => {
                        element.classList.remove('entry-item-click');
                    });
                    document.querySelectorAll('.location-entry[data-markerid="' + marker_keys[0][datum].toString() + '"]')[0].classList.add('location-entry-click');
                    document.querySelectorAll('.entry-item[data-entrykey="' + entry["entry-key"].toString() + '"]')[0].classList.add('entry-item-click');
                    scrollIntoParentView(document.querySelectorAll('.location-entry[data-markerid="' + marker_keys[0][datum].toString() + '"]')[0], panel);
                });
                entry_item.dataset.entrykey = entry["entry-key"].toString();
            }
            let entry_name = document.createElement("h4");
            let entry_type = document.createElement("p");
            entry_type.className = "entry-type";
            let entry_date = document.createElement("p");
            let active_date = `${entry["active-date"].substring(6,8)}/${entry["active-date"].substring(4,6)}/${entry["active-date"].substring(0,4)}`;
            entry_date.textContent = "Date: " +  active_date;
            let entry_button = document.createElement("a");
            // Fill entry based on type
            if (entry["video-title"]) {
                entry_name.textContent = entry["video-title"];
                entry_type.innerHTML = video_svg + " " + entry["video-type"];
                entry_button.textContent = "Watch the " + entry["video-type"];
                entry_button.href = entry["video-url"];
            } else if (entry["experience-title"]) {
                entry_name.textContent = entry["experience-title"];
                entry_type.innerHTML = experience_svg + " Experience";
                entry_button.textContent = "Experience " + entry["experience-title"];
                entry_button.href = entry["experience-url"];
            } else if (entry["food-restaurant"]) {
                entry_name.textContent = entry["food-restaurant"];
                entry_type.innerHTML = food_svg + " Local Bite";
                entry_button.textContent = "Taste " + entry["food-restaurant"];
                entry_button.href = entry["experience-url"];
            } else {
                entry_name.textContent = "Arrived in " + panel_data[datum]["city"];
                entry_type.innerHTML = visit_svg + " Visit";
                entry_button.textContent = "All About " + panel_data[datum]["city"];
                entry_button.href = panel_data[datum]["location-url"];
            }
            entry_item.appendChild(entry_type);
            entry_item.appendChild(entry_name);
            entry_item.appendChild(entry_date);
            entry_item.appendChild(entry_button);
            // Location onclick => map fly to pin & style changes.
            location_entry.onclick = function(e) {
                var isLocation = true;
                var target = e.target;
                // Check if target is an experience or video entry item
                while (target !== this) {
                    if (target.classList.contains('entry-item') && target.hasAttribute('data-entrykey')) {
                      isLocation = false;
                    }
                    target = target.parentElement;
                }
                // If not experience or video entry, open the popup
                if (isLocation) {
                    map.flyTo(panel_data[datum].coordinates, 12);
                    markers[marker_keys[0][datum].toString()].openPopup();
                    /*let clicked_elements = document.querySelectorAll('.entry-item-click');
                    clicked_elements.forEach(element => {
                        element.classList.remove('entry-item-click');
                    });*/
                }
                let clicked_elements = document.querySelectorAll('.location-entry-click');
                clicked_elements.forEach(element => {
                    element.classList.remove('location-entry-click');
                });
                this.classList.add('location-entry-click');
                scrollIntoParentView(this, panel);
            };

            // Entry onclick => map fly to pin & style changes
            entry_item.onclick = function(e) {
                if (entry["entry-key"] != null) {
                    map.flyTo(e_markers[entry["entry-key"]].getLatLng(), 16);
                    e_markers[entry["entry-key"]].openPopup();
                }

                let clicked_elements = document.querySelectorAll('.entry-item-click');
                clicked_elements.forEach(element => {
                    element.classList.remove('entry-item-click');
                })
                this.classList.add('entry-item-click');
                scrollIntoParentView(this, panel);
            };
            location_entry.appendChild(entry_item);
        }
        panel.appendChild(location_entry);
    }

    // Sort entries so that the latest entry is first
    const entries = Array.from(panel.querySelectorAll('.location-entry'));
    const sortedEntries = entries.sort((a, b) => {
        return parseInt(b.dataset.markerid, 10) - parseInt(a.dataset.markerid, 10);
    });
    sortedEntries.forEach(element => {
        panel.appendChild(element);
    });

    // Select and scroll most recent
    let current_location = document.querySelectorAll('.location-entry[data-markerid="' + last_key + '"]');
    current_location.forEach(element => {
        element.classList.add('location-entry-click');
        scrollIntoParentView(element, panel);
    })
});