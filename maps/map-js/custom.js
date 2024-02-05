// Common settings
var platform = new H.service.Platform({
  app_id: 'devportal-demo-20180625',
  app_code: '9v2BkviRwi9Ot26kp2IysQ',
  useHTTPS: true
});
var pixelRatio = window.devicePixelRatio || 1;
var defaultLayers = platform.createDefaultLayers({
  tileSize: pixelRatio === 1 ? 256 : 512,
  ppi: pixelRatio === 1 ? undefined : 320
});

// map12
function addMarkersToMap(map) {
  var parisMarker = new H.map.Marker({lat:48.8567, lng:2.3508});
  map.addObject(parisMarker);

  var romeMarker = new H.map.Marker({lat:41.9, lng: 12.5});
  map.addObject(romeMarker);

  var berlinMarker = new H.map.Marker({lat:52.5166, lng:13.3833});
  map.addObject(berlinMarker);

  var madridMarker = new H.map.Marker({lat:40.4, lng: -3.6833});
  map.addObject(madridMarker);

  var londonMarker = new H.map.Marker({lat:51.5008, lng:-0.1224});
  map.addObject(londonMarker);
}
var map = new H.Map(document.getElementById('map12'),
  defaultLayers.normal.map,{
  center: {lat:50, lng:5},
  zoom: 4,
  pixelRatio: pixelRatio
});
var behavior = new H.mapevents.Behavior(new H.mapevents.MapEvents(map));
var ui = H.ui.UI.createDefault(map, defaultLayers);
addMarkersToMap(map);