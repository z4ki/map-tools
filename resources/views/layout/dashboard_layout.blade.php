<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat|Roboto+Slab" rel="stylesheet">
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="/css/materialize.min.css">
    <style type="text/css">
      body{
        background-color: #f8f8f8!important;
      }
      #slide-out {
        background-image: linear-gradient(45deg, rgb(53, 61, 71) 0%, rgb(33, 41, 46) 100%);
       
      }
      #slide-out li a,#slide-out li a i  {
        color: #76838f!important;
      }
      #slide-out  li a:hover,#slide-out .active  a  {
        color: #fff!important;
        background: #2A363B!important;
        
      }
      
      
    </style>

    
  </head>
  <body>

<div class="row">


<ul id="slide-out" class="side-nav  fixed">
    <li>
      <div class="userView">
        <div class="background">
          
        </div>
        <a href="#!user"><img class="circle" src="/img/google-map.jpg"></a>
        <a href="#!name"><span class="white-text name">{{ Auth::user()->name}}</span></a>
        <a href="#!email"><span class="white-text email">{{ Auth::user()->email}} </span></a>
      </div>
    </li>
    
    <li class="active"><a href="/"  ><i class="material-icons">home</i>Home</a></li>

    <li><a href="#!"><i class="material-icons">add</i>New Project</a></li>
   <!--  <li><div class="divider"></div></li>
    <li><a class="subheader">My Account</a></li> -->
    <li><a class="waves-effect" href="/projects"><i class="material-icons">room</i>Latest Projects</a></li>
    <li>
          <a href="/pro" ><span class="badge teal-text text-darken-2">10</span>My Projects</a>
    </li>
    <li>
        <a class="waves-effect" href="#!"><i class="material-icons">settings</i>Profile Settings</a>

    </li>
    <!-- <li class="no-padding">
      
    <li>
          <a href="/pro" ><span class="badge teal-text text-darken-2">10</span>My Projects</a>
    </li>

    <li>
        <a class="waves-effect" href="#!"><i class="material-icons">settings</i>Profile Settings</a>

    </li>
      
    </li> -->
    
  </ul>
  <!-- <a href="#" data-activates="slide-out" class="btn button-collapse"><i class="material-icons">menu</i></a> -->



<div class=" " style="margin-left:350px;margin-right:50px;">


  @yield('content')


</div>
</div>
    <script type="text/javascript" src="/js/jquery-2.1.1.min.js"></script>
    <script  src="/js/materialize.js"></script>
    <script>
    $('.button-collapse').sideNav();
     /*$('#slide-out li').hover(function(){

      $(this).find('i').css('color','red');
      console.log($(this).find('i'));
      
    });*/
    
    </script>
  </body>
</html>
