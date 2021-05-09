@extends('Admin::layouts.admin')
@section('content')
<h3 class="page-title">View Pages</h3>
<br/>
<div class="panel">
                <div class="example-wrap panel-body container-fluid">
              
                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Page Title </strong></label>
                        <div class="col-md-9">
                       
                          {{isset($page_details) ? $page_details->title: '' }}
                        </div>
                      </div>

                      <div class="form-group  row">
                        <label class="col-md-2"><strong> Slug: </strong></label>
                        <div class="col-md-9">
                        {{isset($page_details->slug) ? $page_details->slug : ''}}
                        </div>
                      </div>

                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Page Description:</strong></label>
                        <div class="col-md-9">
                         {{isset($page_details->description) ? $page_details->description  : ''}}
                        </div>
                      </div>

                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Page Banner:</strong></label>
                        @if (isset($page_details->banner))
                        <div class="col-md-2">
                        <img height="100%" width="100%" src="../uploads/{{$page_details->banner}}">
                        </div>
                        @endif
                      </div>

                    

                      <div class="form-group  row">
                        <label class="col-md-2"><strong> Meta Keywords :</strong></label>
                        <div class="col-md-9">
                        {{isset($page_details->meta_keyword) ? $page_details->meta_keyword  : ''}}
                        </div>
                      </div>

                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Meta Description :</strong></label>
                        <div class="col-md-9">
                         
                         {{isset($page_details->meta_description) ? $page_details->meta_description  : ''}}
                        </div>
                      </div>

                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Meta Author :</strong></label>
                        <div class="col-md-9">
                         {{isset($page_details->meta_author) ? $page_details->meta_author   : ''}}
                        </div>
                      </div>

                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Meta Viewport :</strong></label>
                        <div class="col-md-9">
                          {{isset($page_details->meta_viewport) ? $page_details->meta_viewport   : ''}}
                        </div>
                      </div>                     
                      <div class="form-group form-material row">
                        <div class="col-md-9">
                          <button type="button" onClick="window.location.href='/admin/edit_page?id={{$page_details->id}}'" class="btn btn-primary waves-effect waves-classic">Edit </button>
                          <button type="button" onclick="window.location.href='/admin/pages'" class="btn btn-default btn-outline waves-effect waves-classic">Back</button>
                        </div>
                      </div>
                  
                  </div>
                  @if (isset($page_details->id))
                  <div class="row">
                    <div class="col-md-12">
                      <div class="row">
                    <h3 class="panel-title">Page Elements</h3>
                    <table class="table table-bordered table-hover table-striped" cellspacing="0" id="exampleAddRow">
              <thead>
                <tr>
                  <th>Type</th>
                  <th>Key</th>
                  <th>Name</th>
                  <th>Value</th>
                 </tr>
              </thead>
              <tbody>
              @foreach($page_elements as $element)
                <tr class="gradeA">
                  <td>{{$element->element_type}}</td>
                  <td>{{$element->element_key}}</td>
                  <td>{{$element->element_name}}</td>
                  @if ($element->element_type=="text")
                  <td>{{$element->element_value}}</td>
                  @else
                    <td><img style="width:100%;height:100%" src="../answers/{{$element->element_value}}"></td>
                  
                  @endif
                  
                </tr>
                @endforeach
              </tbody>
            </table>
            </div>
                    </div>
                   

                  </div>
                  </div>
                 
                  @endif
                  <script src="../customscripts/pages.js"></script>
@endsection

