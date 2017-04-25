<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Map Tools</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat|Roboto+Slab" rel="stylesheet">
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="/css/materialize.min.css">
    <link rel="stylesheet" href="/css/main.css">
    


  </head>
  <body>
    @include('layout.nav')

<!-- Font-family : Montserrat -->
<!-- #5a5a5a -->
<!-- <div class="parallax-container" >
  <div class="parallax">
    <img src="/img/GoogleMap-5.jpg" alt="Google Map">
  </div>
</div> -->




      @yield('content')








         @include('layout.footer')



          <script defer src="/js/materialize.js"></script>
          <script type="text/javascript" src="/js/jquery-2.1.1.min.js"></script>

          <script type="text/javascript">

            $(document).ready(function(){
                $('.parallax').parallax();
              });

          </script>

  </body>
</html>
