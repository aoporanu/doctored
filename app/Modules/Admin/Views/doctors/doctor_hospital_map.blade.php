@extends('Admin::layouts.admin')
@section('content')
<style type="text/css">
  .ui-autocomplete{
        z-index: 10100 !important; top:295px;  
        height:100px; 
        overflow-y: scroll; o
        verflow-x:hidden; 
        border-top:none!important;
        left: 475px;
    }
  .ui-autocomplete li{ 
    border-bottom:1px solid #efefef; 
    padding-top:10px !important; 
    padding-bottom:10px !important; 
    }
</style>
<div class="panel">
      <header class="panel-heading">
        <h3 class="panel-title">Doctor Hospital Mapping</h3>
      </header>
      <div class="panel-body">
      @if(Session::has('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }}
        </div>
      @endif
      <button class="btn btn-success waves-effect waves-classic" type="button" onclick="window.location.href='/admin/create_doctors'" style="float: right;"> Create New Doctor</button>
      <form action="doctorhostpitalmap" name="doctorhostpitalmap" id="doctorhostpitalmap" method="POST">
          <div class="row">
            <div class="col-md-2">
                <label><strong>Group Name:</strong></label> <span>
            </div>
            <div class="col-md-4">
              {{isset($userGroup->group_name)?$userGroup->group_name:''}}</span>
            </div>
          </div>
          <div class="row">
            <div class="col-md-2">
              <lable><strong>Hospital:</strong><span class="mand">*</span></lable>
            </div>
            <div class="col-md-4">
              <select name="hospital[]" id="hospital" multiple="multiple" class="form-control" style="height:50px">
                  @foreach($hospitalData as $hospital)
                  <option value="{{$hospital->hospital_id}}">{{$hospital->hospital_name}}({{$hospital->hospitalcode}})</option>
                  @endforeach
                </select>
                @error('hospital')
                    <span class="" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
          </div>
        </br>
          <div class="row">
            <div class="col-md-2">
              <lable><strong>Doctor:</strong><span class="mand">*</span></lable>
            </div>
            <div class="col-md-4">
                <input type="text" id="doc_licence" name="doc_licence" placeholder="Search doctor with licence no" class="form-control">
                <input type="hidden" name="doctor_id" id="doctor_id" value=""/>
                @error('doc_licence')
                    <span class="" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-success" onclick="getDoctorDetails()">Fetch Details</button>
            </div>
          </div>
          
          <div class="row" style="" id="doc_info">
          </div>

          <div class="row">
            <div class="col-md-6" style="padding: 20px 170px;">
            <button class="btn btn-success" type="submit">Save</button>
          </div>
          </div>
      </form>
        <div class="row">
          <hr>
            <table class="table table-bordered table-hover table-striped" cellspacing="0">
              <thead>
                <tr>
                  <th>Group</th>
                  <th>Hospital</th>
                  <th>Code</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
              @foreach($doctorslist as $doc)
                <tr class="gradeA">
                    <td>{{$doc->group_name}}</td>
                    <td>{{$doc->hospital_name}}</td>
                    <td> {{$doc->doctorcode}} </td>                 
                    <td>
                      <div class="media">
                      <div class="pr-20">
                      @if($doc->is_verified!=1) 
                      <a class="avatar  avatar-away" href="javascript:void(0)">
                      @else
                      <a class="avatar  avatar-online" href="javascript:void(0)">
                      @endif
                          <img src="/material/global/portraits/5.jpg" alt=""><i></i></a>
                      </div>
                      <div class="media-body">
                        <h5 class="mt-0 mb-5">
                          <span class="name">{{$doc->title}}.{{ucfirst($doc->firstname)}}  {{$doc->lastname}}
                      </td>
                      <td>{{$doc->email}}</td>
                      
                  <td class="actions">
                    <a href="/admin/delete_doctor_mapping?id={{$doc->hd_mapping_id}}" class="btn btn-sm btn-icon btn-pure btn-default on-default  waves-effect waves-classic" data-toggle="tooltip" data-original-title="Remove"><i class="icon md-delete" aria-hidden="true"></i></a>
                  </td>
                </tr>
                @endforeach 
              </tbody>
            </table>

        </div>
        
      </div>
    </div>
<script type="text/javascript">
  function getDoctorDetails(){
    var doctor_id = $('#doctor_id').val();
    if(doctor_id!=""){
      $.ajax({
             headers:{'X-CSRF-Token': $('input[name="_token"]').val()},
             url: 'getDoctorDetails',
             type: 'POST',
             data: {doctor_id:doctor_id},
             dataType:'JSON',
             success: function (data) {  
                $("#doc_info").html(data.response);
                
             },
             error: function (response) {

             }
         });
    }

  }
</script>>

@endsection
