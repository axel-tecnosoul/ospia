window.addEventListener('message', function(event) {
    const allowedOrigins = ['file://'];

    if (!allowedOrigins.includes(event.origin)) {
        // Check origin for security
        return;
    }

    const locationData = event.data;
    if (locationData && locationData.lat && locationData.lon) {
        updateMap(locationData.lat, locationData.lon);
    }
}, false);

function requestLocation() {
    window.parent.postMessage({ type: 'requestLocation' }, '*');
}

let map;
let markers = [];

function initMap() {
    const defaultLocation = { lat: -34.397, lng: -58.381 };
    map = new google.maps.Map(document.getElementById('map'), {
        zoom: 8,
        center: defaultLocation
    });

    addMarker({ lat: -34.397, lng: 150.644 });
    addMarker({ lat: -35.297, lng: 149.644 });
    requestLocation();
}

function updateMap(lat, lon) {
    const userLocation = new google.maps.LatLng(lat, lon);
    map.setCenter(userLocation);
    addMarker(userLocation);
    adjustZoomToFitMarkers();
}

function addMarker(location) {
    const marker = new google.maps.Marker({
        position: location,
        map: map
    });
    markers.push(marker);
}

function adjustZoomToFitMarkers() {
    if (markers.length === 0) return;

    const bounds = new google.maps.LatLngBounds();
    markers.forEach(marker => bounds.extend(marker.getPosition()));
    map.fitBounds(bounds);
}

initMap();