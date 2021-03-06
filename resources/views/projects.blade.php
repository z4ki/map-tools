@extends('layout/dashboard_layout')

@section('content')
<style type="text/css">
/*.pagination li.active a {
    color: #fff;
    background-color: #ee6e73!important;
}
*/
  .breadcrumb:before {
    content: '\E5CC';
    color:#7696f3!important;
    margin: 0 0 8px 0!important;
  }
  .breadcrumb:last-child {
    color: #7696f3!important;
  }
  .chip {
    height: 40px!important;
    font-size: 18px!important;
    line-height: 40px!important;
  }
</style>
<!-- <h2 class="pink-text darken-3 " >All Projects !! </h2> -->
 
      <div class="col s12">
        <div class="col s4  chip">
        <div class="breadcrumb"></div>
          <a href="/dash" class=" white-text  darken-3 breadcrumb ">Dashboard</a>
          <a id="breadcrumb" href="/projects" class="breadcrumb">All projects</a>

        </div>
      </div>
      
    
    
<div id="MyProjects" style="margin-top:50px;" >
  <div id="search-box" class="input-field  white col s6 ">
          <input id="searchbar" type="search" placeholder="Search by project name or description" class="white">
          <label class="label-icon white" for="search"><i class="material-icons ">search</i></label>
        </div>
  

    <table class="highlight">
        <thead>
          <tr>
              <th data-field="id">Project Name</th>
              <th data-field="created">Description</th>
              <th data-field="created">Created at</th>
              <th data-field="updated">Updated at</th>
              <th class="center-align " data-field="actions">Actions</th>
          </tr>
        </thead>

        <tbody>
            @foreach($maps as $map)

            <tr id="">
                  <td id="name">{{ $map->project_name}}</td>
                  <td id="description">{{ $map->description}} </td>
                  <td id="created_at">{{ $map->created_at}} </td>
                  <td id="updated_at">{{ $map->updated_at}} </td>
                  <td>
                  <a href="#modal1">
                  <span class="new badge red" data-badge-caption="delete" id="delete" data-id= "{{$map->id}} "></span>
                  </a>
                  <a href="#"><span id="edit" data-screenshot="{{$map->screenshot}}" class="new badge yellow" data-badge-caption="edit"></span></a>
                  <a href="projects/show/{{$map->id}}" id="view"><span  class="new badge" data-badge-caption="view"></span></a>
                 </td>
             </tr>
            @endforeach
        </tbody>
      </table>
      <div class="row">
      <div class="center-align">
      {{ $maps->links()}}
        
      </div>
     </div>
<!-- Modal Trigger -->
  <!-- <a class="waves-effect waves-light btn" href="#modal1">Modal</a> -->

  <!-- Modal Structure -->
  <div id="modal1" class="modal col s4">
    <div class="modal-content">
      <h4>Confirmation</h4>
      <p>Do you really want to delete this map.</p>
    </div>
    <div class="modal-footer">
      <a href="#!" id="no" class="modal-action modal-close waves-effect waves-green btn-flat">No</a>
      <a href="#!" id="yes" class="modal-action modal-close waves-effect waves-green btn-flat">Yes</a>
    </div>
  </div>
</div>

<script type="text/javascript">


$('title').html('All Projects');
$(document).ready(function(){
  $('.modal').modal();
$(document).on('click',function(e){
    console.log(e);
  if(e.target.id === 'delete'){
    
    var id = e.target.dataset.id;

    $("#yes").on('click',function(){

    $.ajax({
    type: 'POST',
    url: '/map/delete/' + id,
    data:1,
    success: function(data){
      if(data === 'deleted'){
        Materialize.toast('Deleted Successfully !', 4000);
        $('tr#'+id).fadeOut(400);
        $('tr#'+id).remove();
      }
    },
    error:function(data){
        console.log(data);
        Materialize.toast('There is an error !', 4000);

    }
    });
    });

    $("#no").on('click',function(){

      $('#modal1').modal('close');
    });

  }else if(e.target.id  ==='edit'){

    var screenshot = e.target.dataset.screenshot;
    var src = "/storage/mapScreenshot/"+ screenshot;
   
    // $('#MyProjects').append("<img class='materialboxed' width='650' src='" + src + "'>");



  }
});

  

    var pathname = window.location.pathname;
    $('#slide-out .active').removeClass();

    if(pathname === '/Departement'){
    $('title').html('Departement Projects');
    $('#departement-projects').addClass('active');
    $('#breadcrumb').html("Departement");
    $('#breadcrumb').attr("href","/Departement"); 

    }else if(pathname === '/projects'){

    $('#latest-projects').addClass('active');
    }
    
    function populateTable(data){
         for(var i=0;i<data.length;i++){

      var table =  '<tr id="'+  data[i].id+  '">'+
                  '<td id="name">'+ data[i].project_name + '</td>'+
                  '<td id="description">'+data[i].description+'</td>'+
                  '<td id="created_at">'+data[i].created_at+'</td>'+
                  '<td id="updated_at">'+data[i].updated_at+'</td>'+
                  '<td>'+
                  '<a href="#modal1"><span class="new badge red" data-badge-caption="delete" id="delete" data-id="'+  data[i].id+  '"></span></a>'+
                  '<a href="#"><span id="edit" data-screenshot="'+  data[i].screenshot+  '" class="new badge yellow" data-badge-caption="edit"></span></a>'+
                  '<a href="projects/show/'+ data[i].id+  '"id="view"><span  class="new badge" data-badge-caption="view"></span></a>'+
                  '</td></tr>';


                  $("tbody").prepend(table);
       
      }     
              

    }


    // $.get(pathname + "/show",function(data){
      
    //   populateTable(data);
      

    // });

    $('#searchbar').focusin(function(){
  
        window.onkeyup = function(e){
          if($('#searchbar').val() != ''){

          $.get(
            window.location.origin +'/search/' + $('#searchbar').val() ,
            function(data){
              $("tbody").html('');
              $('.pagination').html('');
              populateTable(data);
              
            }
            );
          }

        }
      });
  });


$(document).ready(function(){
    $('.materialboxed').materialbox();
  });
       

  
</script>

@endsection
