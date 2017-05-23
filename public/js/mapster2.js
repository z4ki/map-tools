$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


/*** Global Variables to store it in the database via ajax **/

var infowindowId = 0;
var CIRCLES = [],
    POLYGONS = [],
    RECTANGLES = [],
    MARKER = [],
    SHAPES = [],
    infoWindowArr = [],
    infoWindowsGlobal = [],
    deletedOverlays = [],
    deletedInfoWindow = [],
    POLYLINES = [];
var fillColor,fillOpacity = 0.3;
/*
infowindow.push({
  "title":Google,
  "description": my infowindow,
  "latLngs":coords
})
*/



function getInfoWindow(id) {
    for (var j = 0; j < infoWindowArr.length; j++) {
        if (id === infoWindowArr[j].id) {

            var info = infoWindowArr[j];
            return info;
        }
    }
}

function computeArea(path) {
    var area = google.maps.geometry.spherical.computeArea(path);
    return area;
}

$(document).ready(function() {

    $('.tooltipped').tooltip({
        delay: 50
    });

});


var map;

function initMap() {
    map = new google.maps.Map(document.getElementById('map'), {
        center: {
            lat: 36.1768545,
            lng: 6.4502461
        },
        zoom: 12,
        disableDefaultUI: false,
        fullscreenControl: true
    });


    var input = document.getElementById('searchbar');

    var searchBox = new google.maps.places.SearchBox(input);
    map.addListener('bound_changed', function() {
        searchBox.setBounds(map.getBounds());
    });

    var markers = [];
    searchBox.addListener('places_changed', function() {
        var places = searchBox.getPlaces();
        if (places.length == 0) {
            return;
        }
        // Clear out the old markers 
        markers.forEach(function(marker) {
            marker.setMap(null);
        });
        markers = [];

        // For each place ,get the icon, name and location

        var bounds = new google.maps.LatLngBounds();
        places.forEach(function(place) {
            if (!place.geometry) {
                console.log('Returned place contain no geometry.');
                return;
            }
            var icon = {
                url: place.icon,
                size: new google.maps.Size(71, 71),
                origin: new google.maps.Point(0, 0),
                anchor: new google.maps.Point(17, 34),
                scaledSize: new google.maps.Size(25, 25)
            };
            //Create a maker for each place
            markers.push(new google.maps.Marker({
                map: map,
                icon: icon,
                title: place.name,
                position: place.geometry.location
            }));


            if (place.geometry.viewport) {
                // Only geocodes have viewport
                bounds.union(place.geometry.viewport);
            } else {
                bounds.extend(place.geometry.location);
            }
        });
        map.fitBounds(bounds);
    });


    // Function for adding new infoWindow to the map.




    function showInfoWindow(overlay, event) {
        var inputwindow = new google.maps.InfoWindow();
        var inputContent =
            '<div class="row">' +
            '<form class="">' +
            '<div class="row">' +
            '<div class="input-field">' +
            '<input id="title-iw" type="text" class="validate">' +
            '<label for="title-iw">Title</label>' +
            '</div>' +
            '</div>' +
            '<div class="row">' +
            '<div class="input-field">' +
            '<textarea id="textarea-iw" class="materialize-textarea"></textarea>' +
            '<label for="textarea-iw">Description</label>' +
            '<a href="#" id="infowindow-btn" class="btn right">save</a>' +
            '</div>' +
            '</div>' +
            '</form></div>';

        // var latLng = {
        //     lat: event.latLng.lat(),
        //     lng: event.latLng.lng()
        // };

        inputwindow.setContent(inputContent);
        inputwindow.setPosition(latLng);
        inputwindow.open(map);
        $('#infowindow-btn').on('click', function() {

            var title = $('#title-iw').val();
            var description = $('#textarea-iw').val();
            var content = '<h5>' + title + '</h5><p>' + description + '</p>';

            if (inputwindow !== null) {
                google.maps.event.clearInstanceListeners(inputwindow); // just in case handlers continue to stick around
                inputwindow.close();
                inputwindow = null;

            }
            infoWindowArr.push({
                'title': title,
                'description': description,
                'latLng': latLng
            });
            console.log("InfoWindow Array : ", infoWindowArr);
            var infowindow = new google.maps.InfoWindow({
                content: content,
                position: latLng
            });

            /*infowindow.setContent(content);
            infowindow.setPosition(latLng);*/
            var infoWindowListener;

            if (overlay.type) {

                infoWindowListener = overlay.overlay;


            } else if (overlay === 'rightclick') {

                infoWindowListener = new google.maps.Marker({
                    position: latLng,
                    map: map
                });
                // console.log('marker');
            }

            infoWindowListener.addListener('click', function() {
                infowindow.open(map);
            });
            map.addListener('click', function() {
                infowindow.close();
            });
        });


    }


    /*map.addListener('rightclick', function (event) {
      
      showInfoWindow('rightclick', event);
    });*/


    // 
    // 
    // Clear all shapes on the map 
    // 
    // 

    $('#clear').on('click', function() {
        for (var i = 0; i < SHAPES.length; i++) {

            SHAPES[i].setMap(null);
        }
    });

    $('#undo').on('click', function() {
        var overlay = SHAPES.pop();
        var info = infoWindowArr.pop();

        deletedOverlays.push(overlay);
        deletedInfoWindow.push(info);
        overlay.setMap(null);
        info.setMap(null);
    });

    $('#redo').on('click', function() {
        var overlay = deletedOverlays.pop();
        var info = deletedInfoWindow.pop();
        SHAPES.push(overlay);
        infoWindowArr.push(info);
        overlay.setMap(map);
        info.setMap(map);
    });

    // 
    // 
    // get the Current Location of the user 
    // 
    // 



    navigator.geolocation.getCurrentPosition(function(position) {
        var latLngs = {
            lat: position.coords.latitude,
            lng: position.coords.longitude
        };
        // var infoWindow = new google.maps.InfoWindow({
        //   map: map
        // });
        // infoWindow.setPosition(latLngs);
        // infoWindow.setContent('You current location.');
        // var marker = new google.maps.Marker({
        //   map:map,
        //   position:latLngs
        // });
        // marker.addListener('click',function(){
        //   infoWindow.open(map);
        // });
        // map.setCenter(latLngs);
    });



    // 
    // 
    // 
    /*** Event Listeners For h-bar on the map ***/

    /* function toggleButton(btnID) {
    var btn = document.getElementById(btnID);

    btn.addEventListener('click', function () {
      if (btnID === 'polygon') {
        $("#circle").css("font-weight", "normal");
        $("#rectangle").css("font-weight", "normal");
        $("#polyline").css("font-weight", "normal");

      } else if (btnID === 'circle') {
        $("#polygon").css("font-weight", "normal");
        $("#rectangle").css("font-weight", "normal");
        $("#polyline").css("font-weight", "normal");

      } else if (btnID === 'rectangle') {
        $("#polygon").css("font-weight", "normal");
        $("#circle").css("font-weight", "normal");
        $("#polyline").css("font-weight", "normal");

      } else if (btnID === 'polyline') {
        $("#polygon").css("font-weight", "normal");
        $("#rectangle").css("font-weight", "normal");
        $("#circle").css("font-weight", "normal");

      }
      drawingManager.setMap(null);
      $(this).css("font-weight", "bold");
      drawingManager.setOptions({
        drawingControlOptions: {
          drawingModes: [btnID],

        }
      });
      toggleDrawingManager(drawingManager);
    });
  }
*/

    /*toggleButton('polygon');
    toggleButton('circle');
    toggleButton('rectangle');
    toggleButton('polyline');*/


    /* Circle button */

    // 
    // 
    // 
    /* Custom Controls To Add Buttons the map*/
    /* Polygon ,Circle ,Rectangle Buttons  */


    // function CenterControl(controlDiv, map, id) {

    //   // Set CSS for the control border.
    //   var controlUI = document.createElement('div');
    //   var btnUI = document.getElementById(id);
    //   btnUI.style.marginBottom = '10px';

    //   controlDiv.appendChild(btnUI);

    //   // Set CSS for the control interior.
    //   var controlText = document.createElement('div');


    //   controlUI.appendChild(controlText);



    // }


    // Create the DIV to hold the control and call the CenterControl()
    // constructor passing in this DIV.
    /*var centerControlDiv = document.createElement('div');
    var centerControl = new CenterControl(centerControlDiv, map, 'h-bar');

    centerControlDiv.index = 1;
    map.controls[google.maps.ControlPosition.BOTTOM_CENTER].push(centerControlDiv);*/


    //
    // 
    // 
    // 
    /* Drawing Manager  */

    var drawingManager = new google.maps.drawing.DrawingManager({
        drawingMode: null,
        drawingControl: true,
        drawingControlOptions: {
            position: google.maps.ControlPosition.TOP_CENTER,
            drawingModes: ['marker', 'circle', 'polygon', 'polyline', 'rectangle']
        },
        markerOptions: {
            icon: 'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png'
        },
        circleOptions: {
            fillOpacity: 0.3,
            strokeWeight: 2,
            clickable: false,
            editable: true,
            draggable: true
        },
        polygonOptions: {
            fillOpacity: 0.3,
            strokeWeight: 2,
            draggable: true
        },
        rectangleOptions: {
            fillOpacity: 0.3,
            strokeWeight: 2,
            draggable: true
        },
        polylineOptions: {
            fillOpacity: 0.3,
            strokeWeight: 2,
            draggable: true
        }
    });

    // toggle the drawing manager on and off
    drawingManager.setMap(map);

    function toggleDrawingManager(drawingManager) {
        if (drawingManager.map) {
            drawingManager.setMap(null);
        } else {
            drawingManager.setMap(map);
        }
    }


    // 
    // 
    // overlay compelete event listener on every shape complete perform these instructions 
    // 
    // 

    //  global variable for the computeLength and ComputeArea
    var distance, area;

    google.maps.event.addListener(drawingManager, 'overlaycomplete', function(event) {
      
      console.log(event);
        SHAPES.push(event.overlay);


        /* Adding a RightClick  Listener to every shape completed for showing the infoWindow */
        // event.overlay.addListener('rightclick', function (e) {
        //   // e.preventDefault();
        //   showInfoWindow(event, e);
        // });


        /* Storing Circle params */

        if (event.type === 'circle') {

            CIRCLES.push({
                "id": infowindowId,
                "centerLat": event.overlay.center.lat(),
                "centerLng": event.overlay.center.lng(),
                "radius": event.overlay.radius,
                "fillColor": event.overlay.fillColor,
                "fillOpacity": event.overlay.fillOpacity,
                "strokeWeight": event.overlay.strokeWeight,
                "zIndex": event.overlay.zIndex
            });

            var cirlceArea = Math.PI * Math.pow(event.overlay.radius, 2);

            var content = '<h5>Surface</h5><b>';
            if( cirlceArea >=  10000 &&  cirlceArea < 1000000){
              content  += cirlceArea / 10000 + ' Hectare</b>';
            }else if(cirlceArea >=  1000000){
              content  += cirlceArea / 1000000 + ' KM²</b>';
            }else {
              content  += cirlceArea + ' M²</b>';

            }
            var circleInfoWindow = new google.maps.InfoWindow({
                id: infowindowId,
                content: content,
                position: event.overlay.center,
                map: map
            });

            infoWindowsGlobal.push({
                "id": infowindowId,
                "content": content,
                "position": {
                    "lat": event.overlay.center.lat(),
                    "lng": event.overlay.center.lng()
                }
            });
            // circleInfoWindow.setMap(map);
            // circleInfoWindow.open(map);

            // infoWindowArr.push(circleInfoWindow);

            event.overlay.addListener('mouseover', function(e) {
                console.log('open');
                circleInfoWindow.open(map);
            });

            event.overlay.addListener('mouseout', function(e) {
                circleInfoWindow.close();
            });

            
        


        } else if (event.type === 'rectangle') {

            /*event.overlay.addListener('rightclick',addInfoWindow);*/
            /*console.log("Rectangle path:",event.overlay);*/
            var bounds = event.overlay.getBounds();
            var northEast = new google.maps.LatLng(bounds.getNorthEast().lat(), bounds.getNorthEast().lng());
            var southWest = new google.maps.LatLng(bounds.getSouthWest().lat(), bounds.getSouthWest().lng());
            var southEast = new google.maps.LatLng(bounds.getSouthWest().lat(), bounds.getNorthEast().lng());
            var northWest = new google.maps.LatLng(bounds.getNorthEast().lat(), bounds.getSouthWest().lng());
            var center = new google.maps.LatLng(bounds.getCenter().lat(), bounds.getCenter().lng());

            RECTANGLES.push({
                "id": infowindowId,
                "northEast": {
                    "lat": northEast.lat(),
                    "lng": northEast.lng()
                },
                "southWest": {
                    "lat": southWest.lat(),
                    "lng": southWest.lng()
                },
                "center": [center.lat(), center.lng()],
                "zIndex": event.overlay.zIndex,
                "strokeWeight": event.overlay.strokeWeight,
                "fillColor": event.overlay.fillColor,
                "fillOpacity": event.overlay.fillOpacity,
                "strokeOpacity": event.overlay.strokeOpacity
            });



            //  the calculated area unit is KM²

            var rectArea = computeArea([northEast, northWest, southWest, southEast]);

            // var content = '<h5>Rectangle Area</h5><b>' + rectArea + ' Km²</b>';
            var content = '<h5>Surface</h5><b>';
            if(rectArea >=  10000 && rectArea <  1000000){
              content  += rectArea / 10000 + ' Hectare</b>';
            }else if(rectArea >=  1000000){
              content  += rectArea / 1000000 + ' KM²</b>';
            }else {
              content  += rectArea + ' M²</b>';

            }
            var rectangleInfoWindow = new google.maps.InfoWindow({
                id: infowindowId,
                content: content,
                map: map,
                position: center
            }).open(map);

            infoWindowsGlobal.push({
                "id": infowindowId,
                "content": content,
                "position": {
                    "lat": center.lat(),
                    "lng": center.lng()
                }
            });

            
        


        } else if (event.type === 'polyline') {

            var coords = event.overlay.getPath().getArray();
            var latLngs = [];
            for (var i = 0; i < coords.length; i++) {
                latLngs.push(coords[i].lat());
                latLngs.push(coords[i].lng());
            }
            POLYLINES.push({
                "id": infowindowId,
                "latLngs": latLngs,
                "zIndex": event.overlay.zIndex
            });
            // the calculated Distance unit is in Meters
            distance = google.maps.geometry.spherical.computeLength(event.overlay.getPath());
            var content = '<h5>Distance</h5><b>';
            if(distance > 1000){
              content += distance / 1000  + ' KM</b>';
            }else{
              content += distance   + ' M</b>';
            }
            var polylineInfoWindow = new google.maps.InfoWindow({
                id: infowindowId,
                content: content,
                map: map,
                position: event.overlay.getPath().getArray()[0]
            }).open(map);

            infoWindowsGlobal.push({
                "id": infowindowId,
                "content": content,
                "position": {
                    "lat": event.overlay.getPath().getArray()[0].lat(),
                    "lng": event.overlay.getPath().getArray()[0].lng()
                }
            });
            
        


        } else if (event.type === 'polygon') {


            var obj = [];

            /*SHAPES.push(event.overlay);*/


            for (var i = 0; i < event.overlay.getPath().length; i++) {
                obj.push(event.overlay.getPath().getArray()[i].lat());
                obj.push(event.overlay.getPath().getArray()[i].lng());

            }

            // the calculated Area Unit is in M²

            area = computeArea(event.overlay.getPath());
            var infowindow = new google.maps.InfoWindow();
            // var content = '<h5>Area</h5><b>' + area + ' m²</b>'
            var content = '<h5>Surface</h5><b>';

            if(area >=  10000 &&  area < 1000000){
              content  += area / 10000 + ' Hectare</b>';
            }else if(area >=  1000000){
              content  += area / 1000000 + ' KM²</b>';
            }else {
              content  += area + ' M²</b>';

            }

            infowindow.setContent(content);
            infowindow.setMap(map);

            infoWindowArr.push(infowindow);
            var pos = event.overlay.getPath().getArray()[0];

            infowindow.setPosition(pos);
            infowindow.open(map);

            event.overlay.addListener('mouseover', function() {
                infowindow.open(map);
            });
            event.overlay.addListener('mouseout', function() {
                infowindow.close();
            });

            infoWindowsGlobal.push({
                "id": infowindowId,
                "content": content,
                "position": {
                    "lat": pos.lat(),
                    "lng": pos.lng()
                }
            });
            POLYGONS.push({
                "id": infowindowId,
                "fillOpacity": event.overlay.fillOpacity,
                "fillColor": event.overlay.fillColor,
                "strokeWeight": event.overlay.strokeWeight,
                "length": event.overlay.getPath().length,
                "latLngs": obj,
                "area": area,
                "zIndex": event.overlay.zIndex
            });
            
        
            console.log(POLYGONS);
            console.log(infoWindowsGlobal);

        }else  if(event.type === "marker"){
          // alert(infowindowId);

          var inputwindow = new google.maps.InfoWindow();
          var inputContent =
              '<div class="row">' +
              '<form class="">' +
              '<div class="row">' +
              '<div class="input-field">' +
              '<input id="title-iw" type="text" class="validate">' +
              '<label for="title-iw">Title</label>' +
              '</div>' +
              '</div>' +
              '<div class="row">' +
              '<div class="input-field">' +
              '<textarea id="textarea-iw" class="materialize-textarea"></textarea>' +
              '<label for="textarea-iw">Description</label>' +
              '<a href="#" id="infowindow-btn" class="btn right">save</a>' +
              '</div>' +
              '</div>' +
              '</form></div>';

          var latLng = {
              lat: event.overlay.position.lat(),
              lng: event.overlay.position.lng()
          };

          inputwindow.setContent(inputContent);
          inputwindow.setPosition(latLng);
          inputwindow.open(map);
          
          
          var content;
          var markerInfoWindow;
          $('#infowindow-btn').on('click', function() {


              var title = $('#title-iw').val();
              var description = $('#textarea-iw').val();
              content = '<h5>' + title + '</h5><p>' + description + '</p>';
              inputwindow.close();
              google.maps.event.clearInstanceListeners(inputwindow);

              markerInfoWindow = new google.maps.InfoWindow({
                id: infowindowId - 1 ,
                content:content,
                position:latLng,
                map:map
              });
              // alert(infowindowId);
              infoWindowsGlobal.push({
                "id": markerInfoWindow.id,
                "content": content,
                "position": {
                    "lat": event.overlay.position.lat(),
                    "lng": event.overlay.position.lng()
                }
            });
            });

          event.overlay.addListener('click',function(){
              
              markerInfoWindow.open(map);
          });
              // alert(infowindowId);

          MARKER.push({
            "id":infowindowId,
            "position": {
                    "lat": event.overlay.position.lat(),
                    "lng": event.overlay.position.lng()
                }
          });
          
          
          console.log(MARKER[0].id);
          console.log(infoWindowsGlobal);

        }
        infowindowId++;
    });



    // post the data with ajax post request 
    $("#map-form").on("submit", function(e) {
        e.preventDefault();

        takeScreenshot();



    });

    /***********************/
    /** Color palette js **/

    (function() {
        
        var palette = [
            "#f44336",
            "#e91e63",
            "#9c27b0",
            "#2196f3",
            "#03a9f4",
            "#009688",
            "#4caf50",
            "#cddc39",
            "#ff5722",
            "#795548",
            "#607d8b"
        ];


        var i = 0;
        var bar = $('.color');
        /*console.log(bar);*/
        $(".color").each(function() {

            $(this).css("background-color", palette[i]);
            $(this).attr("id", palette[i]);


            $(this).on("click", function() {
                fillColor = $(this).attr("id");

                drawingManager.setOptions({
                    circleOptions: {
                        fillOpacity: fillOpacity,
                        fillColor: fillColor
                    },
                    polygonOptions: {
                        fillOpacity: fillOpacity,
                        fillColor: fillColor,
                        editable:true
                    },
                    polylineOptions: {
                        fillOpacity: fillOpacity,
                        fillColor: fillColor
                    },
                    rectangleOptions: {
                        fillOpacity: fillOpacity,
                        fillColor: fillColor
                    }
                });


            });
            i++;
        });
    }());

    $('input[type="range"]').on('change',function(){
      fillOpacity  = $(this).val();
        drawingManager.setOptions({
          circleOptions: {
            fillOpacity: fillOpacity,
            fillColor: fillColor
        },
        polygonOptions: {
            fillOpacity: fillOpacity,
            fillColor: fillColor
        },
        rectangleOptions: {
            fillOpacity: fillOpacity,
            fillColor: fillColor
        },
        polylineOptions: {
            fillOpacity: fillOpacity,
            fillColor: fillColor
        }
          
        });

   });



    // 
    // 
    // 
    // 
    // load the map 



    if (window.location.pathname !== '/dash') {
      $('#save-modal').html('update');

        $(document).ready(function() {
            var globalBounds = new google.maps.LatLngBounds();
            var allShapes = new Array();
            var points = new Array();

            $.get(
                window.location.pathname,
                function(data) {

                    console.log("received data:", data);
                    var json = JSON.parse(data[0].map);
                    console.log(json);
                    /*var circle  = json.circles["0"];*/




                    /* Converting to array*/
                    var circle = $.makeArray(json.circles);
                    var polygon = $.makeArray(json.polygons);
                    var polyline = $.makeArray(json.polylines);
                    var rectangle = $.makeArray(json.rectangles);
                    var infoWindows = $.makeArray(json.infoWindow);
                    var markers = $.makeArray(json.markers);
                    console.log("circle", circle);
                    console.log("polygon", polygon);
                    console.log("polyline", polyline);
                    console.log("rectangle", rectangle);
                    console.log("infoWindows", infoWindows);
                    console.log("marker", markers);

                    

                    /* reload Polylines*/
                    var polylinePath = [];
                    for (var i = 0; i < polyline.length; i++) {

                        var p = polyline[i];
                        console.log(p);
                        for (var j = 0; j < p.latLngs.length; j += 2) {
                            // console.log(j);
                            polylinePath.push({
                                lat: parseFloat(p.latLngs[j]),
                                lng: parseFloat(p.latLngs[j + 1])
                            });
                            // console.log(parseFloat(p.latLngs[j]));
                        }
                        var newPolyline = new google.maps.Polyline({
                            id: p.id,
                            path: polylinePath,
                            map: map
                        });
                        updateBounds(polylinePath, 'polygon');

                        // newPolyline.addListener('mouseover', function() {
                        //     var id = this.id;
                        //     var info = getInfoWindow(id);
                        //     info.open(map);

                        // });
                        // newPolyline.addListener('mouseout', function() {
                        //     var id = this.id;
                        //     var info = getInfoWindow(id);
                        //     info.close();
                        // });
                    }


                    /* reload InfoWindows */

                    var newInfoWindow = []
                    for (var i = 0; i < infoWindows.length; i++) {

                        var content = infoWindows[i].content;
                        var pos = new google.maps.LatLng(parseFloat(infoWindows[i].position.lat), parseFloat(infoWindows[i].position.lng));
                        newInfoWindow[i] = new google.maps.InfoWindow({
                            id: parseInt(infoWindows[i].id),
                            content: content,
                            position: pos,
                            map:map
                        });
                        infoWindowArr.push(newInfoWindow[i]);




                    }

                    //  reload markers 
                    for(var i =0;i<markers.length;i++){
                      var marker = new google.maps.Marker({
                        id:markers[i].id,
                        map:map,
                        position:{lat:parseFloat(markers[i].position.lat),lng:parseFloat(markers[i].position.lng)}
                      });
                      marker.addListener('click',function(){
                        var info = getInfoWindow(parseInt(this.id));
                        info.open(map);
                      });
                      updateBounds(marker.getPosition(),'marker');
                    }
                    /* Draw a Rectangle */
                    // console.log(typeof(rectangle[i].northEast[0]));
                    for (var i = 0; i < rectangle.length; i++) {
                        // console.log(parseFloat(rectangle[i].southWest.lat));
                        var rectangleShape = new google.maps.Rectangle({
                            id: parseInt(rectangle[i].id),
                            editable: true,
                            draggable: true,
                            fillColor: rectangle[i].fillColor,
                            fillOpacity:rectangle[i].fillOpacity,
                            map: map,
                            bounds: new google.maps.LatLngBounds(
                                new google.maps.LatLng(parseFloat(rectangle[i].southWest.lat), parseFloat(rectangle[i].southWest.lng)),
                                new google.maps.LatLng(parseFloat(rectangle[i].northEast.lat), parseFloat(rectangle[i].northEast.lng))
                            )
                        });
                        var rectBounds = [
                            [parseFloat(rectangle[i].southWest.lat), parseFloat(rectangle[i].southWest.lng)],
                            [parseFloat(rectangle[i].northEast.lat), parseFloat(rectangle[i].northEast.lng)]
                        ];

                        rectangleShape.addListener('mouseover', function() {
                            var id = this.id;
                            var info = getInfoWindow(id);
                            info.open(map);

                        });
                        rectangleShape.addListener('mouseout', function() {
                            var id = this.id;
                            var info = getInfoWindow(id);
                            info.close();



                        });

                        updateBounds(rectangleShape, 'rectangle');
                        SHAPES.push(rectangleShape);



                    }
                    /* Draw the Circles */
                    var c;

                    for (var i = 0; i < circle.length; i++) {

                        c = circle[i];
                        var newCircle = new google.maps.Circle({
                            id: parseInt(c.id),
                            editable: true,
                            fillColor: c.fillColor,
                            fillOpacity: c.fillOpacity,
                            center: {
                                lat: parseFloat(c.centerLat),
                                lng: parseFloat(c.centerLng)
                            },
                            strokeWeight: c.strokeWeight,
                            radius: parseFloat(c.radius),
                            zIndex: c.zIndex,
                            draggable: true,
                            map: map

                        });

                        SHAPES.push(newCircle);
                        updateBounds(newCircle, 'circle');

                        newCircle.addListener("radius_changed", function() {
                            // alert("need to Calculate the Area of me Circle" + this.id);
                            var id = this.id;
                            var circle = this;
                            var info = getInfoWindow(id);
                            var cirlceArea = Math.PI * Math.pow(circle.getRadius(), 2);


                            var newContent = '<h3>Circle Area</h2><b>' + cirlceArea + 'M²</b>';
                            info.setContent(newContent);
                            info.open(map);

                        });

                        newCircle.addListener("drag", function() {
                            var center = this.getCenter();
                            var id = this.id;
                            var info = getInfoWindow(id);
                            info.setPosition(center);
                        });

                        newCircle.addListener("mouseover", function() {
                            var id = this.id;
                            var info = getInfoWindow(id);
                            info.open(map);

                        });
                        newCircle.addListener("mouseout", function() {
                            var id = this.id;
                            var info = getInfoWindow(id);
                            info.close();

                        });

                        /* newCircle.addListener('mouseout',function(){
                           info.close();
                         });*/




                    }

                    /* Draw the Polygons*/


                    /* path variable for polygon coordinates */
                    for (var i = 0; i < polygon.length; i++) {
                        var path = [];

                        var p = polygon[i];



                        for (var j = 0; j < p.length * 2; j += 2) {
                            path.push({
                                lat: parseFloat(p.latLngs[j]),
                                lng: parseFloat(p.latLngs[j + 1])
                            });
                        }


                        var newPolygon = new google.maps.Polygon({
                            id: p.id,
                            draggable: true,
                            editable: true,
                            fillColor: p.fillColor,
                            fillOpacity: p.fillOpacity,
                            strokeWeight: p.strokeWeight,
                            map: map,
                            /*draggable: true,*/
                            zIndex: p.zIndex,
                            path: path
                        });

                        newPolygon.addListener("drag", function() {
                            var id = this.id;
                            var info = getInfoWindow(id);
                            // console.log(this.getPath().getArray()[0]);
                            // info.setPosition(this.getPath().getArray()[0]);
                        });

                        newPolygon.addListener("mouseover", function() {
                            var id = this.id;

                            var info = getInfoWindow(parseInt(id));
                            info.open(map);

                        });
                        newPolygon.addListener("mouseout", function() {
                            var id = this.id;

                            var info = getInfoWindow(parseInt(id));
                            info.close();

                        });

                        updateBounds(path, 'polygon');
                        SHAPES.push(newPolygon);

                        google.maps.event.addListener(newPolygon,'drag',function(){
                          var info = getInfoWindow(parseInt(this.id));
                          info.setPosition(this.getPath().getArray()[0]);
                        });

                        

                        newPolygon.addListener('click',function(){
                          
                          var polygo = this;
                          alert(this.id);
                          google.maps.event.addListener(polygo.getPath(), 'insert_at', function() {
                            
                            var id = polygo.id;
                            // var int = parseInt(id) - 1;
                            console.log(id);
                            console.log(polygo);
                            // console.log(id);
                            var area = computeArea(polygo.getPath());
                            var info = getInfoWindow(parseInt(id));
                            info.setPosition(polygo.getPath().getArray()[0]);
                            info.setContent("<h5>Polygon Area</h5><b>" + area + "m²<b>");
                        });


                        google.maps.event.addListener(polygo.getPath(), 'set_at', function() {

                           var id = polygo.id;
                            // var int = parseInt(id) - 1;
                            // alert(int);
                            console.log(id);
                            console.log(polygo);
                            // var id = newPolygon.id;
                            // var p = newPolygon;
                            // var int = parseInt(id) - 1;
                            // alert(int);
                            // console.log(int);
                            // console.log(p);
                            var area = computeArea(polygo.getPath());
                            var info = getInfoWindow(parseInt(id));
                            info.setPosition(polygo.getPath().getArray()[0]);
                            info.setContent("<h3>Polygon Area</h3><b>" + area + "m²<b>");
                            // alert(info.getContent());
                            // alert('set_at');
                            for(var i=0;i<polygon.length;i++){

                              if(polygon[i].id === id){
                                // alert(id);
                                // console.log(polygon[i]);
                                var obj =[];
                                for (var j = 0; j < polygo.getPath().length; j++) {
                                  obj.push(polygo.getPath().getArray()[j].lat());
                                  obj.push(polygo.getPath().getArray()[j].lng());

                              }

                                polygon[i]['latLngs'] = obj;
                                
                              }
                            }

                        });

                        // alert(this.id);
                        });


                    }

                    // load polyline
                    //  Function to fit the bounds of the map 
                    // extends all points from all the shapes drown 

                    // console.log("All Shapes ",allShapes);

                    function updateBounds(shape, type) {

                        if (type === 'circle' || type === 'rectangle') {


                            points = new google.maps.LatLng(shape.getBounds().getNorthEast().lat(), shape.getBounds().getNorthEast().lng());
                            globalBounds.extend(points);

                            points = new google.maps.LatLng(shape.getBounds().getSouthWest().lat(), shape.getBounds().getSouthWest().lng());
                            globalBounds.extend(points);


                        } else if (type === 'polygon') {



                            for (var j = 0; j < shape.length; j++) {

                                points = new google.maps.LatLng(shape[j].lat, shape[j].lng);
                                globalBounds.extend(points);

                            }

                        }else if(type === 'marker' ){
                          globalBounds.extend(shape);
                        }

                    }

                    map.fitBounds(globalBounds);
                }); // $.get



        }); // document ready




    }
}