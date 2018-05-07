<div class="form-group {{ $errors->has('id_jurnal') ? 'has-error' : ''}}">
    <label for="id_jurnal" class="col-md-4 control-label">{{ 'Id Jurnal' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="id_jurnal" type="number" id="id_jurnal" value="{{ $akunjurnal->id_jurnal or ''}}" >
        {!! $errors->first('id_jurnal', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('nomor_akun') ? 'has-error' : ''}}">
    <label for="nomor_akun" class="col-md-4 control-label">{{ 'Nomor Akun' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="nomor_akun" type="text" id="nomor_akun" value="{{ $akunjurnal->nomor_akun or ''}}" >
        {!! $errors->first('nomor_akun', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('nominal_debet') ? 'has-error' : ''}}">
    <label for="nominal_debet" class="col-md-4 control-label">{{ 'Nominal Debet' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="nominal_debet" type="number" id="nominal_debet" value="{{ $akunjurnal->nominal_debet or ''}}" >
        {!! $errors->first('nominal_debet', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('nominal_kredit') ? 'has-error' : ''}}">
    <label for="nominal_kredit" class="col-md-4 control-label">{{ 'Nominal Kredit' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="nominal_kredit" type="number" id="nominal_kredit" value="{{ $akunjurnal->nominal_kredit or ''}}" >
        {!! $errors->first('nominal_kredit', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        <input class="btn btn-primary" type="submit" value="{{ $submitButtonText or 'Create' }}">
    </div>
</div>
