@extends('Admin::layouts.admin')
@section('content')
<h3>Create/Edit Hospital Meta Types</h3>
<div class="panel">

    <br/>
    <div class="example-wrap panel-body container-fluid">
        <form action="/admin/add_hospitalmetatype" method="post">
            <div class="form-group  row">
                <label class="col-md-2"><strong>Hospital Meta Name: </strong></label>
                <div class="col-md-9">
                    <input type="hidden" name="hmeta_id" value="{{isset($metatypes->hmeta_id) ? $metatypes->hmeta_id : 0}}" />

                    <input name="hmetaname" class="form-control @error('hmetaname') is-invalid @enderror" id="hmetaname" value="{{isset($metatypes->hmetaname) ? $metatypes->hmetaname : ''}}" onKeyup ="setMetakey()" required/>
                    @error('hmetaname')
                    <span class="invalid-feedback" role="alert">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
            </div>


            <div class="form-group  row">
                <label class="col-md-2"><strong> Hospital Meta key :</strong></label>
                <div class="col-md-9">
                    <input name="hmetakey" class="form-control @error('hmetakey') is-invalid @enderror" id="hmetakey" value="{{isset($metatypes->hmetakey) ? $metatypes->hmetakey : ''}}" readonly required/>
                    @error('hmetakey')
                    <span class="invalid-feedback" role="alert">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
            </div>




            <div class="form-group  row">
                <label class="col-md-2"><strong> Hospital Meta Lang Code:</strong></label>
                <div class="col-md-9">
                    <input name="hmeta_lang_code" class="form-control" id="hmeta_lang_code" value="{{isset($metatypes->hmeta_lang_code) ? $metatypes->hmeta_lang_code : ''}}" />
                </div>
            </div>

            <div class="form-group  row">
                <label class="col-md-2"><strong>Hospital Meta Icon: </strong></label>
                <div class="col-md-9">

                    <input name="hmeta_icon" class="form-control" id="hmeta_icon" value="{{isset($metatypes->hmeta_icon) ? $metatypes->hmeta_icon : ''}}" />
                </div>
            </div>


            <div class="form-group form-material row">
                <div class="col-md-9">
                    <button type="submit" class="btn btn-primary waves-effect waves-classic">Submit </button>
                    <button type="button" onclick="window.location.href = '/admin/settings/hospitalmetatypes'" class="btn btn-default btn-outline waves-effect waves-classic">Back</button>
                </div>
            </div>
        </form>
    </div>

</div>
<script>
    function setMetakey() {
        var title = $('#hmetaname').val();
        title = title.replace(/\s+/g, '-').toLowerCase();
        $('#hmetakey').val(title);
    }
</script>
@endsection