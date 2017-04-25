@extends('layout/dashboard_layout')

@section('content')
<style type="text/css">
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
        <div class="col s3  chip">
          <a href="/dash" class=" white-text  darken-3 breadcrumb ">Dashboard</a>
          <a href="/projects" class="breadcrumb">All projects</a>

        </div>
      </div>
      
    
    
<div id="MyProjects" style="margin-top:50px;" >
  <div id="search-box" class="input-field  white col s6 ">
          <input id="searchbar" type="search" placeholder="Search by project name" class="white">
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
         
         
          
                  </tbody>
      </table>
</div>

<script type="text/javascript">


$('title').html('All Projects');
  $(document).ready(function(){
    function populateTable(data){
         for(var i=0;i<data.length;i++){

      var table =  '<tr>'+
                  '<td id="name">'+ data[i].project_name + '</td>'+
                  '<td id="created_at">'+data[i].description+'</td>'+
                  '<td id="created_at">'+data[i].created_at+'</td>'+
                  '<td id="updated_at">'+data[i].updated_at+'</td>'+
                  '<td>'+
                  '<a href="#" id="delete"><span class="new badge red" data-badge-caption="delete"></span></a>'+
                  '<a href="" id="edit"><span class="new badge yellow" data-badge-caption="edit"></span></a>'+
                  '<a href="projects/show/'+ data[i].id+  '"id="view"><span  class="new badge" data-badge-caption="view"></span></a>'+
                  '</td></tr>';


                  $("tbody").prepend(table);
       
      }     
              

    }
    $('.active').removeClass();
    $('#latest-projects').addClass('active');
    

    $.get("/projects/show",function(data){
      
      populateTable(data);
      

    });

    $('#searchbar').focusin(function(){
  
        window.onkeyup = function(e){
          $.get(
            window.location.origin +'/search/' + $('#searchbar').val() ,
            function(data){
              $("tbody").html('');
              populateTable(data);
              
            }
            );
        }
      });
  });
  
</script>

@endsection
