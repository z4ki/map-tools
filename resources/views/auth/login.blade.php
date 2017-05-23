
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat|Roboto+Slab" rel="stylesheet">
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="/css/materialize.min.css">
    <style type="text/css">
      body {
        background-color: #f8f8f8!important;
      }
      .login-form {
        background-color: #f8f8f8!important;
      }
      input,input:focus {
        border-bottom: #fbc02d!important;
        box-shadow: 0 1px 0 0  #fbc02d!important;
      }
      form i {
        font-size: 90px!important;
      }
      .btn-large{
        padding:0 8rem!important;
      }
    </style>
  </head>
  <body>
  
    <main>
   <center>
     
   	<!-- <div class="section"></div>
     <h3 class="pink-text"><b>Sign in to your account</b></h3>-->
     <div class="section"></div> 

     <div class="container ">
       <div class="z-depth-2  lighten-4 row" style="display: inline-block; padding: 32px 48px 0px 48px; border: 1px solid #EEE;">

         <form class="col s12 " method="post" action="/login">
         <i class="material-icons indigo-text  ">lock_outline</i>
         {{csrf_field()}}
           <div class='row'>
             <div class='col s12'>
             </div>
           </div>

           <div class='row'>
             <div class='input-field col s12'>
               <input class='validate' type='email' name='email' id='email' />
               <label for='email'>Enter your email</label>
             </div>
           </div>

           <div class='row'>
             <div class='input-field col s12'>
               <input class='validate' type='password' name='password' id='password' />
               <label for='password'>Enter your password</label>
             </div>
             <label style='float: right;'>
               <a class='pink-text' href='#!'><b>Forgot Password?</b></a>
             </label>
           </div>

           <br />
           <center>
             <div class='row'>
               <button type="submit" class="btn-large waves-effect waves-light yellow darken-2 z-depth-3"><span style="color:#121212;font-weight:bold;">Log In</span></button>
             </div>
           </center>
         </form>
       </div>
     </div>
     <!-- <a href="/#register">Create account</a> -->
     <!-- <br> -->
     <a href="/">Return Home</a>
      @include('errors')
   </center>

   <div class="section"></div>
   <div class="section"></div>

 </main>
 <script defer src="/js/materialize.js"></script>
 <script type="text/javascript" src="/js/jquery-2.1.1.min.js"></script>
  </body>
</html>
