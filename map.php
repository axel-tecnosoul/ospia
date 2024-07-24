<!DOCTYPE html>
<html>
<head>
    <title>Map Example</title>
    <style>
        #map {
            height: 100%;
            width: 100%;
        }
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
    </style>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCNY8MsGHgM_ie57K4F8kKX8Gkt02yJa3U&callback=initMap"></script>
    
    <script>
        function initializeMap(lat, lng, zoom = 15) {
            var map = new google.maps.Map(document.getElementById('map'), {
                center: { lat: lat, lng: lng },
                zoom: zoom
            });

            // Function to create a marker
            function createMarker(position, title) {
                const marker = new google.maps.Marker({
                    position: position,
                    map: map,
                    title: title
                });
                return marker;
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

        function initMap() {
            const defaultLat = 40.7128;  // Example: New York City
            const defaultLng = -74.0060;
            initializeMap(defaultLat, defaultLng);
        }

        window.addEventListener('message', function(event) {
            var locationData = event.data;
            if (locationData.lat && locationData.lng) {
                // Initialize the map with the received location data
                initializeMap(locationData.lat, locationData.lng);
            }
        }, false);
    </script>
</head>
<body>
    <div id="map"></div>
</body>
</html>
