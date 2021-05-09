@extends('Admin::layouts.admin')
@section('content')

<div class="panel">
          <header class="panel-heading">
            <h3 class="panel-title">Pages</h3>
          </header>
          <div class="panel-body">
            <!-- <div class="row">
              <div class="col-md-6">
                <div class="mb-15">
                  <button class="btn btn-primary waves-effect waves-classic" type="button" onclick="window.location.href='/admin/create_page'">
                    <i class="icon md-plus" aria-hidden="true"></i> Create page 
                  </button>
                </div>
              </div>
            </div> -->
<<<<<<< HEAD
            <table class="table table-hover table-bordered table-striped w-full" data-plugin="dataTable">
=======
            <table class="table table-hover table-bordered  table-striped w-full" >
>>>>>>> 18e844480f24319b789ec08b5a2afcf0ff1452bd
              <thead>
                <tr>
                  <th>CityName</th>
                  <th>State</th>
                  
                  <!-- <th>Actions</th> -->
                </tr>
              </thead>
              <tbody>
              @foreach($cities as $city)
                <tr class="gradeA">
                  <td>{{$city->name}}</td>
                  <td>{{$city->state_id}}</td>
                
                 
                </tr>
                @endforeach
              </tbody>
            </table>
<<<<<<< HEAD
                        <div class="d-flex justify-content-center">
            {!! $cities->links() !!}
            </div>
=======
            <div class="d-flex justify-content-center">
{!! $cities->links() !!}

</div>
>>>>>>> 18e844480f24319b789ec08b5a2afcf0ff1452bd
          </div>
        </div>
  @endsection
  

