<div class="form-group {{ $errors->has('tgl') ? 'has-error' : ''}}">
    <label for="tgl" class="col-md-4 control-label">{{ 'Tgl' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="tgl" type="date" id="tgl" value="{{ $jurnal->tgl or ''}}" >
        {!! $errors->first('tgl', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('keterangan') ? 'has-error' : ''}}">
    <label for="keterangan" class="col-md-4 control-label">{{ 'Keterangan' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="keterangan" type="text" id="keterangan" value="{{ $jurnal->keterangan or ''}}" >
        {!! $errors->first('keterangan', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('jenis') ? 'has-error' : ''}}">
    <label for="jenis" class="col-md-4 control-label">{{ 'Jenis' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="jenis" type="text" id="jenis" value="{{ $jurnal->jenis or ''}}" >
        {!! $errors->first('jenis', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('id_periode') ? 'has-error' : ''}}">
    <label for="id_periode" class="col-md-4 control-label">{{ 'Id Periode' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="id_periode" type="number" id="id_periode" value="{{ $jurnal->id_periode or ''}}" >
        {!! $errors->first('id_periode', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        <input class="btn btn-primary" type="submit" value="{{ $submitButtonText or 'Create' }}">
    </div>
</div>
