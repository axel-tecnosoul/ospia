let map;
const defaultLocation = { lat: -34.603722, lng: -58.381592 }; // Buenos Aires, Argentina

function initMap() {
    map = new google.maps.Map(document.getElementById("map"), {
        zoom: 10,
        center: defaultLocation,
        mapId: 'YOUR_MAP_ID' // Replace with your valid Map ID
    });

    // Set default marker at Buenos Aires
    setMarker(defaultLocation, "Default Location");

    // Listen for messages from the Cordova app
    window.addEventListener("message", (event) => {
        if (event.data && event.data.lat !== undefined && event.data.lng !== undefined) {
            const userLocation = {
                lat: event.data.lat,
                lng: event.data.lng
            };
            map.setCenter(userLocation);
            setMarker(userLocation, "Your Location");
        }
    }, false);
}

function setMarker(position, title) {
    if (google.maps.marker && google.maps.marker.AdvancedMarkerElement) {
        console.log("AdvancedMarkerElement is available");
        new google.maps.marker.AdvancedMarkerElement({
            map,
            position,
            title: title,
        });
    } else {
        console.warn("AdvancedMarkerElement is not available, using standard Marker");
        new google.maps.Marker({
            map,
            position,
            title: title,
        });
    }
}
