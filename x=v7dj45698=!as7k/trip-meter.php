<html>
<script type="text/javascript">
// check for Geolocation support
if (navigator.geolocation) {
  console.log('Geolocation is supported!');
}
else {
  console.log('Geolocation is not supported for this Browser/OS version yet.');
}	

window.onload = function() {
  var startPos;
  navigator.geolocation.getCurrentPosition(function(position) {
    startPos = position;
    document.getElementById('startLat').innerHTML = startPos.coords.latitude;
    document.getElementById('startLon').innerHTML = startPos.coords.longitude;
  });
};

//monitor location
navigator.geolocation.watchPosition(function(position) {
  document.getElementById('currentLat').innerHTML = position.coords.latitude;
  document.getElementById('currentLon').innerHTML = position.coords.longitude;
});

//calculate distance
navigator.geolocation.watchPosition(function(position) {
  // same as above
  document.getElementById('distance').innerHTML =
      calculateDistance(startPos.coords.latitude, startPos.coords.longitude,
                        position.coords.latitude, position.coords.longitude);
});

function calculateDistance(lat1, lon1, lat2, lon2) {
  var R = 6371; // km
  var dLat = (lat2 - lat1).toRad();
  var dLon = (lon2 - lon1).toRad(); 
  var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
          Math.cos(lat1.toRad()) * Math.cos(lat2.toRad()) * 
          Math.sin(dLon / 2) * Math.sin(dLon / 2); 
  var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a)); 
  var d = R * c;
  return d;
}
Number.prototype.toRad = function() {
  return this * Math.PI / 180;
}
</script>

<div id="tripmeter">
  <p>
    Starting Location (lat, lon):<br/>
    <span id="startLat">???</span>°, <span id="startLon">???</span>°
  </p>
  <p>
    Current Location (lat, lon):<br/>
    <span id="currentLat">???</span>°, <span id="currentLon">???</span>°
  </p>
  <p>
    Distance from starting location:<br/>
    <span id="distance">0</span> km
  </p>
</div>