@extends('Admin::layouts.admin')
@section('content')
<h3 class="page-title">Create/Edit Pages</h3>
<br/>
<div class="panel">
                <div class="example-wrap panel-body container-fluid">
                <form action="/admin/add_page" method="post" enctype="multipart/form-data">
                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Page Title </strong></label>
                        <div class="col-md-9">
                        <input type="hidden" name="id" value="{{isset($page_details) ? $page_details->id : 0}}" />
                          <!-- <input type="text" class="form-control" name="name" placeholder="Page Title"> -->
                          <input  type="text" class="form-control" name="title" id="title" value="{{isset($page_details) ? $page_details->title : ''}}" onKeyup ="setSlugValue()" required />
                        </div>
                      </div>

                      <div class="form-group  row">
                        <label class="col-md-2"><strong> Slug: </strong></label>
                        <div class="col-md-9">
                          <input type="text" class="form-control" name="slug" id="slug" value="{{isset($page_details->slug) ? $page_details->slug : ''}}" readonly required />
                        </div>
                      </div>

                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Page Description:</strong></label>
                        <div class="col-md-9">
                          <textarea class="form-control" id="summernote" data-plugin="summernote" name="description">{{isset($page_details->description) ? $page_details->description  : ''}}</textarea>
                        </div>
                      </div>

                      <!-- <div  ></div> -->


                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Page Banner:</strong></label>
                        <div class="col-md-2">
                        <!-- <input name="banner" class="form-control" id="banner" value="{{isset($page_details->banner) ? $page_details->banner  : ''}}" /> -->
                       
                        <input type="file" name="banner" id="banner" multiple="">
                        </div>
                        @if (isset($page_details->banner))
                        <div class="col-md-2">
                        <img height="100%" width="100%" src="../uploads/{{$page_details->banner}}">
                        </div>
                        @endif
                      </div>

                    

                      <div class="form-group  row">
                        <label class="col-md-2"><strong> Meta Keywords :</strong></label>
                        <div class="col-md-9">
                          <input name="meta_keyword" class="form-control" id="meta_keyword" value="{{isset($page_details->meta_keyword) ? $page_details->meta_keyword  : ''}}" />
                        </div>
                      </div>

                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Meta Description :</strong></label>
                        <div class="col-md-9">
                         
                          <input name="meta_description" class="form-control" id="meta_description" value="{{isset($page_details->meta_description) ? $page_details->meta_description  : ''}}" />
                        </div>
                      </div>

                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Meta Author :</strong></label>
                        <div class="col-md-9">
                         
                          <input name="meta_author" class="form-control" id="meta_author" value="{{isset($page_details->meta_author) ? $page_details->meta_author   : ''}}" />
                        </div>
                      </div>

                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Meta Viewport :</strong></label>
                        <div class="col-md-9">
                          <!-- <input type="text" class="form-control" name="name" placeholder="Page Title"> -->
                          <input name="meta_viewport" class="form-control" id="meta_viewport" value="{{isset($page_details->meta_viewport) ? $page_details->meta_viewport   : ''}}" />
                        </div>
                      </div>                     
                      <div class="form-group form-material row">
                        <div class="col-md-9">
                          <button type="submit" class="btn btn-primary waves-effect waves-classic">Submit </button>
                          <button type="button" onclick="window.location.href='/admin/pages'" class="btn btn-default btn-outline waves-effect waves-classic">Back</button>
                        </div>
                      </div>
                    </form>
                  </div>
                  @if (isset($page_details->id))
                  <div class="row">
                    <div class="col-md-12">
                   
                    <h3 class="panel-title">Page Elements</h3>
                    <table class="table table-bordered table-hover table-striped" cellspacing="0" id="exampleAddRow">
              <thead>
                <tr>
                  <th>Type</th>
                  <th>Key</th>
                  <th>Name</th>
                  <th>Value</th>
                  <th>Actions</th>
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
                    <td><img style="height:10x;width:100px;" src="../answers/{{$element->element_value}}"></td>
                  
                  @endif
                  <td class="actions">
                    <a href="javascript:;" onClick="editPageElement({{$element->id}})" class="btn btn-sm btn-icon btn-pure btn-default on-default  waves-effect waves-classic" data-toggle="tooltip" data-original-title="Edit"><i class="icon md-edit" aria-hidden="true"></i></a>
                    <a href="javascript:;" onClick="deletePageElement({{$element->id}})" class="btn btn-sm btn-icon btn-pure btn-default on-default  waves-effect waves-classic" data-toggle="tooltip" data-original-title="Remove"><i class="icon md-delete" aria-hidden="true"></i></a>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
            </div>
                    </div>
                    <div class="col-md-12">
                    <h3 class="panel-title">Create/Edit Page Elements</h3>

                    
                    
                    <input type="hidden" id="element_id" name="id" value="{{isset($page_element->id) ? $page_element->id : 0}}" />
          
                    <input type="hidden" id="page_id" name="page_id" value="{{$page_details->id}}"/>

                    <input type="hidden" id="element_key" name="element_key" value='{{preg_replace("/\s+/", "", $page_details->title).rand(10,100000)}}'/>
                    <div class="form-group  row">
                        <label class="col-md-3"><strong>Element Type</strong></label>
                        <div class="col-md-6">
                          <select class="form-control" name="element_type" id="element_type" onChange="setElementValue()">
                            <option value='text'>TEXT</option>
                            <option value='image'>IMAGE</option>
                          </select>
                        </div>
                    </div>

                    <div class="form-group  row">
                        <label class="col-md-3"><strong> Element Name :</strong></label>
                        <div class="col-md-6">
                          <input name="element_name" class="form-control" id="element_name" value="" />
                        </div>
                      </div>

                      <div id="element_text" class="form-group  row">
                        <label class="col-md-3"><strong> Element Value :</strong></label>
                        <div class="col-md-6">
                          <input name="element_value" class="form-control" id="element_value" value="" />
                        </div>
                      </div>

                      <div id="element_image" class="form-group  row" style="display:none">
                        <label class="col-md-3"><strong>Element Value :</strong></label>
                        <div class="col-md-6">
                        <input type="file" name="elementimage" id="elementimage" multiple="">
                        </div>
                      </div>

                      
                        <div class="col-md-3" id="image"></div>
                      

                    <div class="form-group row">
                        <div class="col-md-6 offset-md-3">
                          <button type="button"  class="btn btn-primary waves-effect waves-classic" onClick="submitpageelements()">Submit</button>
                          <button type="reset" class="btn btn-warning waves-effect waves-classic">Reset</button>
                        </div>
                      </div>


                  </div>
                  </div>
                 
                  @endif
                  <script src="../customscripts/pages.js"></script>
@endsection
