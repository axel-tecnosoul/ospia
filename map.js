window.addEventListener('message', function(event) {
    var locationData = event.data;
    if (locationData.lat && locationData.lng) {
        // Initialize the map with the received location data
        var map = new google.maps.Map(document.getElementById('map'), {
            center: { lat: locationData.lat, lng: locationData.lng },
            zoom: 15
        });

        // Add a marker for the user's location
        var userMarker = new google.maps.Marker({
            position: { lat: locationData.lat, lng: locationData.lng },
            map: map,
            title: 'Your Location'
        });

        // Example array of other markers (add your own markers as needed)
        var markers = [
            { lat: locationData.lat + 0.01, lng: locationData.lng + 0.01 },
            { lat: locationData.lat - 0.01, lng: locationData.lng - 0.01 }
        ];

        // Add other markers to the map
        markers.forEach(function(marker) {
            new google.maps.Marker({
                position: { lat: marker.lat, lng: marker.lng },
                map: map
            });
        });

        // Adjust the map view to fit all markers
        var bounds = new google.maps.LatLngBounds();
        bounds.extend(new google.maps.LatLng(locationData.lat, locationData.lng));
        markers.forEach(function(marker) {
            bounds.extend(new google.maps.LatLng(marker.lat, marker.lng));
        });
        map.fitBounds(bounds);
    }
}, false);
