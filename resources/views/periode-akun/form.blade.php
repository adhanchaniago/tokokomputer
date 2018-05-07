<div class="form-group {{ $errors->has('id_periode') ? 'has-error' : ''}}">
    <label for="id_periode" class="col-md-4 control-label">{{ 'Id Periode' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="id_periode" type="number" id="id_periode" value="{{ $periodeakun->id_periode or ''}}" >
        {!! $errors->first('id_periode', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('nomor_akun') ? 'has-error' : ''}}">
    <label for="nomor_akun" class="col-md-4 control-label">{{ 'Nomor Akun' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="nomor_akun" type="text" id="nomor_akun" value="{{ $periodeakun->nomor_akun or ''}}" >
        {!! $errors->first('nomor_akun', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('saldo_akhir') ? 'has-error' : ''}}">
    <label for="saldo_akhir" class="col-md-4 control-label">{{ 'Saldo Akhir' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="saldo_akhir" type="number" id="saldo_akhir" value="{{ $periodeakun->saldo_akhir or ''}}" >
        {!! $errors->first('saldo_akhir', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        <input class="btn btn-primary" type="submit" value="{{ $submitButtonText or 'Create' }}">
    </div>
</div>
