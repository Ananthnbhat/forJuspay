
        // document.onload = () => {
        //     console.log(Hello)
        // };


        var map;
        var activeInfoWindow;
        var infoWindow;
        var obj;
        var locations=[];


        // if (document.getElementById('r1').checked) {
        //     var type = document.getElementById('r1').value;
        // }


        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                center: {
                    lat: 21.146633,
                    lng: 79.088860
                },
                zoom: 4
            });
            var labels1 = 'T';
            var labels2 = 'L';
            var color = '#00FF00';
            var image = 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png';
            infoWindow = new google.maps.InfoWindow;




            // Try HTML5 geolocation.
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    var lati = pos.lat;
                    var longi = pos.lng;
                    var origin = {
                        latitude: lati,
                        lng: longi
                    };
                    infoWindow.setPosition(pos);
                    map.setCenter(pos);


                    //set markers for teachers or students
                    var markers = locations.map(function(location, i) {
                        return new google.maps.Marker({
                            position: location,
                            //label: labels1[i % labels1.length],
                            icon: image
                        });
                    });
                    for (var i = 0; i < markers.length; i++) {

                        markers[i].addListener('click', function() {
                            //map.setZoom(8);
                            console.log(origin);
                            // map.setCenter(markers.getPosition());
                        });
                    }
                    console.log(markers);
                    //Add a marker clusterer to manage the markers.
                    var markerCluster = new MarkerClusterer(map, markers, {
                        //setIcon: 'http://maps.google.com/mapfiles/ms/icons/green-dot.png',
                        imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'
                    });
                    //when any of the student's/teacher's marker is clicked



                    //setting my marker
                    myMarker(lati, longi);




                }, function() {
                    handleLocationError(true, infoWindow, map.getCenter());
                });
            } else {
                // Browser doesn't support Geolocation
                handleLocationError(false, infoWindow, map.getCenter());
            }

        }

        function myMarker(la, lo) {
            var uluru = {
                lat: la,
                lng: lo
            };
            var marker1 = new google.maps.Marker({
                position: uluru,
                map: map,
                animation: google.maps.Animation.DROP,

            });
            marker1.addListener('click', function() {
                // map.setZoom(8);
                console.log('hello');
                // map.setCenter(markers.getPosition());
            });

            map.setZoom(15);
            var circle = new google.maps.Circle({
                map: map,
                radius: 1000, // 1km in metres
                fillColor: '#99ccff',
                strokeColor: '#1a8cff'

            });
            circle.bindTo('center', marker1, 'position');


            var infoWnd = new google.maps.InfoWindow();
            var infoWnd2 = new google.maps.InfoWindow();


            infoWnd.setContent('My Location');
            google.maps.event.addListener(marker1, 'mouseover', function() {

                // Close active window if exists - [one might expect this to be default behaviour no?]				
                if (activeInfoWindow != null) activeInfoWindow.close();

                // Close info Window on mouseclick if already opened
                infoWnd2.close();

                // Open new InfoWindow for mouseover event
                infoWnd.open(map, marker1);

                // Store new open InfoWindow in global variable
                activeInfoWindow = infoWnd;
            });
            marker1.setIcon('http://maps.google.com/mapfiles/ms/icons/green-dot.png');
            google.maps.event.addListener(marker1, 'mouseout', function() {
                infoWnd.close();
            });





        }




        function handleLocationError(browserHasGeolocation, infoWindow, pos) {
            infoWindow.setPosition(pos);
            infoWindow.setContent(browserHasGeolocation ?
                'Error: The Geolocation service failed.' :
                'Error: Your browser doesn\'t support geolocation.');
            infoWindow.open(map);
        }
    
    