function initMap() {
  var map = new google.maps.Map(document.getElementById('map'), { maxZoom: 12 });
  var bounds = new google.maps.LatLngBounds();
  var infoWindow = new google.maps.InfoWindow(), marker, person;
  var count = 0;
  for (var person = 1; person <= parseInt($('#geoloc-count').text()) ; person++) {
    if (Number($('#lat'+person+'').text()) !== 0 || Number($('#lng'+person+'').text()) !== 0) {
      console.log(count += 1);
      var place = {lat: Number($('#lat'+person+'').text()), lng: Number($('#lng'+person+'').text())}
      var position = new google.maps.LatLng(place.lat, place.lng);
      bounds.extend(position);
      var marker = new google.maps.Marker({
        position: position,
        map: map
      });
      google.maps.event.addListener(marker, 'click', (function(marker, person) {
        return function() {
          infoWindow.setContent($('#username'+person+'').text());
          infoWindow.open(map, marker);
        }
      })(marker, person));
      map.fitBounds(bounds);
    }
  }
  if (count === 0) {
    $('#map').hide();
  }
}
