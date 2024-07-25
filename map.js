function initializeMap(lat, lng, zoom = 15) {
    var map = new google.maps.Map(document.getElementById('map'), {
        center: { lat: lat, lng: lng },
        zoom: zoom
    });

    function createMarker(position, title) {
        if (google.maps.marker && google.maps.marker.AdvancedMarkerElement) {
          // Use AdvancedMarkerElement if available
          return new google.maps.marker.AdvancedMarkerElement({
            map: map,
            position: position,
            title: title
          });
        } else {
          console.warn("AdvancedMarkerElement is not available.");
          // Fallback to a standard marker
          if (google.maps.Marker) {
            return new google.maps.Marker({
              map: map,
              position: position,
              title: title
            });
          }
          return null;
        }
      }
      

    // Add a marker for the default or received location
    createMarker({ lat: lat, lng: lng }, 'Location');

    // Example array of other markers
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

// Initialize the map with default coordinates
function initMap() {
    if (typeof google !== 'undefined' && google.maps) {
        var defaultLat = 40.7128; // Example latitude
        var defaultLng = -74.0060; // Example longitude
        initializeMap(defaultLat, defaultLng);
    } else {
        console.error("Google Maps API is not loaded.");
    }
}

// Handle incoming messages with location data
window.addEventListener('message', function(event) {
    var locationData = event.data;
    if (locationData.lat && locationData.lng) {
        initializeMap(locationData.lat, locationData.lng);
    }
}, false);
