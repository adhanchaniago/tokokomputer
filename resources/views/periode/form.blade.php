<div class="form-group {{ $errors->has('tgl_awal') ? 'has-error' : ''}}">
    <label for="tgl_awal" class="col-md-4 control-label">{{ 'Tgl Awal' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="tgl_awal" type="date" id="tgl_awal" onchange="ubah(this)" min="{{date('Y-m-d', strtotime($periode->tgl_akhir.' + 1 day'))}}" value="{{date('Y-m-d', strtotime($periode->tgl_akhir.' + 1 day'))}}" >
        {!! $errors->first('tgl_awal', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('tgl_akhir') ? 'has-error' : ''}}">
    <label for="tgl_akhir" class="col-md-4 control-label">{{ 'Tgl Akhir' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="tgl_akhir" type="date" id="tgl_akhir" value="{{date('Y-m-d', strtotime($periode->tgl_akhir.' + 1 day'))}}" >
        {!! $errors->first('tgl_akhir', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<input type="hidden" name="status" value="aktif">
<input type="hidden" name="id_sebelum" value="{{$periode->id}}">


<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        <input class="btn btn-primary" type="submit" value="{{ $submitButtonText or 'Create' }}">
    </div>
</div>

<script type="text/javascript">
function ubah(param){

    $('#tgl_akhir').attr('min',param.value)
    $('#tgl_akhir').val(param.value)
}
</script>
