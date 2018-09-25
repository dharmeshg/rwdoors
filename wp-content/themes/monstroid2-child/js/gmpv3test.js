var x = document.getElementById("demo");
function getLocation() {
    if (navigator.geolocation) {
        alert(navigator.geolocation.getCurrentPosition(showPosition));
    } else {
        alert( "Geolocation is not supported by this browser.");
    }
}
function showPosition(position) {
    return "Latitude: " + position.coords.latitude + 
    "<br>Longitude: " + position.coords.longitude; 
}