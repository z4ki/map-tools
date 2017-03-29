<nav >
 <div class="nav-wrapper">

   <a href="#" class="brand-logo"><i class="material-icons">polymer</i>Map Tools</a>

   <ul id="nav-mobile" class="right hide-on-med-and-down">

<!--

     <li class="valing">
      <div class="input-field center-aling">
        <input  type="search" required>
        <label class="label-icon" for="search"><i class="material-icons">search</i></label>
        <i class="material-icons">close</i>
      </div>
    </li> -->
    <li>
      <div class="box left-align col m12">
        <div class="container-1">
            <span class="icon"><i class="material-icons">search</i></span>
            <input type="search" id="search" placeholder="Search..." autocomplete="off"/>
        </div>
      </div>
    </li>

     <li><a href="#">Home</a></li>
     <li><a href="#">Services</a></li>
     <li><a href="#">Contact us</a></li>
     @if(Auth::check())
     <li><a href="/dash">{{Auth::user()->first_name}}</a></li>
     <li><a href="/logout">Logout</a></li>
     @else
     <li><a href="#register">Sign up</a></li>
     <li ><a href="/login">Login</a></li>
     @endif
   </ul>
 </div>
</nav>
