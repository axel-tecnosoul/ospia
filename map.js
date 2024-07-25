async function initMap(lat = 40.7128, lng = -74.0060, zoom = 15) {
    // Load the required libraries (maps and marker)
    const { Map, AdvancedMarkerElement } = await google.maps.importLibrary("maps,marker");
  
    // Create the map object
    const map = new Map(document.getElementById('map'), {
      center: { lat, lng },
      zoom
    });
  
    // Function to create markers with fallback logic
    function createMarker(position, title) {
      if (AdvancedMarkerElement && google.maps.marker.AdvancedMarkerElement) {
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
  
  // Load the Google Maps API with async and defer attributes
  // Replace YOUR_API_KEY with your actual Google Maps API key
  /*const script = document.createElement('script');
  script.src = `https://maps.googleapis.com/maps/api/js?key=AIzaSyCNY8MsGHgM_ie57K4F8kKX8Gkt02yJa3U&callback=initMap&async=defer`;
  document.head.appendChild(script);*/
  