$.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });



/*** Global Variables to store it in the database via ajax **/


var CIRCLES = [],
    POLYGONS = [],
    RECTANGLES =[],
    SHAPES = [],
    POLYLINES = []; 


var fillColor;



$(document).ready(function(){
  toggleMenuOff();

  $("#saved-panel").hide();
  $("#context-menu").hide();
  $("#results").hide();



});
  var menu = document.querySelector("#context-menu");
  var menuState = 0;
  var active = "context-menu--active";
 
  clickListener();
  keyboardListener();
/*$('.color').on("click",function(){
                  fillColor = $(this).attr("id");
                   
                  console.log(fillColor);
                  
              });*/

  
  
  function clickListener(){
    document.addEventListener("click", function (e) {
      var button = e.which || e.button;
      if(button ===1){
        /*console.log("click Listener");*/
        toggleMenuOff();
      }
    });
  }

  function keyboardListener(){
    window.onkeyup = function (e){
      if(e.keyCode === 27){
        toggleMenuOff();
      }
    }
  }

function toggleMenuOn(){
    if(menuState !==1) {
      menuState = 1;
      
       $("#context-menu").fadeIn(600);
      
    }
  }

  function toggleMenuOff (){
    if(menuState!==0) {
      menuState = 0;
      
       $("#context-menu").fadeOut(600);
      /*menu.classList.remove(active);*/
    }
  }
  function getPosition(e){
    
    var posx = 0 + e.pixel.x;
    var posy = 0 +e.pixel.y;
    
    if(!e) var e = window.event;
    if(e.pageX || e.pageY){
      posx = e.pageX;
      posy = e.pageY;

    }else if(e.clientX || e.clientY){
      posx = e.clientX + document.body.scrollLeft +
                        document.docuementElement.scrollLeft;
      posy = e.clientY + document.body.scrollLeft +
      document.docuementElement.scrollLeft;
    }

    return { 
              x:posx, 
              y : posy }
  }

  function getOffset(el) {
  var xPos = 0;
  var yPos = 0;
 
  while (el) {
    if (el.tagName == "BODY") {
      // deal with browser quirks with body/window/document and page scroll
      var xScroll = el.scrollLeft || document.documentElement.scrollLeft;
      var yScroll = el.scrollTop || document.documentElement.scrollTop;
      
      xPos += (el.offsetLeft - xScroll + el.clientLeft);
      yPos += (el.offsetTop - yScroll + el.clientTop);
    } else {
      

      // for all other non-BODY elements
      xPos += (el.offsetLeft - el.scrollLeft + el.clientLeft);
      yPos += (el.offsetTop - el.scrollTop + el.clientTop);
    }
 
    el = el.offsetParent;
    
  }
  return {
    x: xPos,
    y: yPos
  };
}

  function positionMenu(e){
    menuPosition = getPosition(e);
   /* var bodyRect = document.body.getClientRects();*/
   var map = document.querySelector("#map"); 
   var pos = getOffset(map);
     /*console.log("Rect ",mapRect);*/
   /* var offsetTop = bodyRect.top - mapRect.top ;
    var offsetLeft = bodyRect.left - mapRect.left;*/
    /*console.log("Rect ",bodyRect,mapRect);*/
    
    menu.style.left = (menuPosition.x + pos.x)+"px";
    menu.style.top = (menuPosition.y + pos.y )+"px";
    
  }











      var map;
      function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: 36.1768545, lng: 6.4502461},
          zoom: 12,
          disableDefaultUI: true,
          fullscreenControl:true
        });

        
        $('#clear').on('click',function(){
          for(var i=0;i<SHAPES.length;i++){

          SHAPES[i].setMap(null);
          }
        });
        
        navigator.geolocation.getCurrentPosition(function(position){
          var latLngs = {
            lat:position.coords.latitude,
            lng:position.coords.longitude
          };
          var infoWindow = new google.maps.InfoWindow({map:map});
          infoWindow.setPosition(latLngs);
            infoWindow.setContent('You current location.');
            map.setCenter(latLngs);
        });
        /**********************************************/
        /**********************************************/
        /**********************************************/
        /*** Event Listeners For h-bar on the map ***/

        function toggleButton(btnID){
          var btn = document.getElementById(btnID);

          btn.addEventListener('click',function(){
            if(btnID ==='polygon'){
              $("#circle").css("font-weight","normal");
              $("#rectangle").css("font-weight","normal");
              $("#polyline").css("font-weight","normal");

            }else if(btnID ==='circle'){
              $("#polygon").css("font-weight","normal");
              $("#rectangle").css("font-weight","normal");
              $("#polyline").css("font-weight","normal");

            }else if(btnID ==='rectangle'){
              $("#polygon").css("font-weight","normal");
              $("#circle").css("font-weight","normal");
              $("#polyline").css("font-weight","normal");

            }else if(btnID ==='polyline'){
              $("#polygon").css("font-weight","normal");
              $("#rectangle").css("font-weight","normal");
              $("#circle").css("font-weight","normal");

            }
            drawingManager.setMap(null);
            $(this).css("font-weight","bold");
            drawingManager.setOptions({
              drawingControlOptions: {
                drawingModes:[btnID],

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


        function CenterControl(controlDiv, map,id) {

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
        var centerControl = new CenterControl(centerControlDiv, map,'h-bar');

        centerControlDiv.index = 1;
        map.controls[google.maps.ControlPosition.BOTTOM_CENTER].push(centerControlDiv);

       /* var rightControlDiv  = document.createElement('div');
        var rightControl = new CenterControl(rightControlDiv,map,'v-bar');
        rightControlDiv.index = 10;
        map.controls[google.maps.ControlPosition.RIGHT].push(rightControlDiv);*/

      
        
        
        map.addListener("rightclick",function(e){
            positionMenu(e);

            /*console.log("Context Menu Prevented");*/
            /*e.preventDefault();*/

            toggleMenuOn();
            /*console.log(e.latLng);*/
          });
        
        


          /****************************************************/
          /****************************************************/
          /****************************************************/
          /****************************************************/

          /* Drawing Polygones */

          var drawingManager = new google.maps.drawing.DrawingManager({
            drawingMode:null, 
            drawingControl:true,
            drawingControlOptions:{
              position:google.maps.ControlPosition.TOP_LEFT,
              drawingModes: ['marker', 'circle', 'polygon', 'polyline', 'rectangle']
            },
            markerOptions: {icon: 'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png'},
          circleOptions: {
            fillOpacity:0.3,
            clickable: false,
            editable: true,
            draggable:true
          },
          polygonOptions:{
            fillOpacity:0.3,
            draggable:true
          },
          rectangleOptions:{
            fillOpacity:0.3,
            strokeWeight:5,
            draggable:true
          },
          polylineOptions:{
            fillOpacity:0.3,
            draggable:true
          }
          });
          
       

          function toggleDrawingManager(drawingManager){
            if(drawingManager.map){
              drawingManager.setMap(null);
            }else{
              drawingManager.setMap(map);
            }
          }


         


          var distance = 0 ,area = 0;
          google.maps.event.addListener(drawingManager, 'polygoncomplete', function(polygon) {
            /*console.log(polygon.getPath());*/
            area = google.maps.geometry.spherical.computeArea(polygon.getPath());
            
            
            $("#results").prepend("<li class='collection-item'><b>* Area:" + area +" m²</b></li>");
            $("#results").show();
           
          });

          google.maps.event.addListener(drawingManager, 'polylinecomplete', function(polyline) {

            distance = google.maps.geometry.spherical.computeLength(polyline.getPath());
            
            
            $("#results").prepend("<li class='collection-item'><b>* Distance: " + distance +" meters</b></li>");
            $("#results").show();

            });
          
          google.maps.event.addListener(drawingManager,'overlaycomplete', function(event){
            if(event.type==='circle'){
              
              SHAPES.push(event.overlay);
              CIRCLES.push(
                          {
                              "type":event.type,
                              "centerLat":event.overlay.center.lat(),
                              "centerLng":event.overlay.center.lng(),
                              "fillColor":event.overlay.fillColor,
                              "fillOpacity":event.overlay.fillOpacity,
                              "strokeWeight":event.overlay.strokeWeight,
                              "radius":event.overlay.radius,
                              "zIndex":event.overlay.zIndex
                            }
                          );
              
              
            }else if(event.type==='rectangle'){
              console.log("strokeWeight",event.overlay.strokeWeight);
              console.log("fillColor",event.overlay.fillColor);
              console.log("fillOpacity",event.overlay.fillOpacity);
              console.log("strokeOpacity",event.overlay.strokeOpacity);
              SHAPES.push(event.overlay);

            }else if(event.type==='polygon'){
              console.log("Polygon:" ,event);

                var obj = [];

              SHAPES.push(event.overlay);


              for(var i =0;i<event.overlay.getPath().length;i++){
                obj.push( event.overlay.getPath().getArray()[i].lat());
                obj.push( event.overlay.getPath().getArray()[i].lng());
                
              }
              console.log(event.overlay.fillColor);
              POLYGONS.push({
                "type":event.type,
                "fillOpacity":event.overlay.fillOpacity,
                "fillColor":event.overlay.fillColor,
                "strokeWeight":event.overlay.strokeWeight,
                "length":event.overlay.getPath().length,
                "latLngs":obj,
                "zIndex":event.overlay.zIndex
              });
             
              
            }
          });
          /*google.maps.event.addListener(drawingManager,'circlecomplete',function(circle){
            console.log(circle.getRadius());
            console.log(circle.getCenter().lat());
            console.log(circle.getCenter().lng());
          });*/
          var token = $(document).find( 'input[name=_token]' ).val();
         
        $("#map-form").on("submit",function(e){


          
          e.preventDefault();
          console.log('retured data from the modal');
          console.log(projectName);
          console.log(description);

           $.ajax({
            type:'POST',
            dataType:'json',
            url:'/dash/store',
            data:{
                "circles":CIRCLES,
                "polygons":POLYGONS
            },

            success:function(data){

             Materialize.toast('Successfully Saved!', 4000)
            

            },
            error:function(){
            $("#results").prepend("<li class='collection-item'><b>There is an error occured try again.</b></li>");
            $("#results").show();
            }
           });

         }); 
         
         /*$("#map-form").on("submit",function(e){
          e.preventDefault();
          console.log(CIRCLES);

          $.post(
            '/dash/store',
            CIRCLES,
            function(response){

              console.log("successfully sended");
            }
            );
         });*/

         /***********************/
         /** Color palette js **/

         (function(){
              $("#btn").on('click',function(){
              $('#v-bar').show();
              console.log("Hi there color palette");
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
                
                
                var i =0;
              var bar = $('.color');
              console.log(bar);
              $(".color").each(function(){
                  
                  $(this).css("background-color", palette[i]);
                  $(this).attr("id",palette[i]);


                  $(this).on("click",function(){
                      fillColor = $(this).attr("id");

                      drawingManager.setOptions({
                        circleOptions:{
                          fillOpacity:1,
                          fillColor:fillColor
                        },
                        polygonOptions:{
                          fillOpacity:1,
                          fillColor:fillColor
                        },
                        polylineOptions:{
                          fillOpacity:1,
                          fillColor:fillColor
                        },
                        rectangleOptions:{
                          fillOpacity:1,
                          fillColor:fillColor
                        }            
                      });
                    

                       
                      
                  });
                  i++;
              });
            }());

         if(window.location.pathname !=='/dash'){
           /*var data  = $("#data").val();
           var json = JSON.parse(data);
           console.log(json[0]);*/

         $(document).ready(function(){
            
          $.get(window.location.pathname,function(data){
            /*$(".active").removeClass('active');
            $("my-projects").addClass('active');*/
            console.log("received data:", data);
            var json = JSON.parse(data[0].plan);
            console.log(json);
            /*var circle  = json.circles["0"];*/

            var arr =[];
            /*$.map(json, function(el,index){
              arr.push(json);
            });*/
            arr = $.makeArray(json.circles);
            console.log(arr);
            

            /* Converting to array*/
            var circle = $.makeArray(json.circles);
            var polygon = $.makeArray(json.polygons);
            console.log(circle);
            console.log(polygon);

              
              var c;

            for(var i=0;i<circle.length;i++){

              
               c = circle[i];
              var newCircle = new google.maps.Circle({
              fillColor:c.fillColor,
              fillOpacity:c.fillOpacity,
              center:{lat:parseFloat(c.centerLat) , lng:parseFloat(c.centerLng)},
              strokeWeight:c.strokeWeight,
              radius:parseFloat(c.radius),
              zIndex:c.zIndex,
              draggable:true,
              map:map

            });


            }

            

            /* path variable for polygon coordinates */
            for(var i=0;i<polygon.length;i++ ){
            var path = [];

              var p = polygon[i];
              console.log(p);
              

            for(var j=0;j<p.length *2;j+=2 ){
               path.push(
              { 
                lat:parseFloat(p.latLngs[j]),
                lng:parseFloat(p.latLngs[j+1])
              }
              );
            }
            console.log(path);

            var newPolygon = new google.maps.Polygon({
              fillColor:p.fillColor,
              fillOpacity:p.fillOpacity,
              strokeWeight:p.strokeWeight,
              map:map,
              draggable:true,
              zIndex:p.zIndex,
              path:path
            });
            }
          }); // $.get

         }); // document ready 



         }
      }

