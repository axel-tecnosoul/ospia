async function initMap(lat = 40.7128, lng = -74.0060, zoom = 15) {
    // Load the required library (marker)
    const { Marker } = await google.maps.importLibrary("marker");
  
    // Create the map object
    const map = new Map(document.getElementById('map'), {
      center: { lat, lng },
      zoom
    });
  
    // Function to create markers 
    function createMarker(position, title) {
      return new Marker({
        map: map,
        position: position,
        title: title
      });
    }
  
    // Create a marker for the initial location
    createMarker({ lat, lng }, 'Location');
  
    // Example array of other markers
    const markers = [
      { lat: lat + 0.01, lng: lng + 0.01 },
      { lat: lat - 0.01, lng: lng - 0.01 }
    ];
  
    // Add other markers to the map
    markers.forEach(marker => createMarker(marker, ''));
  
    // Adjust the map view to fit all markers
    const bounds = new google.maps.LatLngBounds();
    bounds.extend(new google.maps.LatLng(lat, lng));
    markers.forEach(marker => bounds.extend(new google.maps.LatLng(marker.lat, marker.lng)));
    map.fitBounds(bounds);
  }
  
  // Handle incoming messages with location data
  window.addEventListener('message', function(event) {
    const locationData = event.data;
    if (locationData.lat && locationData.lng) {
      initMap(locationData.lat, locationData.lng);
    }
  }, false);
