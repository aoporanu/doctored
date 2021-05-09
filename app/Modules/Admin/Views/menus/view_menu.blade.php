@extends('Admin::layouts.admin')
@section('content')
<h3>View Menu</h3><br/>
<div class="panel">

                <div class="example-wrap panel-body container-fluid">
               
                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Menu Name: </strong></label>
                        <div class="col-md-9">
                       
                        
                          {{isset($menu_details) ? $menu_details->menu_name : ''}}
                        </div>
                      </div>

                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Menu Description: </strong></label>
                        <div class="col-md-9">
                        {{isset($menu_details) ? $menu_details->menu_description : ''}}
                        </div>
                      </div>

                     

                    

                      <div class="form-group  row">
                        <label class="col-md-2"><strong> Menu Url :</strong></label>
                        <div class="col-md-9">
                        {{isset($menu_details) ? $menu_details->menu_url : ''}}
                        </div>
                      </div>

                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Sort Order: </strong></label>
                        <div class="col-md-9">
                         
                        {{isset($menu_details) ? $menu_details->sort_order : ''}}
                        </div>
                      </div>

                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Menu Icon:</strong></label>
                        <div class="col-md-9">
                         
                        {{isset($menu_details) ? $menu_details->menu_icon : 'md-view-dashboard'}}
                        </div>
                      </div>

                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Parent Menu:</strong></label>
                        <div class="col-md-9">
                       
        @foreach($menus as $menu)
          {{$menu->menu_name}}
        @endforeach

                        </div>
                      </div>                     
                      <div class="form-group form-material row">
                        <div class="col-md-9">
                          <button type="button" onclick="window.location.href='/admin/edit_menu?menu_id={{$menu_details->menu_id}}'" class="btn btn-primary waves-effect waves-classic">Edit </button>
                          <button type="button" onclick="window.location.href='/admin/menus'" class="btn btn-default btn-outline waves-effect waves-classic">Back</button>
                        </div>
                      </div>
                    </form>
                  </div>

</div>
@endsection