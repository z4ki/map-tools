<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat|Roboto+Slab" rel="stylesheet">
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="/css/materialize.min.css">
    <script type="text/javascript" src="/js/jquery-2.1.1.min.js"></script>
    <script src="/js/materialize.js"></script>
    <style type="text/css">
        #search-box {
            height: 3rem!important;
            margin-left: 5px!important;
            margin-bottom: 1rem!important;
            background-color: #fff!important;
            /*border-radius: 15px;*/
        }
        
        input[type=search] {
            background-color: #fff!important;
            border-bottom: none!important;
            margin: 5px 0!important;
            padding-left: 2.5rem!important;
            height: 2.5rem!important;
        }
        
        input[type=search]:focus,
        input[type=search]:hover {
            background-color: #fff!important;
        }
        
        .list-items > .active {
            border-right: 3px #fbc02d solid;
        }
        
        body {
            background-color: #f8f8f8!important;
        }
        
        #slide-out {
            background-image: linear-gradient(45deg, rgb(53, 61, 71) 0%, rgb(33, 41, 46) 100%);
        }
        
        #slide-out li a,
        #slide-out li a i {
            color: #76838f!important;
        }
        
        #slide-out .list-items li a:hover,
        #slide-out .active a {
            color: #fff!important;
            background: #2A363B!important;
        }
    </style>

</head>

<body>

    <div class="row">

        <ul id="slide-out" class="side-nav fixed">
            <li>
                <div class="userView">
                    <a href="#!user "><img class="circle" src="{{Storage::url('avatars/'. Auth::user()->avatar)}} "></a>
                    <a href="#!name"><span class="white-text name">{{ Auth::user()->first_name}}</span></a>
                    <a href="#!email"><span class="white-text email" >{{ Auth::user()->email}} </span></a>
                </div>
            </li>
            <div class="list-items">
                <li id="home" class=""><a href="/dash"><i class="material-icons" >home</i>Map</a></li>

                <li id="new-agent"><a href="/addAgent"><i class="material-icons">person_add</i>New Agent</a></li>
                <!--  <li><div class="divider"></div></li>
                      <li><a class="subheader">My Account</a></li> -->
                <li id="latest-projects"><a class="waves-effect" href="/projects"><i class="material-icons">gesture</i>Latest Projects</a></li>
                <li id="my-projects">
                    <a href="/pro"><i class="material-icons">work</i><!-- <span class="badge white-text text-darken-4">10</span> -->Departement Projects</a>
                </li>
                <li id="users">
                    <a class="waves-effect" href="/show/users"><i class="material-icons">person</i>Users</a>

                </li>
                <li id="settings">
                    <a class="waves-effect" href="/settings"><i class="material-icons">settings</i>Settings</a>

                </li>
                <li id="logout">
                    <a class="waves-effect" href="/logout"><i class="material-icons">chevron_right</i>Logout</a>

                </li>
               
            </div>
        </ul>
       

        <div class=" " style="margin-left:350px;margin-right:50px;">

            @yield('content')

        </div>
    </div>

    <script>
        $('#slide-out li').mouseover(function() {
            $(this).find('i').attr("style", "color:#fff!important;");

        });
        $('#slide-out li').mouseleave(function() {

            if (!$(this).hasClass('active')) {

                $(this).find('i').attr("style", "color:##76838f!important;");

            }
        });
        $('li.active').find('i').attr("style", "color:#fff!important;");

        /*$('#search-box').mouseover(function(){

           $(this).addClass('z-depth-2');
         });*/

        /*$('#search-box').mouseout(function(){
          $(this).removeClass('z-depth-2');
        });
        $('input[type=search]').focusin(function(){

          $('#search-box').addClass('z-depth-2');
        });*/
    </script>
</body>

</html>