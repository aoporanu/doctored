@extends('Admin::layouts.admin')
@section('content')
<h3>Create/Edit Patient Meta Types</h3>
<div class="panel">
    <div class="example-wrap panel-body container-fluid">
        <form action="/admin/add_patientmetatype" method="post">
            <div class="form-group  row">
                <label class="col-md-2"><strong>Patient Meta Name: </strong></label>
                <div class="col-md-9">
                    <input type="hidden" name="pmeta_id" value="{{isset($metatypes->pmeta_id) ? $metatypes->pmeta_id : 0}}" />
                    <input name="pmetaname" class="form-control @error('pmetaname') is-invalid @enderror" id="pmetaname" value="{{isset($metatypes->pmetaname) ? $metatypes->pmetaname : ''}}" onKeyup ="setMetakey()" required />
                    @error('pmetaname')
                    <span class="invalid-feedback" role="alert">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
            </div>


            <div class="form-group  row">
                <label class="col-md-2"><strong> Patient Meta key :</strong></label>
                <div class="col-md-9">
                    <input name="pmetakey" class="form-control @error('pmetakey') is-invalid @enderror" id="pmetakey" value="{{isset($metatypes->pmetakey) ? $metatypes->pmetakey : ''}}" readonly required/>
                    @error('pmetakey')
                    <span class="invalid-feedback" role="alert">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
            </div>




            <div class="form-group  row">
                <label class="col-md-2"><strong> Patient Meta Lang Code:</strong></label>
                <div class="col-md-9">
                    <input name="pmeta_lang_code" class="form-control" id="pmeta_lang_code" value="{{isset($metatypes->pmeta_lang_code) ? $metatypes->pmeta_lang_code : ''}}" />
                </div>
            </div>

            <div class="form-group  row">
                <label class="col-md-2"><strong>Patient Meta Icon: </strong></label>
                <div class="col-md-9">

                    <input name="pmeta_icon" class="form-control" id="pmeta_icon" value="{{isset($metatypes->pmeta_icon) ? $metatypes->pmeta_icon : ''}}" />
                </div>
            </div>


            <div class="form-group form-material row">
                <div class="col-md-9">
                    <button type="submit" class="btn btn-primary waves-effect waves-classic">Submit </button>
                    <button type="button" onclick="window.location.href = '/admin/settings/patientsmetatypes'" class="btn btn-default btn-outline waves-effect waves-classic">Back</button>
                </div>
            </div>
        </form>
    </div>

</div>
<script>
    function setMetakey() {
        var title = $('#pmetaname').val();
        title = title.replace(/\s+/g, '-').toLowerCase();
        $('#pmetakey').val(title);
    }
</script>
@endsection