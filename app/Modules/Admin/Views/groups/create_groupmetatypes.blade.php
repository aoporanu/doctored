@extends('Admin::layouts.admin')
@section('content')
<h3>Create/Edit Group Meta Types</h3>
<div class="panel">

    <br/>
    <div class="example-wrap panel-body container-fluid">
        <form action="/admin/add_groupmetatype" method="post">
            <div class="form-group  row">
                <label class="col-md-2"><strong>Group Meta Name: </strong></label>
                <div class="col-md-9">
                    <input type="hidden" name="gmeta_id" value="{{isset($metatypes->gmeta_id) ? $metatypes->gmeta_id : 0}}" />

                    <input name="gmetaname" style="text-transform:capitalize;" class="form-control @error('gmetaname') is-invalid @enderror" id="gmetaname" value="{{isset($metatypes->gmetaname) ? $metatypes->gmetaname : ''}}" onKeyup ="setMetakey()" required/>
                    @error('gmetaname')
                    <span class="invalid-feedback" role="alert">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
            </div>


            <div class="form-group  row">
                <label class="col-md-2"><strong> Group Meta key :</strong></label>
                <div class="col-md-9">
                    <input name="gmetakey" style="text-transform:capitalize;" class="form-control @error('gmetakey') is-invalid @enderror" id="gmetakey" value="{{isset($metatypes->gmetakey) ? $metatypes->gmetakey : ''}}" readonly required/>
                    @error('gmetakey')
                    <span class="invalid-feedback" role="alert">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
            </div>




            <div class="form-group  row">
                <label class="col-md-2"><strong> Language Code:</strong></label>
                <div class="col-md-9">
                    <input name="gmeta_lang_code" class="form-control" id="gmeta_lang_code" value="{{isset($metatypes->gmeta_lang_code) ? $metatypes->gmeta_lang_code : ''}}" />
                </div>
            </div>

            <div class="form-group  row">
                <label class="col-md-2"><strong>Group Meta Icon: </strong></label>
                <div class="col-md-9">

                    <input name="gmeta_icon" class="form-control" id="gmeta_icon" value="{{isset($metatypes->gmeta_icon) ? $metatypes->gmeta_icon : ''}}" />
                </div>
            </div>


            <div class="form-group form-material row">
                <div class="col-md-9">
                    <button type="submit" class="btn btn-primary waves-effect waves-classic">Submit </button>
                    <button type="button" onclick="window.location.href = '/admin/settings/groupmetatypes'" class="btn btn-default btn-outline waves-effect waves-classic">Back</button>
                </div>
            </div>
        </form>
    </div>

</div>
<script>
    function setMetakey() {
        var title = $('#gmetaname').val();
        title = title.replace(/\s+/g, '-').toLowerCase();
        $('#gmetakey').val(title);
    }
</script>
@endsection