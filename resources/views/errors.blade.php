@if(count($errors))
  <div class="form-group alert alert-danger">
  <ul>
    @foreach($errors->all() as $error)
    <li class="red-text darken-2"><b>{{$error}} </b></li>
    @endforeach
    </ul>
  </div>

  @endif