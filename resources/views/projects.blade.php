@extends('layout/dashboard_layout')

@section('content')

<div id="MyProjects" style="margin-top:200px;" >
  

    <table class="highlight">
        <thead>
          <tr>
              <th data-field="id">Project Name</th>
              <th data-field="created">Created at</th>
              <th data-field="updated">Updated at</th>
              <th class="center-align " data-field="actions">Actions</th>


          </tr>
        </thead>

        <tbody>
         
          <!--<tr>

             <td id="name"></td>
            <td id="created_at"></td>
            <td id="updated_at"></td>
            <td>
              <a href="#" id="delete"><span class="new badge red" data-badge-caption="delete"></span></a>
              <a href="" id="edit"><span class="new badge yellow" data-badge-caption="edit"></span></a>
              <a href="" id="view"><span  class="new badge" data-badge-caption="view"></span></a>
            </td> 
          </tr>-->
          
                  </tbody>
      </table>
</div>

<script type="text/javascript">
  $(document).ready(function(){
    console.log("Ready!!");
    

    $.get("/projects/show",function(data){
      console.log(data);
      for(var i=0;i<data.length;i++){

      var table =  '<tr>'+
                  '<td id="name">'+ data[i].id + '</td>'+
                  '<td id="created_at">'+data[i].created_at+'</td>'+
                  '<td id="updated_at">'+data[i].updated_at+'</td>'+
                  '<td>'+
                  '<a href="#" id="delete"><span class="new badge red" data-badge-caption="delete"></span></a>'+
                  '<a href="" id="edit"><span class="new badge yellow" data-badge-caption="edit"></span></a>'+
                  '<a href="projects/show/'+ data[i].id+  '"id="view"><span  class="new badge" data-badge-caption="view"></span></a>'+
                  '</td></tr>';


                  $("tbody").prepend(table);
        /*$('#name').html(data[i].id);
        $('#created_at').html(data[i].created_at);
        $('#updated_at').html(data[i].updated_at);
        $("td #view").attr("href","projects/show/"+ data[i].id);*/
      }
      

    });
  });
  
</script>

@endsection
