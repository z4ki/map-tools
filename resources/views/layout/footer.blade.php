<!-- Footer Section   -->
<footer id="footer" class="page-footer">
  
    <div  class="row">
      <div class=" col s6">
        <form  id="register" class="col s12 white-text" method="post" action="/register">
          {{ csrf_field()}}
                <h5 class="yellow-text  darken-2">Contact Us!</h5>
                <div class="input-field col s6">
                  <input id="name" type="text" class="validate" name="name" required>
                  <label for="name"> Name</label>
                </div>

                <div class="input-field col s6">
                  <input id="email" type="email" class="validate"  name="email" required>
                  <label for="email"  name="email">Email</label>
                </div>
                
                
                <div class="input-field col s12">
                  <textarea id="description" class="materialize-textarea"></textarea>
                  <label for="description">Message</label>
                  <a href="#!"  class=" waves-effect waves-white btn  right  yellow darken-2 black-text">Done!</a>
                
                </div>

                <div class="input-field col s6">
                  <span class=" white-text">© 2017 Copyright</span>
                  <p class=" white-text">Centre Universitaire Mila </p>
                </div>

                </form>

              
        
      </div>
        
        <div class="col s6">
          <h5 class="white-text">Where you can find us here</h5>
          <img src="/img/550x350.png">
        </div>
        
      </div>
    <br>
        
          

</footer>
