<!-- Footer Section   -->
<footer id="footer" class="page-footer">
  
    <div class="row">
      <div class="col s6">
        <div id="register">
        @if(!Auth::check())
          <form class="col s12 white-text" method="post" action="/register">
          {{ csrf_field()}}
              <div class="row">
              <h4>Sign up for free</h4>
                <div class="input-field col s6">
                  <input id="name" type="text" class="validate white-text" name="name" required>
                  <label for="name">First Name</label>
                </div>
                <div class="input-field col s6">
                  <input id="last_name" type="text" class="validate">
                  <label for="last_name">Last Name</label>
                </div>
                <div class="input-field col s6">
                  <input id="email" type="email" class="validate"  name="email"required>
                  <label for="email"  name="email">Email</label>
                </div>
                
              </div>
              <div class="row">
                <div class="input-field col s6">
                  <input id="password"  name="password" type="password" class="validate" required>
                  <label for="password" name="password" >Password</label>
                </div>
                <div class="input-field col s6">
                  <input id="password_confirmation"  name="password_confirmation" type="password" class="validate" required>
                  <label for="password_confirmation" name="password_confirmation">Password Confirmation</label>
                </div>
                <button class="btn right" type="submit">Sign up</button>
              </div>
              @include('errors')
            </form>
            @endif
      </div>
      </div>
      <div class="col s6">
        <h5 class="white-text">Where you can find us here</h5>
        <img src="/img/550x350.png">
      </div>
    
  </div>
  <div class="footer-copyright">
    <div class="container ">
    <a href="#!" class="right">© 2017 Copyright Text</a>
    <a class="grey-text text-lighten-4 right" href="#!">More Links</a>
    </div>
    <br>
    <br>
    <br>
    <br>
  </div>

</footer>
