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
          <tr>
            <td>One</td>
            <td>19-Feb-17</td>
            <td>19-Feb-17</td>
            <td cl>
              <a href="#"><span class="new badge red" data-badge-caption="delete"></span></a>
              <span class="new badge yellow" data-badge-caption="edit"></span>
              <span class="new badge" data-badge-caption="view"></span>
            </td>
          </tr>
          <tr>
            <td>Two</td>
            <td>19-Feb-17</td>
            <td>19-Feb-17</td>
            <td>
              <span class="new badge red" data-badge-caption="delete"></span>
              <span class="new badge yellow" data-badge-caption="edit"></span>
              <span class="new badge" data-badge-caption="view"></span>
            </td>
          </tr>
          <tr>
            <td>Three</td>
            <td>19-Feb-17</td>
            <td>19-Feb-17</td>
            <td>
              <span class="new badge red" data-badge-caption="delete"></span>
              <span class="new badge yellow" data-badge-caption="edit"></span>
              <span class="new badge" data-badge-caption="view"></span>
            </td>
          </tr>
          <tr>
            <td>foor</td>
            <td>19-Feb-17</td>
            <td>19-Feb-17</td>
            <td>
              <span class="new badge red" data-badge-caption="delete"></span>
              <span class="new badge yellow" data-badge-caption="edit"></span>
              <span class="new badge" data-badge-caption="view"></span>
            </td>
          </tr>
          <tr>
            <td>five</td>
            <td>19-Feb-17</td>
            <td>19-Feb-17</td>
            <td>
              <span class="new badge red" data-badge-caption="delete"></span>
              <span class="new badge yellow" data-badge-caption="edit"></span>
              <span class="new badge" data-badge-caption="view"></span>
            </td>
          </tr>

        </tbody>
      </table>
</div>


@endsection
