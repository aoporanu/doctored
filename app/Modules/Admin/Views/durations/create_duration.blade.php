@extends('Admin::layouts.admin')
@section('content')
<h3>Create/Edit Duration</h3>
 
<div class="panel">
    <div class="example-wrap panel-body container-fluid">
        <form action="/admin/add_duration" method="post">
            <div class="form-group  row">
                <label class="col-md-2"><strong>Shift</strong></label>
                <div class="col-md-9">
                    <input type="hidden" name="id" value="{{isset($duration_details) ? $duration_details->id : 0}}" />

                    <input name="shift" class="form-control" id="shift"  value="{{isset($duration_details) ? $duration_details->shift : old('shift')}}" />
                 @error('shift')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
			   </div>
            </div>
			<div class="row">
			<div class="form-group row">
			
                <label class="col-md-2"><strong>Start</strong></label>
                <div class="col-md-9">
                 
                    <input name="s_start" class="form-control" id="s_start"  value="{{isset($duration_details) ? $duration_details->s_start : old('s_start')}}" />
  @error('s_start')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror               
			   </div>
            </div>
			<div class="form-group row">
			
                <label class="col-md-2"><strong>End</strong></label>
                <div class="col-md-9">
                 
                    <input name="s_end" class="form-control" id="s_end"  value="{{isset($duration_details) ? $duration_details->s_end : old('s_end')}}" />
 @error('s_end')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror                
			  </div>
            </div>
			</div>
                   
            <div class="form-group form-material row">
                <div class="col-md-9">
                    <button type="submit" class="btn btn-primary waves-effect waves-classic">Submit </button>
                    <button type="button" onclick="window.location.href = '/admin/durations'" class="btn btn-default btn-outline waves-effect waves-classic">Back</button>
                </div>
            </div>
        </form>
    </div>    
</div>
@endsection