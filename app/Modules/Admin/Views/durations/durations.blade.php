@extends('Admin::layouts.admin')
@section('content')
<div class="panel">
    <header class="panel-heading">
        <h3 class="panel-title">Durations</h3>
    </header>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-15">
                    @if(isset($accessDetails) && isset($accessDetails->create_access) && $accessDetails->create_access)
                    <button class="btn btn-primary waves-effect waves-classic" type="button" onclick="window.location.href = '/admin/create_duration'">
                        <i class="icon md-plus" aria-hidden="true"></i> Create Duration 
                    </button>
                    @endif
                </div>
            </div>
        </div>
		
        <table class="table table-bordered table-hover table-striped" cellspacing="0" >
            <thead>
                <tr>
				     <th>Shift</th>
                    <th>Start(24 Hours)</th>
                    <th>End(24 Hours)</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
			     @foreach($durations as $duration)
				 	@if($duration->is_active==1)
							@php $status_icon ='md-star-outline' ;  $status_text ='active' @endphp

						@else
							@php $status_icon ='md-star' ;  $status_text ='Inactive' @endphp
						@endif
                <tr class="gradeA">
				     <td> {{$duration->shift}}</td>
                    <td>{{$duration->s_start}}</td>
					 <td>{{$duration->s_end}}</td>
                    <td class="actions">
					@if(isset($duration->is_lock) && $duration->is_lock!='1')
                        @if(isset($accessDetails) && $accessDetails->edit_access)
                        <a href="/admin/edit_duration/{{\App\Http\Middleware\EncryptUrlParams::encrypt($mapping_key.$duration->id)}}" class="btn btn-sm btn-icon btn-pure btn-default on-default  waves-effect waves-classic" data-toggle="tooltip" data-original-title="Edit"><i class="icon md-edit" aria-hidden="true"></i></a>
                        @endif
                        @if(isset($accessDetails) && $accessDetails->view_access)
							    <a href="/admin/view_duration/{{\App\Http\Middleware\EncryptUrlParams::encrypt($mapping_key.$duration->id)}}" class="btn btn-sm btn-icon btn-pure btn-default on-default  waves-effect waves-classic" data-toggle="tooltip" data-original-title="View"><i class="icon md-eye" aria-hidden="true"></i></a>
                    
                        @endif
                        @if(isset($accessDetails) && $accessDetails->delete_access)
                        <a href="/admin/delete_duration/{{\App\Http\Middleware\EncryptUrlParams::encrypt($mapping_key.$duration->id)}}" class="btn btn-sm btn-icon btn-pure btn-default on-default  waves-effect waves-classic" data-toggle="tooltip" data-original-title="Remove"><i class="icon md-delete" aria-hidden="true"></i></a>
                        @endif
						<!--- status update -->

					
						<a href="/admin/status_duration/{{\App\Http\Middleware\EncryptUrlParams::encrypt($mapping_key.$duration->id)}}/{{$duration->is_active}}" class="btn btn-sm btn-icon btn-pure btn-default on-default  waves-effect waves-classic" data-toggle="tooltip" data-original-title="{{$status_text}}"><i class="icon {{$status_icon}}" aria-hidden="true"></i></a>
						
					   <!--- status update -->
					@else 
				     <i class="icon md-lock" aria-hidden="true"></i>
					 
						
					@endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {{isset($durations) && $durations instanceof \Illuminate\Pagination\LengthAwarePaginator ? $durations->links() : ''}}
        </div>
    </div>
</div>

@endsection
