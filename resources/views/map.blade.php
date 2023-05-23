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
            max-height: 70vh;
            margin: 3% auto;
            margin-bottom: 1%;
            max-width: 80%;
        }

        .row {
            display: flex;
            justify-content: space-between;
            margin: 10px 0;
        }

        .left-span {
            order: 1;
            /* Controls the order of appearance, in this case, left comes first */
        }

        .right-span {
            order: 2;
        }
    </style>
</head>

<body>

    <div id="map"></div>

    <div style="margin:0 auto;max-width:60%;">
        <div style="text-align: center;">Cordinates Values</div>
        <div class="row">
            <span class="left-span" id="top-left-lat">0</span>
            <span class="right-span" id="top-left-lng">0</span>
        </div>
        <div class="row">
            <span class="left-span" id="bottom-right-lat">0</span>
            <span class="right-span" id="bottom-right-lng">0</span>
        </div>

        <form method="post" action="/update-map">
            {{csrf_field()}}
            <input type="hidden" name="top_left_lat" id="top-left-lat-input" />
            <input type="hidden" name="top_left_lng" id="top-left-lng-input" />
            <input type="hidden" name="bottom_right_lat" id="bottom-right-lat-input" />
            <input type="hidden" name="bottom_right_lng" id="bottom-right-lng-input" />
            <input type="hidden" name="election_id" value="{{$election_id}}" id="election_id" />


            <div style="text-align: center;">
                <button style="width:auto;height:40px;" type="submit" class="btn btn-primary">Update Cordinates</button>
            </div>
        </form>
    </div>

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

    var rectangle = null;
    var rectangleBounds = null;
    var drawn = false;

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
            document.getElementById("bottom-right-lat").innerHTML = "Bottom Right Latitude :" + coordinates
                .bottomRight.lat
            document.getElementById("bottom-right-lng").innerHTML = " Bottom Right Longitude :" + coordinates
                .bottomRight.lng;
            document.getElementById("top-left-lat").innerHTML = "Top Left Latitude :" + coordinates.topLeft.lat
            document.getElementById("top-left-lng").innerHTML = "Top left Longitude :" + coordinates.topLeft.lng;

            document.getElementById("bottom-right-lat-input").value = coordinates.bottomRight.lat
            document.getElementById("bottom-right-lng-input").value = coordinates.bottomRight.lng;
            document.getElementById("top-left-lat-input").value = coordinates.topLeft.lat
            document.getElementById("top-left-lng-input").value = coordinates.topLeft.lng;

            // You can perform additional actions with the rectangle coordinates here
        }
    });

    // Example function to get the selected location (for testing purposes)
    function getSelectedLocation() {
        return selectedLocation;
    }
</script>
@include('sweetalert::alert')


</html>