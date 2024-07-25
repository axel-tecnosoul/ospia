function initMap() {
  // Default to Buenos Aires, Argentina
  const defaultPosition = { lat: -34.6037, lng: -58.3816 };

  // Initialize the map with the default position
  const map = new google.maps.Map(document.getElementById("map"), {
      zoom: 10,
      center: defaultPosition,
      mapId: 'YOUR_MAP_ID' // Replace with your valid Map ID
  });

  const position = { lat: -34.6037, lng: -58.3816 };

  if (google.maps.marker && google.maps.marker.AdvancedMarkerElement) {
      console.log("AdvancedMarkerElement is available");
      const marker = new google.maps.marker.AdvancedMarkerElement({
          map,
          position,
          title: "Default Location - Buenos Aires",
      });
  } else {
      console.warn("AdvancedMarkerElement is not available, using standard Marker");
      const marker = new google.maps.Marker({
          map,
          position,
          title: "Default Location - Buenos Aires",
      });
  }

  // Try to get the user's current location
  if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(
          (position) => {
              const userPosition = {
                  lat: position.coords.latitude,
                  lng: position.coords.longitude
              };

              // Center the map on the user's location
              map.setCenter(userPosition);

              if (google.maps.marker && google.maps.marker.AdvancedMarkerElement) {
                  console.log("AdvancedMarkerElement is available");
                  const marker = new google.maps.marker.AdvancedMarkerElement({
                      map,
                      position: userPosition,
                      title: "Your Location",
                  });
              } else {
                  console.warn("AdvancedMarkerElement is not available, using standard Marker");
                  const marker = new google.maps.Marker({
                      map,
                      position: userPosition,
                      title: "Your Location",
                  });
              }
          },
          (error) => {
              console.error("Error getting location: ", error);
              // If there's an error, keep the map centered on the default location
          }
      );
  } else {
      console.error("Geolocation is not supported by this browser.");
  }
}
