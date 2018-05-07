<div class="form-group {{ $errors->has('id_laporan') ? 'has-error' : ''}}">
    <label for="id_laporan" class="col-md-4 control-label">{{ 'Id Laporan' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="id_laporan" type="text" id="id_laporan" value="{{ $laporanakun->id_laporan or ''}}" >
        {!! $errors->first('id_laporan', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('nomor_akun') ? 'has-error' : ''}}">
    <label for="nomor_akun" class="col-md-4 control-label">{{ 'Nomor Akun' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="nomor_akun" type="text" id="nomor_akun" value="{{ $laporanakun->nomor_akun or ''}}" >
        {!! $errors->first('nomor_akun', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        <input class="btn btn-primary" type="submit" value="{{ $submitButtonText or 'Create' }}">
    </div>
</div>
