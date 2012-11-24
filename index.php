<?php
    require('GoogleMap.class.php');

    $map = new GoogleMap('map');
    $map->setAPIKey('xxxxxxxxxxxxxxxxxxxxxxx');
    if ( isset($_GET['location_request']) && !empty($_GET['location_request'] ) ){
		
		$location_request =trim($_GET['location_request']);
		$location_request = str_replace( ' ', '+' ,$location_request);
		$json_result = json_decode(file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='.$location_request.'&sensor=false'));
		
		$geo_result =  $json_result->results[0];
        $coordinates = $geo_result->geometry->location;
		
		$status_response = $json_result->status;
       
		$center_lat = $coordinates->lat;
		$center_lon = $coordinates->lng;
		$zoom = 10;
		
		#echo "<pre>";
		#var_dump($json_result);
		#echo "</pre>";
				
	}else{
		$center_lat = $map->center_lat;
		$center_lon = $map->center_lon;
		$zoom = $map->zoom;
	}
    ?>
	
    <!DOCTYPE html>
    <html>
    <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <style type="text/css">
      html { height: 100% }
      body { height: 100%; margin: 0; padding: 0 }
      #map{ height: 100% }
	  .sidebar {position:absolute; right:0; top:25%; z-index:9999; background-color:#fff; width:300px; height:60px; padding:20px;box-shadow:0px 0px 5px rgba(0,0,0,0.5); -moz-box-shadow:0px 0px 5px rgba(0,0,0,0.5);-webkit-box-shadow:0px 0px 5px rgba(0,0,0,0.5);}
	  .input-type {  height:30px; font-size:20px; color:#000; border:1px solid #999; width:90%; padding:5px 10px;} 
	  span { font-size:11px; color:#666;}
	</style>
	<?php $map->printHeaderJS(); ?>
    <?php #$map->initializeMapJS(); ?>
	<script type="text/javascript">
		function initialize() {
			var mapOptions = {
			    center: new google.maps.LatLng(<?=$center_lat?>,<?=$center_lon?>),
				zoom: <?=$zoom?>,
				mapTypeId: google.maps.MapTypeId.<?=$map->map_type?>
			};
			var map = new google.maps.Map(document.getElementById("<?=$map->map_id?>"),
						mapOptions);
		}
	</script>
    <!-- necessary for google maps polyline drawing in IE -->
    <style type="text/css">
      v\:* {
        behavior:url(#default#VML);
      }
    </style>
    </head>
    <body onload="initialize()">
    
    <?php $map->printMap(); ?>
    <div class="sidebar">
		<form method="GET" enctype="text/plain" >
			<input type="text" name="location_request" id="location_request" class="input-type" value="" />
			<input type="submit" value="Search" class="btn">
			<span><?=$status_response?></span>
		</form>
    </div>
    </body>
    </html>