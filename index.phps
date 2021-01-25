<?php 
include "map/map.php"; ?>

<html>
	<head>
	<meta charset="UTF-8">
	<title>Generating Multiple Maps in a Page</title>
	<style>
		
		#block-wrp {
			width: 1284px;
			display: flex;
			display: -webkit-flex;
			justify-content: space-around;
			flex-wrap: wrap;
		}
		#block-wrp .block-item {
		  height: 400px;
		  width: 48%;
		  position: relative;
		  display: flex;
		  display: -webkit-flex;
		  flex-direction: column;
		  -webkit-flex-direction: column
		}
		#block-wrp .block-item .map-item {
		  height: 90%
		}
		#block-wrp .block-item span.city-name {
		  text-align: center;
		  color: #000;
		  text-transform: uppercase;
		  font-weight: bold;
		  background: #a2ccff;
		  height: 10%;
		  line-height: 2em;
		}
		</style>
		
			
	</script>
	</head>
	
	
	<body>
	<a href="rss/feed.php">CLICK HERE FOR DATABASE RSS FEED</a> 
	
		<form id="hi" method="post">
			<label> Select Cities </label>
			<select name="firstCity">
				<?php
				while($rows = $firstCity->fetch_assoc()) 
				{
					$name = $rows['name'];
					echo "<option value=$name>$name</option>";	
				}
				?>
			</select>
			<select name="secondCity">
				<?php
				while($rows = $secondCity->fetch_assoc()) 
				{
					$name = $rows['name'];
					echo "<option value=$name>$name</option>";	
				}
				?>
			</select>
			
			<label> Date </label>
			<select name="dateCity">
				<?php
				
				for ($i = 0; $i < 7; $i++ ) {
					
					$d=strtotime("+".$i." day");
					$mydate[i] = date("dmY", $d);
					$mydate2[i] = date("d-m-Y", $d);
					echo "<option value=$mydate[i]>$mydate2[i]</option>";
					
				}
				?>
				
			</select>
			
			
			
			<input type="submit" name="submit" value="submit"/>
		</form>
		
		
		<div id="block-wrp">
			<div class="block-item">
			<div id="mapCanvas1" class="map-item"> </div>
			<span class="city-name"> <?php echo $getcity; ?></span> 
			<span class="city-name"> Temperature: <?php echo $description; echo " "; echo $temperature; ?></div>
			<div class="block-item">
			<div id="mapCanvas2" class="map-item"> </div>
			<span class="city-name"> <?php echo $getcity2; ?></span> 
			<span class="city-name"> Temperature: <?php echo $description2; echo " "; echo $temperature2; ; ?></span> </div>
		</div>
		
		
		
		<div id="poi-desc1" style="display: none;">
		<?php
        echo htmlspecialchars($setDesc[0]); 
		?>
		</div>
		
		<div id="poi-desc2" style="display: none;">
		<?php
        echo htmlspecialchars($setDesc[1]); 
		?>
		</div>
		<div id="poi-desc3" style="display: none;">
		<?php
        echo htmlspecialchars($setDesc[2]); 
		?>
		</div>
		
		<div id="poi-desc4" style="display: none;">
		<?php
        echo htmlspecialchars($setDesc[3]); 
		?>
		</div>
		<div id="poi-desc5" style="display: none;">
		<?php
        echo htmlspecialchars($setDesc[4]); 
		?>
		</div>
		
		<div id="poi-desc6" style="display: none;">
		<?php
        echo htmlspecialchars($setDesc[5]); 
		?>
		</div>
		
		<div id="poi-desc12" style="display: none;">
		<?php
        echo htmlspecialchars($setDesc2[0]); 
		?>
		</div>
		
		<div id="poi-desc22" style="display: none;">
		<?php
        echo htmlspecialchars($setDesc2[1]); 
		?>
		</div>
		<div id="poi-desc32" style="display: none;">
		<?php
        echo htmlspecialchars($setDesc2[2]); 
		?>
		</div>
		
		<div id="poi-desc42" style="display: none;">
		<?php
        echo htmlspecialchars($setDesc2[3]); 
		?>
		</div>
		<div id="poi-desc52" style="display: none;">
		<?php
        echo htmlspecialchars($setDesc2[4]); 
		?>
		</div>
		
		<div id="poi-desc62" style="display: none;">
		<?php
        echo htmlspecialchars($setDesc2[5]); 
		?>
		</div>		
		
		
		
		<script >
		var map1, map2;
		
		// Multiple desc
		var div1 = document.getElementById("poi-desc1");
		var getDesc1 = div1.textContent;
		var div2 = document.getElementById("poi-desc2");
		var getDesc2 = div2.textContent;
		var div3 = document.getElementById("poi-desc3");
		var getDesc3 = div3.textContent;
		var div4 = document.getElementById("poi-desc4");
		var getDesc4 = div4.textContent;
		var div5 = document.getElementById("poi-desc5");
		var getDesc5 = div5.textContent;
		var div6 = document.getElementById("poi-desc6");
		var getDesc6 = div6.textContent;
		
		var div12 = document.getElementById("poi-desc12");
		var getDesc12 = div12.textContent;
		var div22 = document.getElementById("poi-desc22");
		var getDesc22 = div22.textContent;
		var div32 = document.getElementById("poi-desc32");
		var getDesc32 = div32.textContent;
		var div42 = document.getElementById("poi-desc42");
		var getDesc42 = div42.textContent;
		var div52 = document.getElementById("poi-desc52");
		var getDesc52 = div52.textContent;
		var div62 = document.getElementById("poi-desc62");
		var getDesc62 = div62.textContent;
		
		// City Markers
		var firstCityLat  = 	<?php	echo json_encode($myFirstCityLat) ?>;
		var firstCityLng  =  	<?php	echo json_encode($myFirstCityLng) ?>;
		var SecondCityLat = 	<?php	echo json_encode($mySecondCityLat) ?>;
		var SecondCityLng = 	<?php	echo json_encode($mySecondCityLng) ?>;
		
		// Multiple Cities POI Markers
		var firstCityMakerLat  =	<?php	echo json_encode($myFirstCityPOILat) ?>;
		var firstCityMakerLng  =	<?php	echo json_encode($myFirstCityPOILng) ?>;
		var secondCityMakerLat =	<?php	echo json_encode($mySecondCityPOILat) ?>;
		var secondCityMakerLng =	<?php	echo json_encode($mySecondCityPOILng) ?>;
		
		// Multiple Descriptions

		var inforwindowContent = [getDesc1, getDesc2, getDesc3, getDesc4, getDesc5, getDesc6];
		var inforwindowContent2 = [getDesc12, getDesc22, getDesc32, getDesc42, getDesc52, getDesc62];
		
		// Multiple images 
		var my_images  = <?php	echo json_encode($setFirstCityImage) ?>;
		var my_images2 = <?php	echo json_encode($setSecondCityImage) ?>;

		
		function drawMap() {
			var mapOptions = {
				zoom: 9,
				mapTypeId: google.maps.MapTypeId.ROADMAP,
				mapTypeControl: true,
				fullscreenControl: false 
			
			}
			
			
			// Display first map + city marker 
			var point1 = new google.maps.LatLng(firstCityLat, firstCityLng); 
			mapOptions.center = new google.maps.LatLng(firstCityLat, firstCityLng); 
			map1 = new google.maps.Map(document.getElementById("mapCanvas1"), mapOptions);
			
			
			var iconBase = 'https://maps.google.com/mapfiles/kml/shapes/';
			  var marker = new google.maps.Marker({
				map: map1,
				center: mapOptions.center,
				position: point1,
				
				icon: iconBase + 'parking_lot_maps.png'
			  });
			  
			
			// Display second map + city marker 
			var point2 = new google.maps.LatLng(SecondCityLat, SecondCityLng);
			mapOptions.center = new google.maps.LatLng(SecondCityLat, SecondCityLng); 
			map2 = new google.maps.Map(document.getElementById("mapCanvas2"), mapOptions);
		
			var iconBase = 'https://maps.google.com/mapfiles/kml/shapes/';
			  var marker = new google.maps.Marker({
				map: map2,
				
				position: point2,
				
				icon: iconBase + 'parking_lot_maps.png'
			  });
			  
			
			
			// Display multiple markers on a map
				var infoWindow = new google.maps.InfoWindow(), marker, i;


			// Loop through our array of markers &amp; place each one on the map  
			for( i = 0; i < 6; i++ ) {
				var position = new google.maps.LatLng(firstCityMakerLat[i], firstCityMakerLng[i]);
				//bounds.extend(position);
				marker = new google.maps.Marker({
					position: position,
					center: mapOptions.center,
					map: map1,
					
				});
				
				google.maps.event.addListener(marker, 'mouseover', (function(marker, i) {
				return function() {
					
					infoWindow.setContent(inforwindowContent[i] + "<img src=" + my_images[i] + ">"); // add infor content here
					infoWindow.open(map1, this);
				}
			})(marker, i));
			
			}
     
			// Loop through our array of markers &amp; place each one on the map  
			
			for( i = 0; i < 6; i++ ) {
				
				var position = new google.maps.LatLng(secondCityMakerLat[i], secondCityMakerLng[i]);
				//bounds.extend(position);
				marker = new google.maps.Marker({
					position: position,
					center: mapOptions.center,
					map: map2, 
				});
				
				google.maps.event.addListener(marker, 'mouseover', (function(marker, i) {
				return function() {

				 
				  
					infoWindow.setContent(inforwindowContent2[i] + "<img src=" + my_images2[i] + ">"); // add infor content here
				
					infoWindow.open(map2, this);
				}

			})(marker, i));
			
			}
		}

		</script> 
		<script async defer src="<?php echo $map_access ?>" > </script>

		<script async defer src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	</body>
</html>


