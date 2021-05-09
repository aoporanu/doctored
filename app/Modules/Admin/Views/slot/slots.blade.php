@extends('Admin::layouts.admin')
@section('content')
<div class="panel">
  <header class="panel-heading">
    <h3 class="panel-title">Slots</h3>
  </header>
  <div class="panel-body">
    
    <table class="table table-bordered table-hover table-striped" cellspacing="0">
      <thead>
        <tr>
          	<th>Doctor ID</th>
            <th>Doctor Name</th>
            <th>Hospital ID</th>
            <th>Hospital Name</th>
			<th>Screen ID </th>
			<th>Action</th>
        </tr>
      </thead>
      <tbody>
      @foreach($configurations as $key=>$val)
		  <tr>
		  	<td>{{$val->doctor_id}}</td>
            <td>{{ucfirst($val->doctor_name)}}</td>
            <td>{{$val->hospital_id}}</td>
            <td>{{ucfirst($val->hospital_name)}}</td>
            <td>{{$val->screen_id}}</td>
			  <td style="padding:5px" > 
			  <a href="/admin/slotsdetails?s={{$val->screen_id}}&h={{base64_encode(ucfirst($val->hospital_name))}}" class="btn btn-sm btn-icon btn-pure btn-default on-default  waves-effect waves-classic" data-toggle="tooltip" data-original-title="View"><i class="icon md-eye" aria-hidden="true"></i></a></td>

        </tr>
		@endforeach
      </tbody>
    </table>

  </div>
</div>
@endsection