$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});


/*** Global Variables to store it in the database via ajax **/


var CIRCLES = [],
  POLYGONS = [],
  RECTANGLES = [],
  SHAPES = [],
  infoWindowArr = [],
  POLYLINES = [];
  /*
  infowindow.push({
    "title":Google,
    "description": my infowindow,
    "latLngs":coords
  })
  */


var fillColor;

function computeArea(path){
  var area = google.maps.geometry.spherical.computeArea(path);
  return area;
}

$(document).ready(function () {
  /*toggleMenuOff();*/

  $("#saved-panel").hide();
  $("#context-menu").hide();
  $("#results").hide();
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
    disableDefaultUI: true,
    fullscreenControl: true
  });

  var input = document.getElementById('searchbar');

  var searchBox = new google.maps.places.SearchBox(input);
  /*map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);*/
  map.addListener('bound_changed', function () {
    searchBox.setBounds(map.getBounds());
  });

  var markers = [];
  searchBox.addListener('places_changed', function () {
    var places = searchBox.getPlaces();
    if (places.length == 0) {
      return;
    }
    // Clear out the old markers 
    markers.forEach(function (marker) {
      marker.setMap(null);
    });
    markers = [];

    // For each place ,get the icon, name and location

    var bounds = new google.maps.LatLngBounds();
    places.forEach(function (place) {
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

    var latLng = {
      lat: event.latLng.lat(),
      lng: event.latLng.lng()
    };
    /*infowindow.setContent('<h5>Google</h5><p>Hello from Google s HQ</p>');*/

    inputwindow.setContent(inputContent);
    inputwindow.setPosition(latLng);
    inputwindow.open(map);
    $('#infowindow-btn').on('click', function () {
     
      var title = $('#title-iw').val();
      var description = $('#textarea-iw').val();
      var content = '<h5>' + title + '</h5><p>' + description + '</p>';

      if (inputwindow !== null) {
        google.maps.event.clearInstanceListeners(inputwindow); // just in case handlers continue to stick around
        inputwindow.close();
        inputwindow = null;

      }
      infoWindowArr.push({
        'title':title,
        'description':description,
        'latLng':latLng
      });
      console.log("InfoWindow Array : ",infoWindowArr);
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
        console.log("rightclick");
        infoWindowListener = new google.maps.Marker({
          position: latLng,
          map: map
        });
        console.log('marker');
      }

      infoWindowListener.addListener('click', function () {
        infowindow.open(map);
      });
      map.addListener('click', function () {
        infowindow.close();
      });
    });


  }


  map.addListener('rightclick', function (event) {
    
    showInfoWindow('rightclick', event);
  });


  $('#clear').on('click', function () {
    for (var i = 0; i < SHAPES.length; i++) {

      SHAPES[i].setMap(null);
    }
  });

  navigator.geolocation.getCurrentPosition(function (position) {
    var latLngs = {
      lat: position.coords.latitude,
      lng: position.coords.longitude
    };
    var infoWindow = new google.maps.InfoWindow({
      map: map
    });
    infoWindow.setPosition(latLngs);
    infoWindow.setContent('You current location.');
    map.setCenter(latLngs);
  });
  /**********************************************/
  /**********************************************/
  /**********************************************/
  /*** Event Listeners For h-bar on the map ***/

  function toggleButton(btnID) {
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


  toggleButton('polygon');
  toggleButton('circle');
  toggleButton('rectangle');
  toggleButton('polyline');


  /* Circle button */

  /*var circleBtn = document.getElementById('circle');
  circleBtn.addEventListener('click',function(){
    drawingManager.setOptions({
      drawingControlOptions: {
        drawingModes:['circle']
      }
    });
    toggleDrawingPolygon(drawingManager);
  });

   Rectangle Button
  var circleBtn = document.getElementById('rectangle');
  circleBtn.addEventListener('click',function(){
    drawingManager.setOptions({
      drawingControlOptions: {
        drawingModes:['rectangle']
      }
    });
    toggleDrawingPolygon(drawingManager);
  });*/


  /*************************************************/
  /*************************************************/
  /*************************************************/
  /*************************************************/
  /* Custom Controls To Add Buttons the map*/
  /* Polygon ,Circle ,Rectangle Buttons  */


  function CenterControl(controlDiv, map, id) {

    // Set CSS for the control border.
    var controlUI = document.createElement('div');
    var btnUI = document.getElementById(id);
    btnUI.style.marginBottom = '10px';

    controlDiv.appendChild(btnUI);

    // Set CSS for the control interior.
    var controlText = document.createElement('div');


    controlUI.appendChild(controlText);

    // Setup the click event listeners: simply set the map to Chicago.

  }


  // Create the DIV to hold the control and call the CenterControl()
  // constructor passing in this DIV.
  var centerControlDiv = document.createElement('div');
  var centerControl = new CenterControl(centerControlDiv, map, 'h-bar');

  centerControlDiv.index = 1;
  map.controls[google.maps.ControlPosition.BOTTOM_CENTER].push(centerControlDiv);

  /* var rightControlDiv  = document.createElement('div');
   var rightControl = new CenterControl(rightControlDiv,map,'v-bar');
   rightControlDiv.index = 10;
   map.controls[google.maps.ControlPosition.RIGHT].push(rightControlDiv);*/


  /* map.addListener("rightclick",function(e){
            positionMenu(e);
*/
  /*console.log("Context Menu Prevented");*/
  /*e.preventDefault();*/

  /*toggleMenuOn();*/
  /*console.log(e.latLng);*/
  /* });*/


  /****************************************************/
  /****************************************************/
  /****************************************************/
  /****************************************************/

  /* Drawing Polygones */

  var drawingManager = new google.maps.drawing.DrawingManager({
    drawingMode: null,
    drawingControl: true,
    drawingControlOptions: {
      position: google.maps.ControlPosition.TOP_LEFT,
      drawingModes: ['marker', 'circle', 'polygon', 'polyline', 'rectangle']
    },
    markerOptions: {
      icon: 'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png'
    },
    circleOptions: {
      fillOpacity: 0.3,
      clickable: false,
      editable: true,
      draggable: true
    },
    polygonOptions: {
      fillOpacity: 0.3,
      draggable: true
    },
    rectangleOptions: {
      fillOpacity: 0.3,
      strokeWeight: 5,
      draggable: true
    },
    polylineOptions: {
      fillOpacity: 0.3,
      draggable: true
    }
  });


  function toggleDrawingManager(drawingManager) {
    if (drawingManager.map) {
      drawingManager.setMap(null);
    } else {
      drawingManager.setMap(map);
    }
  }


  var distance,area;
  /*google.maps.event.addListener(drawingManager, 'polygoncomplete', function (polygon) {
    console.log(polygon.getPath());
    area = google.maps.geometry.spherical.computeArea(polygon.getPath());
    
    var infowindow = new google.maps.InfoWindow();
        infowindow.setContent('<h5>Area</h5>'+ area +'m²');
        infowindow.setMap(map);
        var pos = event.overlay.getPath().getArray().pop();
        console.log(pos);
        infowindow.setPosition(pos);
        infowindow.open(map);
    $("#results").prepend("<li class='collection-item'><b>* Area:" + area + " m²</b></li>");
    $("#results").show();

  });
*/
  /*google.maps.event.addListener(drawingManager, 'polylinecomplete', function (polyline) {

    


    $("#results").prepend("<li class='collection-item'><b>* Distance: " + distance + " meters</b></li>");
    $("#results").show();

  });*/

  google.maps.event.addListener(drawingManager, 'overlaycomplete', function (event) {
    SHAPES.push(event.overlay);
    /* Adding a RightClick  Listener to every shape completed for showing the infoWindow */
    event.overlay.addListener('rightclick', function (e) {
      /*e.preventDefault();*/
      showInfoWindow(event, e);
    });

    /* Storing Circle params */

    if (event.type === 'circle') {
      
      CIRCLES.push({
        "centerLat": event.overlay.center.lat(),
        "centerLng": event.overlay.center.lng(),
        "radius": event.overlay.radius,
        "fillColor": event.overlay.fillColor,
        "fillOpacity": event.overlay.fillOpacity,
        "strokeWeight": event.overlay.strokeWeight,
        "zIndex": event.overlay.zIndex
      });

      var cirlceArea = Math.PI * Math.pow(event.overlay.radius, 2);
      var circleInfoWindow = new google.maps.InfoWindow({
        content:'<h5>Circle Area</h5><b>'+cirlceArea +'</b>',
        map:map,
        position:event.overlay.center
      }).open(map);


    } else if (event.type === 'rectangle') {
      /*event.overlay.addListener('rightclick',addInfoWindow);*/
      console.log("Rectangle path:",event.overlay);
      var bounds = event.overlay.getBounds();
      var northEast = new google.maps.LatLng(bounds.getNorthEast().lat(),bounds.getNorthEast().lng());
      var southWest  = new google.maps.LatLng(bounds.getSouthWest().lat(),bounds.getSouthWest().lng());
      var southEast  = new google.maps.LatLng(bounds.getSouthWest().lat(),bounds.getNorthEast().lng());
      var northWest  = new google.maps.LatLng(bounds.getNorthEast().lat(),bounds.getSouthWest().lng());

      var center = {lat:bounds.getCenter().lat(),lng:bounds.getCenter().lng()};
      /*console.log(northEast);
      console.log(center);*/

      RECTANGLES.push({
        "northEast":northEast,
        "southWest":southWest,
        "southEast":southEast,
        "northWest":northWest,
        "center":center,
        "zIndex":event.overlay.zIndex,
        "strokeWeight": event.overlay.strokeWeight,
        "fillColor": event.overlay.fillColor,
        "fillOpacity": event.overlay.fillOpacity,
        "strokeOpacity": event.overlay.strokeOpacity
      });
    
      var rectArea =  google.maps.geometry.spherical.computeArea([northEast,northWest,southWest,southEast]) /  (1000000) ;
 /*     console.log(rectArea);*/
      
      var rectangleInfoWindow = new google.maps.InfoWindow({
        content:'<h5>Rectangle Area</h5><b>'+ rectArea+ ' Km²</b>',
        map:map,
        position:center
      }).open(map);




    }else if (event.type=== 'polyline'){
      var coords = event.overlay.getPath().getArray();
      var latLngs = [];
      for (var i =0;i<coords.length;i++){
        latLngs.push(coords[i].lat());
        latLngs.push(coords[i].lng());
      }
      POLYLINES.push({
        "latLngs":latLngs,
        "zIndex":event.overlay.zIndex
      });
      distance = google.maps.geometry.spherical.computeLength(event.overlay.getPath());

      var polylineInfoWindow = new google.maps.InfoWindow({
        content:'<h5>Distance</h5><b>'+ distance +'m²</b>', 
        map:map,
        position:event.overlay.getPath().getArray().pop()
      }).open(map);



    } else if (event.type === 'polygon') {

      /*console.log(event.overlay.getPath());
      console.log("Polygon",event.overlay);*/
      /*console.log("Polygon:" ,event);*/

      var obj = [];

      /*SHAPES.push(event.overlay);*/


      for (var i = 0; i < event.overlay.getPath().length; i++) {
        obj.push(event.overlay.getPath().getArray()[i].lat());
        obj.push(event.overlay.getPath().getArray()[i].lng());

      }

    area = computeArea(event.overlay.getPath());
        var infowindow = new google.maps.InfoWindow();
            infowindow.setContent('<h5>Area</h5><b>'+ area +'m²</b>');
            infowindow.setMap(map);
            var pos = event.overlay.getPath().getArray().pop();
            infowindow.setPosition(pos);
            infowindow.open(map);
            event.overlay.addListener('mouseover', function(){
              infowindow.open(map);
            });
             event.overlay.addListener('mouseout', function(){
              infowindow.close();
            });
    
      POLYGONS.push({
        "type": event.type,
        "fillOpacity": event.overlay.fillOpacity,
        "fillColor": event.overlay.fillColor,
        "strokeWeight": event.overlay.strokeWeight,
        "length": event.overlay.getPath().length,
        "latLngs": obj,
        "area": area,
        "zIndex": event.overlay.zIndex
      });


        
    }
  });




  $("#map-form").on("submit", function (e) {
    
    e.preventDefault();
    
    $.ajax({
      type: 'POST',
      dataType: 'json',
      url: '/dash/store',
      data: {
        "circles": CIRCLES,
        "polygons": POLYGONS,
        "rectangles":RECTANGLES,
        "polylines":POLYLINES,
        "projectName":projectName,
        "description":description,
        "infoWindow":infoWindowArr, 
        'captcha':grecaptcha.getResponse()
      },

      success: function (data) {
        if(data === 'reCaptcha wrong'){
          Materialize.toast('Please retry again !', 4000);
          grecaptcha.reset();
          $('#wrong-captcha').html('Try to solve the reCaptcha again!')
          $('.modal').modal('open');
        }else{

        Materialize.toast('Successfully Saved!', 4000);
        $(".loader").fadeOut(400);
        $("#save-modal").html('Saved!');
        }


      },
      error: function (data) {
        $(".loader").fadeOut(400);
        if(data === 'reCaptcha wrong'){
          $('#wrong-captcha').html('Try to solve the reCaptcha again!')
          $('.modal').modal();
        }
        
      }
    });

  });

  /***********************/
  /** Color palette js **/

  (function () {
    $("#btn").on('click', function () {
      $('#v-bar').show();
    });
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
    $(".color").each(function () {

      $(this).css("background-color", palette[i]);
      $(this).attr("id", palette[i]);


      $(this).on("click", function () {
        fillColor = $(this).attr("id");

        drawingManager.setOptions({
          circleOptions: {
            fillOpacity: 1,
            fillColor: fillColor
          },
          polygonOptions: {
            fillOpacity: 1,
            fillColor: fillColor
          },
          polylineOptions: {
            fillOpacity: 1,
            fillColor: fillColor
          },
          rectangleOptions: {
            fillOpacity: 1,
            fillColor: fillColor
          }
        });


      });
      i++;
    });
  }());

  if (window.location.pathname !== '/dash') {
    

    $(document).ready(function () {
      var globalBounds = new google.maps.LatLngBounds();
      var allShapes = new Array();
      var points = new Array();

      $.get(
        window.location.pathname, 
        function (data) {
        
        console.log("received data:", data);
        var json = JSON.parse(data[0].map);
        console.log(json);
        /*var circle  = json.circles["0"];*/

        var arr = [];
        /*$.map(json, function(el,index){
          arr.push(json);
        });*/
        arr = $.makeArray(json.circles);
        console.log(arr);


        /* Converting to array*/
        var circle = $.makeArray(json.circles);
        var polygon = $.makeArray(json.polygons);
        var polyline = $.makeArray(json.polylines);
        var rectangle = $.makeArray(json.rectangles);
        var infoWindows = $.makeArray(json.infoWindow);

        console.log("circle",circle);
        console.log("polygon",polygon);
        console.log("polyline",polyline);
        console.log("rectangle",rectangle);
        console.log("infoWindows",infoWindows);


        /* reload Polylines*/


        /* reload InfoWindows */

        for(var i =0;i<infoWindows.length;i++){

          var newInfoWindow = [], marker = [];
          var content = '<h5>' + infoWindows[i].title + '</h5><p>' + infoWindows[i].description + '</p>';

          var pos = new google.maps.LatLng(infoWindows[i].latLng.lat,infoWindows[i].latLng.lng);
          newInfoWindow[i] = new google.maps.InfoWindow({
            content:content,
            position:pos
          });
          console.log(i);
          /*newInfoWindow[i].open(map);*/
          
          marker[i] = new google.maps.Marker({
            position:pos,
            map:map
          });
          
          marker[i].addListener('click',function(){
            
            newInfoWindow[i].open(map);
          });
          allShapes.push(marker[i]);
          /*if(!globalBounds){
            globalBounds = marker[i].getBounds();
          }else{
            globalBounds.union(marker[i].getBounds());
          }*/

        }
        /* Draw a Rectangle */
        
        for(var i =0;i<rectangle.length;i++){

        var rectangleShape = new google.maps.Rectangle({
          editable:true,
          fillColor:rectangle.fillColor,
          map:map,
          bounds: new google.maps.LatLngBounds(
            new google.maps.LatLng(rectangle[i].southWest.lat,rectangle[i].southWest.lng),
            new google.maps.LatLng(rectangle[i].northEast.lat,rectangle[i].northEast.lng)
          )
        });
        var rectBounds = [
            [rectangle[i].southWest.lat,rectangle[i].southWest.lng],
            [rectangle[i].northEast.lat,rectangle[i].northEast.lng]
        ];
        updateBounds(rectBounds,'rectangle')
        allShapes.push(rectangleShape);

        /*map.fitBounds(new google.maps.LatLngBounds(
            new google.maps.LatLng(rectangle[i].southWest.lat,rectangle[i].southWest.lng),
            new google.maps.LatLng(rectangle[i].northEast.lat,rectangle[i].northEast.lng)));*/

        }
        /* Draw the Circles */
        var c;

        for (var i = 0; i < circle.length; i++) {

          c = circle[i];
          var newCircle = new google.maps.Circle({
            editable:true,
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

          allShapes.push(newCircle);
          updateBounds(newCircle,'circle');
          newCircle.addListener("radius_changed", function(){
            alert('need to Calculate the Area of me Circle')
          });

          

          

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
            editable:true,
            fillColor: p.fillColor,
            fillOpacity: p.fillOpacity,
            strokeWeight: p.strokeWeight,
            map: map,
            /*draggable: true,*/
            zIndex: p.zIndex,
            path: path
          });
          updateBounds(path,'polygon');
          allShapes.push(newPolygon);


          (function(){

          
            var infoWindow;
            google.maps.event.addListener(newPolygon.getPath(),'insert_at',function(){
              if(infoWindow){
                infoWindow.close();
              }
              var area = computeArea(newPolygon.getPath());
              infoWindow = new google.maps.InfoWindow({
                content:'<h5>Area</h5><b>' + area +'m²</b>',
                position:newPolygon.getPath().getArray()[0],
               map:map
              });
            });
            google.maps.event.addListener(newPolygon.getPath(),'set_at',function(){
              if(infoWindow){
                infoWindow.close();
              }
              var area = computeArea(newPolygon.getPath());
              infoWindow = new google.maps.InfoWindow({
                content:'<h5>Area</h5><b>' + area +'m²</b>',
                position:newPolygon.getPath().getArray()[0],
                map:map
                
              });
            });
          }());

        }
        /* Draw the Rectangles*/
        
        console.log("All Shapes ",allShapes);
        
        function updateBounds(shape, type){

          if(type === 'circle'){

            console.log(shape);
            points = new google.maps.LatLng(shape.getBounds().getNorthEast().lat(),shape.getBounds().getNorthEast().lng());
            globalBounds.extend(points);

            points = new google.maps.LatLng(shape.getBounds().getSouthWest().lat(),shape.getBounds().getSouthWest().lng());
            globalBounds.extend(points);
            

          }else if(type === 'polygon'){
            /*console.log(shape);
            var paths;
            paths = shape.getPath();*/
            console.log(shape);

            for(var j=0;j<shape.length;j++){
              
              points = new google.maps.LatLng(shape[j].lat,shape[j].lng);
              globalBounds.extend(points);

          }

        }else if (type === 'rectangle'){
            var j=0;
            while(j < 2){
              points = new google.maps.LatLng(shape[j][0],shape[j][1]);
              globalBounds.extend(points);
            }
          }
      }

        /*for(var i = 0; i < allShapes.length  ;i++){
        
          
          if(allShapes[i].getCenter()){
            points = new google.maps.LatLng(allShapes[i].getBounds().getNorthEast().lat(),allShapes[i].getBounds().getNorthEast().lng());
            globalBounds.extend(points);

            points = new google.maps.LatLng(allShapes[i].getBounds().getSouthWest().lat(),allShapes[i].getBounds().getSouthWest().lng());
            globalBounds.extend(points);
            console.log(globalBounds);

          }else if(allShapes[i].getPath()){
            var paths;
            paths = allShapes[i].getPath();

            for(var j=0;j<paths.length;j++){
              points = new google.maps.LatLng(allShapes[i].getAt[j].lat(),allShapes[i].getAt[j].lng());
              globalBounds.extend(points);
            }
          }
        
        }*/
        map.fitBounds(globalBounds);
      }); // $.get

    }); // document ready 


  }
}