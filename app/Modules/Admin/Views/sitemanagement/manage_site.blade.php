@extends('Admin::layouts.admin')
@section('content')
<h3 class="page-title">Site Management</h3>
<br/>
<div class="panel">
                <div class="example-wrap panel-body container-fluid">
                <form action="/admin/sitemanagement" method="post" enctype="multipart/form-data">
                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Site Name</strong></label>
                        <div class="col-md-9">
                          <input type="hidden" name="id" value="{{isset($site_details) ? $site_details->id : 0}}" />
                          <input  type="text" class="form-control" name="sitename" id="sitename" value="{{isset($site_details) ? $site_details->sitename : ''}}" required />
                        </div>
                      </div>

                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Favicon:</strong></label>
                        <div class="col-md-2">
                      
                        <input type="file" name="favicon" id="favicon" multiple="">
                        </div>
                        @if (isset($site_details->favicon))
                        <div class="col-md-2">
                        <img height="100%" width="100%" src="../Sitemanagement/{{$site_details->favicon}}">
                        </div>
                        @endif
                      </div>

                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Logo Big:</strong></label>
                        <div class="col-md-2">
                      
                        <input type="file" name="logo_big" id="logo_big" multiple="">
                        </div>
                        @if (isset($site_details->logo_big))
                        <div class="col-md-2">
                        <img height="100%" width="100%" src="../Sitemanagement/{{$site_details->logo_big}}">
                        </div>
                        @endif
                      </div>

                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Logo Small:</strong></label>
                        <div class="col-md-2">
                      
                        <input type="file" name="logo_small" id="logo_small" multiple="">
                        </div>
                        @if (isset($site_details->logo_small))
                        <div class="col-md-2">
                        <img height="100%" width="100%" src="../Sitemanagement/{{$site_details->logo_small}}">
                        </div>
                        @endif
                      </div>


                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Banner:</strong></label>
                        <div class="col-md-2">
                        <!-- <input name="banner" class="form-control" id="banner" value="{{isset($site_details->banner) ? $site_details->banner  : ''}}" /> -->
                       
                        <input type="file" name="banner" id="banner" multiple="">
                        </div>
                        @if (isset($site_details->banner))
                        <div class="col-md-2">
                        <img height="100%" width="100%" src="../Sitemanagement/{{$site_details->banner}}">
                        </div>
                        @endif
                      </div>

                    

                      <div class="form-group  row">
                        <label class="col-md-2"><strong> Meta Keywords :</strong></label>
                        <div class="col-md-9">
                          <input name="meta_keyword" class="form-control" id="meta_keyword" value="{{isset($site_details->meta_keyword) ? $site_details->meta_keyword  : ''}}" />
                        </div>
                      </div>

                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Meta Description :</strong></label>
                        <div class="col-md-9">
                         
                          <input name="meta_description" class="form-control" id="meta_description" value="{{isset($site_details->meta_description) ? $site_details->meta_description  : ''}}" />
                        </div>
                      </div>

                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Meta Author :</strong></label>
                        <div class="col-md-9">
                         
                          <input name="meta_author" class="form-control" id="meta_author" value="{{isset($site_details->meta_author) ? $site_details->meta_author   : ''}}" />
                        </div>
                      </div>

                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Meta Viewport :</strong></label>
                        <div class="col-md-9">
                          <input name="meta_viewport" class="form-control" id="meta_viewport" value="{{isset($site_details->meta_viewport) ? $site_details->meta_viewport   : ''}}" />
                        </div>
                      </div>    

                       <div class="form-group  row">
                        <label class="col-md-2"><strong>Copyright :</strong></label>
                        <div class="col-md-9">
                          <input name="copyright" class="form-control" id="copyright" value="{{isset($site_details->copyright) ? $site_details->copyright   : ''}}" />
                        </div>
                      </div>  

                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Footer Description :</strong></label>
                        <div class="col-md-9">
                          <textarea name="footerdescription" class="form-control" id="footerdescription"> {{isset($site_details->footerdescription) ? $site_details->footerdescription   : ''}}</textarea>
                        </div>
                      </div> 

                      <div class="form-group  row">
                        <label class="col-md-2"><strong>Footer Social :</strong></label>
                        <div class="col-md-9">
                          <input name="footer_social" class="form-control" id="footer_social" value="{{isset($site_details->footer_social) ? $site_details->footer_social   : ''}}" />
                        </div>
                      </div> 

                      <div class="form-group form-material row">
                        <div class="col-md-9">
                          <button type="submit" class="btn btn-primary waves-effect waves-classic">Submit </button>
                          <button type="button" onclick="window.location.href='/admin/dashboard'" class="btn btn-default btn-outline waves-effect waves-classic">Back</button>
                        </div>
                      </div>
                    </form>
                  </div>
                  </div>
              
@endsection

