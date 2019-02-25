<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Simple Markers</title>
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
  </head>
  <body>
    <div id="map"></div>
    <script>

      function initMap() {
        var myLatLng = {lat: 40.729429, lng: -73.997218};
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 15,
          center: myLatLng
        });
        var contentString1 = '<div id="content">'+
            '<div id="siteNotice">'+
            '</div>'+
            '<h1 id="firstHeading" class="firstHeading">note by pasha</h1>'+
            '<div id="bodyContent">'+
            '<p>Hey, I am at Bobst</p>' +
            '</div>'+
            '</div>';
        var infowindow1 = new google.maps.InfoWindow({
          content: contentString1
        });
        var marker1 = new google.maps.Marker({
          position: myLatLng,
          map: map,
          title: 'note by pasha'
        });
        marker1.addListener('click', function() {
          infowindow1.open(map, marker1);
        });
        var myLatLng = {lat: 40.718430, lng: -74.000532};
        var contentString = '<div id="content">'+
            '<div id="siteNotice">'+
            '</div>'+
            '<h1 id="firstHeading" class="firstHeading">note by avi</h1>'+
            '<div id="bodyContent">'+
            '<p>Hey, I am at Canal Street</p>' +
            '</div>'+
            '</div>';
        var infowindow = new google.maps.InfoWindow({
          content: contentString
        });
        var marker = new google.maps.Marker({
          position: myLatLng,
          map: map,
          title: 'note by avi'
        });
        marker.addListener('click', function() {
          infowindow.open(map, marker);
        });
      }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=&callback=initMap">
    </script>
  </body>
</html>