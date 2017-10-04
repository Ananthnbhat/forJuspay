<?php
function getDistance($lat1,$lon1,$lat2,$lon2) {
 $R = 6371; // Radius of the earth in km
 $dlat = deg2rad($lat2-$lat1);  // deg2rad below
 $dlon = deg2rad($lon2-$lon1); 
 $a = sin($dlat/2) * sin($dlat/2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dlon/2) * sin($dlon/2);  
 $c = 2 * atan2(sqrt($a), sqrt(1-$a)); 
 $d = $R * $c; // Distance in km
 return $d;
 }
 //array_push($result,array('Name' => $rr['fullName'] , 'Email' => $rr['userEmail'], 'Number' => $rr['num'] ));
session_start();
require_once 'class.user.php';
$user_home = new USER();

if(!$user_home->is_logged_in())
{
	$user_home->redirect('index.php');
}

$stmt = $user_home->runQuery("SELECT * FROM tbl_users WHERE userID=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$lat1 = floatval($row['lat']);
$lon1 = floatval($row['lng']);
if($row['type'] == 'Student'){
    $stype = 'Teacher';
} else if($row['type'] == 'Teacher') {
    $stype = 'Student';
}

?>






    <!DOCTYPE html>
    <html lang="en">

    <head>
        <title>
            <?php echo $row['userEmail']; ?>
        </title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
        <link href="css/style.css" rel="stylesheet">
        <link rel="stylesheet" href="style.css">


        <script type="text/javascript">
            // document.onload = () => {
            //     console.log(Hello)
            // };


            var map;
            var activeInfoWindow;
            var infoWindow;
            var obj;
            //var locations;


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
                    console.log('Didn\'t have time to do this');
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
            
            var locations = [{
                lat: -31.563910,
                lng: 147.154312
            }, {
                lat: -33.718234,
                lng: 150.363181
            }, {
                lat: -33.727111,
                lng: 150.371124
            }, {
                lat: -33.848588,
                lng: 151.209834
            }];




            function handleLocationError(browserHasGeolocation, infoWindow, pos) {
                infoWindow.setPosition(pos);
                infoWindow.setContent(browserHasGeolocation ?
                    'Error: The Geolocation service failed.' :
                    'Error: Your browser doesn\'t support geolocation.');
                infoWindow.open(map);
            }
        </script>
        <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
        <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD6RdXuzC5kbJj1HOT-abvrJ1ZEW3GBzAY&callback=initMap"></script>
    </head>

    <body>
        
        
        
        <ul class="nav nav-pills justify-content-center">
            <li class="nav-item">
            <a href="#" role="button" class="nav-link"> <?php echo $row['fullName']; ?></a>
        </li>
                <li class="nav-item">
                <a class="nav-link">(<?php echo $row['type'];?>)</a>
                </li>       
           
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
            </li>

        </ul>

        <p><img src="http://maps.google.com/mapfiles/ms/icons/green-dot.png" alt="green-marker">->Shows your location</p>
        <p><img src="http://maps.google.com/mapfiles/ms/icons/blue-dot.png" alt="blue-marker">->Shows locations of Teachers if you are a Student,otherwise they are locations of Students.</p>
       



        <?php
    $stmt = $user_home->runQuery("SELECT * FROM tbl_users WHERE type = :stype");
    $stmt->bindParam(":stype", $stype);
    $stmt->execute();
    $count = $stmt->rowCount();
    $result = array();
        ?>

            <table border="1" style="float: right;margin-right: 25px;">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Contact Number</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
        $keys = array('lat','lng');
        if($count == 0){
            echo '<tr><td colspan="4">No Result found!</td></tr>';
        } else {
            while($rr = $stmt->fetch(PDO::FETCH_ASSOC)){
                    $distance = getDistance($lat1,$lon1,floatval($rr['lat']),floatval($rr['lng']));
                    if($distance <= 1){
                        array_push($result,array('lat' => $rr['lat'], 'lng' => $rr['lng']));
                        //$array = array($rr['lat'], $rr['lng']);
                        echo "<tr><td>{$rr['fullName']}</td><td>{$rr['userEmail']}</td><td>{$rr['num']}</td><td></tr>";
                    }
            }
        }

    
    ?>
                </tbody>
            </table>

            <?php  
                //$result = array_combine($keys, $result);
                $json = json_encode($result); 
               // echo  $json;
                ?>
                
                    <!-- section 1 -->

                <!-- <script type="text/javascript">
         var locations = new Object();
         var locations = ('<?= $json; ?>');
         console.log(locations[0]);
         </script> -->


            <div id="map"></div>
           

    </body>

    </html>