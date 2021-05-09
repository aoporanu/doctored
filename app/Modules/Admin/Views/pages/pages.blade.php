@extends('Admin::layouts.admin')
@section('content')

<div class="panel">
    <header class="panel-heading">
        <h3 class="panel-title">Pages</h3>
    </header>
    <div class="panel-body">
        <div class="row">

            <div class="col-md-3">
                <div class="mb-15">
                    @if(isset($accessDetails) && isset($accessDetails->create_access) && $accessDetails->create_access)
                    <button class="btn btn-primary waves-effect waves-classic" type="button" onclick="window.location.href = '/admin/create_page'">
                        <i class="icon md-plus" aria-hidden="true"></i> Create page 
                    </button>
                    @endif
                </div>
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-9">
                        <form action="/admin/pages" method="POST" role="search">
                            <div class="input-group">
                                <input type="text" class="form-control" name="q"
                                       placeholder="Search pages"> <span class="input-group-btn">
                                    <span class="input-group-btn">
                                        <button type="submit" class="btn btn-primary waves-effect waves-classic"><i class="icon md-search" aria-hidden="true"></i></button>
                                    </span>
                            </div>
                        </form>
                    </div>
                    @if($isSearch)
                    <div class="col-md-3">
                        <div class="form-group">

                            <button type="button" onclick="window.location.href = '/admin/pages'" class="btn btn-warning btn-outline waves-effect waves-classic">Clear Search</button>
                        </div>
                    </div>
                    @endif

                </div>
            </div>
        </div>
        <table class="table table-bordered table-hover table-striped" cellspacing="0" >
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Slug</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pages as $page)
                <tr class="gradeA">
                    <td>{{$page->title}}</td>
                    <td>{{$page->slug}}</td>
                    <td>{!!$page->description!!}</td>
                    <td>{{$page->is_active == 1 ? 'Active' : 'In-Active'}}</td>
                    <td class="actions">
                        @if(isset($accessDetails) && $accessDetails->edit_access)
                        <a href="/admin/edit_page?id={{$page->id}}" class="btn btn-sm btn-icon btn-pure btn-default on-default  waves-effect waves-classic" data-toggle="tooltip" data-original-title="Edit"><i class="icon md-edit" aria-hidden="true"></i></a>
                        @endif
                        @if(isset($accessDetails) && $accessDetails->view_access)
                        <a href="/admin/view_page?id={{$page->id}}" class="btn btn-sm btn-icon btn-pure btn-default on-default  waves-effect waves-classic" data-toggle="tooltip" data-original-title="View"><i class="icon md-eye" aria-hidden="true"></i></a>
                        @endif
                        @if(isset($accessDetails) && $accessDetails->activate_access && $page->is_delete == 0)
                        <div  class="btn btn-sm btn-icon btn-pure btn-default on-default  waves-effect waves-classic example" style="display: inline-block; margin-top: 0px; margin-bottom: 0px;">
                            <div class="float-left">
                                <input type="checkbox" id="inputBasicOn" class="activate_button" name="inputiCheckBasicCheckboxes" data-plugin="switchery" data-size="small"
                                       value="{{$page->id}}" {{$page->is_active == 1 ? 'checked' : '' }} />
                            </div>
                        </div>
                        @endif
                        @if(isset($page->is_lock) && $page->is_lock == 1)
                            <a href="javascript:void(0);" class="btn btn-sm btn-icon btn-pure btn-default on-default  waves-effect waves-classic" data-toggle="tooltip" data-original-title="In-active"><i class="icon md-lock" aria-hidden="true"></i></a>
                        @else
                            @if(isset($accessDetails) && $accessDetails->delete_access == 1)
                                <a href="/admin/delete_page?id={{$page->id}}" class="btn btn-sm btn-icon btn-pure btn-default on-default  waves-effect waves-classic" data-toggle="tooltip" data-original-title="Remove"><i class="icon md-delete" aria-hidden="true"></i></a>
                            @endif
                        @endif    
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {{isset($pages) && $pages instanceof \Illuminate\Pagination\LengthAwarePaginator ? $pages->links() : ''}}
        </div>
    </div>
</div>

@endsection

