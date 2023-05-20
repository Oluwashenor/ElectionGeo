console.log("Location js");

if (navigator.geolocation) {
    console.log("Location");
    var options = {
        enableHighAccuracy: true // Add this option to enable high accuracy
    };
    navigator.geolocation.getCurrentPosition(showPosition, showError, options);
} else {
    console.log("Geolocation is not supported");
    // Geolocation is not supported
}

function showPosition(position) {
    console.log("Trying to get coordinates");
    var latitude = position.coords.latitude;
    var longitude = position.coords.longitude;
    console.log("Latitude :", latitude);
    console.log("Longitude :", longitude);
    let latElement = document.getElementById("lat");
    latElement.value = latitude;
    let lonElement = document.getElementById("lon");
    lonElement.value = longitude;

    // Perform further processing with the latitude and longitude values
}

function showError(error) {
    console.log(error);
    // Handle errors, if any
}
