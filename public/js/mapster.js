$.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });



/*** Global Variables to store it in the database via ajax **/


var CIRCLES = [],
POLYGONS = [],
RECTANGLES =[],
POLYLINES = []; 



$(document).ready(function(){
  toggleMenuOff();

  $("#context-menu").hide();
  $("#results").hide();
})
  var menu = document.querySelector("#context-menu");
  var menuState = 0;
  var active = "context-menu--active";
 
  clickListener();
  keyboardListener();
  $("#results").hide();


  
  
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
      /*menu.classList.add(active);*/
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
    console.log("map position",e);
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
      console.log("body");
      xPos += (el.offsetLeft - xScroll + el.clientLeft);
      yPos += (el.offsetTop - yScroll + el.clientTop);
    } else {
      console.log("map");

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
    console.log(menuPosition);
  }











      var map;
      function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: 36.1768545, lng: 6.4502461},
          zoom: 12,
          disableDefaultUI: true,
          fullscreenControl:true
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
                drawingModes:[btnID]
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


        function CenterControl(controlDiv, map) {

        // Set CSS for the control border.
        var controlUI = document.createElement('div');
        var btnUI = document.getElementById('h-bar');
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
        var centerControl = new CenterControl(centerControlDiv, map);

        centerControlDiv.index = 1;
        map.controls[google.maps.ControlPosition.BOTTOM_CENTER].push(centerControlDiv);
      
        
        
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
            fillColor: '#ffff00',
            fillOpacity: 1,
            strokeWeight: 5,
            clickable: false,
            editable: true,
            zIndex: 1
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
            console.log("Area"+ area);
            
            $("#results").prepend("<li class='collection-item'><b>* Area:" + area +" m²</b></li>");
            $("#results").show();
           
          });

          google.maps.event.addListener(drawingManager, 'polylinecomplete', function(polyline) {

            distance = google.maps.geometry.spherical.computeLength(polyline.getPath());
            console.log("distance"+ distance);
            
            $("#results").prepend("<li class='collection-item'><b>* Distance: " + distance +" meters</b></li>");
            $("#results").show();

            });
          
          google.maps.event.addListener(drawingManager,'overlaycomplete', function(event){
            if(event.type==='circle'){
              console.log("Circle:" ,event);
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
              
              console.log("JSON",CIRCLES);
            }else if(event.type==='polygon'){
              console.log("Polygon:" ,event);

                var obj = [];

              for(var i =0;i<event.overlay.getPath().length;i++){
                obj.push( event.overlay.getPath().getArray()[i].lat());
                obj.push( event.overlay.getPath().getArray()[i].lng());
                
              }
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
           $.ajax({
            type:'POST',
            dataType:'json',
            url:'/dash/store',
            data:{
                "circles":CIRCLES,
                "polygons":POLYGONS
            },

            success:function(data){

              console.log(data); 
           /* $("#results").html(data)
            $("#results").show();*/
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