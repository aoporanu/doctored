@extends('Admin::layouts.admin')
@section('content')
<h3 class="page-title">Create/Edit Menus</h3>
<br/>
<div class="panel">
    <div class="example-wrap panel-body container-fluid">
        <form action="/admin/add_menu" method="post">
            {{ csrf_field() }}
            <div class="form-group  row">
                <label class="col-md-2"><strong>Menu Name: </strong></label>
                <div class="col-md-9">
                    <input type="hidden" name="menu_id" value="{{isset($menu_details) ? $menu_details->menu_id : 0}}" />
                    <input name="menu_name" class="form-control" id="menu_name" value="{{isset($menu_details) ? $menu_details->menu_name : old('menu_name')}}" />
                    @error('menu_name')
                    <span class="invalid-feedback" role="alert">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group  row">
                <label class="col-md-2"><strong>Menu Description: </strong></label>
                <div class="col-md-9">
                    <textarea class="form-control" name="menu_description">{{isset($menu_details) ? $menu_details->menu_description : old('menu_description')}}</textarea>
                    @error('menu_description')
                    <span class="invalid-feedback" role="alert">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group  row">
                <label class="col-md-2"><strong> Menu Url :</strong></label>
                <div class="col-md-9">
                    <input name="menu_url" class="form-control" id="menu_url" value="{{isset($menu_details) ? $menu_details->menu_url : old('menu_url')}}" />
                    @error('menu_url')
                    <span class="invalid-feedback" role="alert">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group  row">
                <label class="col-md-2"><strong>Sort Order: </strong></label>
                <div class="col-md-9">
                    <input name="sort_order" class="form-control" id="sort_order" value="{{isset($menu_details) ? $menu_details->sort_order : (isset($sortOrder) ? $sortOrder : old('sort_order'))}}" />
                    @error('sort_order')
                    <span class="invalid-feedback" role="alert">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group  row">
                <label class="col-md-2"><strong>Menu Icon:</strong></label>
                <div class="col-md-9">
                    <input name="menu_icon" class="form-control" id="menu_icon" value="{{isset($menu_details) ? $menu_details->menu_icon : 'md-view-dashboard'}}" />
                    @error('menu_icon')
                    <span class="invalid-feedback" role="alert">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group  row">
                <label class="col-md-2"><strong>Parent Menu:</strong></label>
                <div class="col-md-9">
                    <select name="parent_id" class="form-control">
                        <option value="0">Please select</option>
                        @foreach($menus as $menu)
                        <option value="{{$menu->menu_id}}">{{$menu->menu_name}}</option>
                        @endforeach
                    </select>
                    @error('parent_id')
                    <span class="invalid-feedback" role="alert">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
            </div>                     
            <div class="form-group form-material row">
                <div class="col-md-9">
                    <button type="submit" class="btn btn-primary waves-effect waves-classic">Submit </button>
                    <button type="button" onclick="window.location.href = '/admin/menus'" class="btn btn-default btn-outline waves-effect waves-classic">Back</button>
                </div>
            </div>
        </form>
    </div>    
</div>
@endsection