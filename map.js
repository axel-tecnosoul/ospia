function initializeMap(lat, lng, zoom = 15) {
    var map = new google.maps.Map(document.getElementById('map'), {
        center: { lat: lat, lng: lng },
        zoom: zoom
    });

    // Function to create an AdvancedMarkerElement
    function createMarker(position, title) {
        if (google.maps.marker && google.maps.marker.AdvancedMarkerElement) {
            const markerElement = new google.maps.marker.AdvancedMarkerElement({
                map: map,
                position: position,
                title: title
            });
            return markerElement;
        } else {
            console.error("AdvancedMarkerElement is not available.");
            return null;
        }
    }

    // Add a marker for the default or received location
    createMarker({ lat: lat, lng: lng }, 'Location');

    // Example array of other markers (add your own markers as needed)
    var markers = [
        { lat: lat + 0.01, lng: lng + 0.01 },
        { lat: lat - 0.01, lng: lng - 0.01 }
    ];

    // Add other markers to the map
    markers.forEach(function(marker) {
        createMarker({ lat: marker.lat, lng: marker.lng }, '');
    });

    // Adjust the map view to fit all markers
    var bounds = new google.maps.LatLngBounds();
    bounds.extend(new google.maps.LatLng(lat, lng));
    markers.forEach(function(marker) {
        bounds.extend(new google.maps.LatLng(marker.lat, marker.lng));
    });
    map.fitBounds(bounds);
}

window.addEventListener('message', function(event) {
    var locationData = event.data;
    if (locationData.lat && locationData.lng) {
        // Initialize the map with the received location data
        initializeMap(locationData.lat, locationData.lng);
    }
}, false);
