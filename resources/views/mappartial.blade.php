<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <style>
        #map {
            height: 680px;
        }
    </style>
</head>

<body>

    <div id="map"></div>

</body>


<!-- Make sure you put this AFTER Leaflet's CSS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    // Create a Leaflet map
    var map = L.map('map').setView([6.7519, 4.8780], 13);

    // Add a tile layer to the map (you can use any tile provider)
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
    }).addTo(map);

    // Initialize a variable to store the selected location
    var selectedLocation = null;

    // Create a marker layer group
    var markerGroup = L.layerGroup().addTo(map);

    // var marker = L.marker([6.7519, 4.8780]).addTo(map);
    // var circle = L.circle([6.7519, 4.8780], {
    //     color: 'red',
    //     fillColor: '#f03',
    //     fillOpacity: 0.5,
    //     radius: 500
    // }).addTo(map);

    var rectangle = null;
    var rectangleBounds = null;
    var drawn = false;

    // Event listener for click on the map
    // Event listener for click on the map
    // map.on('click', function(event) {
    //     // If a marker already exists, remove it from the map
    //     if (marker) {
    //         marker.remove();
    //     }

    //     // Get the clicked coordinates
    //     var lat = event.latlng.lat;
    //     var lng = event.latlng.lng;

    //     // Create a marker at the clicked location and make it draggable
    //     marker = L.marker([lat, lng], {
    //         draggable: true
    //     }).addTo(map);

    //     // Event listener for marker dragend
    //     marker.on('dragend', function(event) {
    //         var markerLatLng = event.target.getLatLng();
    //         console.log('Marker dragged to:', markerLatLng);

    //         // You can perform additional actions with the dragged coordinates here
    //     });
    // });


    // Event listener for click on the map
    map.on('click', function(event) {
        // If a rectangle already exists, remove it from the map    
        if (rectangle) {
            rectangle.remove();
        }

        // Get the clicked coordinates
        var lat = event.latlng.lat;
        var lng = event.latlng.lng;

        // Create a rectangle with the clicked location as the starting point
        rectangleBounds = L.latLngBounds([lat, lng], [lat, lng]);
        rectangle = L.rectangle(rectangleBounds, {
            draggable: true
        }).addTo(map);

        // Event listener for rectangle dragend
        // rectangle.on('dragend', function(event) {
        //     var rectangleBounds = event.target.getBounds();
        //     // console.log('Rectangle bounds:', rectangleBounds);

        //     // var topLeft = rectangleBounds.getNorthWest();
        //     // var bottomRight = rectangleBounds.getSouthEast();
        //     // var coordinates = {
        //     //     topLeft: {
        //     //         lat: topLeft.lat,
        //     //         lng: topLeft.lng
        //     //     },
        //     //     bottomRight: {
        //     //         lat: bottomRight.lat,
        //     //         lng: bottomRight.lng
        //     //     }
        //     // };
        //     // console.log('Rectangle coordinates:', coordinates);
        //     // You can perform additional actions with the rectangle bounds here
        // });

        // Event listener for mousemove on the map
        map.on('mousemove', function(event) {
            // If a rectangle exists, update its bounds based on the mouse movement
            if (rectangle) {
                var newBounds = L.latLngBounds(rectangleBounds.getSouthWest(), event.latlng);
                rectangle.setBounds(newBounds);
            }
        });


    });

    map.on('mouseup', function(event) {
        // If a rectangle exists, update its bounds based on the mouseup event
        if (rectangle) {
            var rectangleBounds = rectangle.getBounds();
            var topLeft = rectangleBounds.getNorthWest();
            var bottomRight = rectangleBounds.getSouthEast();
            var coordinates = {
                topLeft: {
                    lat: topLeft.lat,
                    lng: topLeft.lng
                },
                bottomRight: {
                    lat: bottomRight.lat,
                    lng: bottomRight.lng
                }
            };
            console.log('Rectangle coordinates:', coordinates);

            // You can perform additional actions with the rectangle coordinates here
        }
    });

    // Example function to get the selected location (for testing purposes)
    function getSelectedLocation() {
        return selectedLocation;
    }
</script>

</html>