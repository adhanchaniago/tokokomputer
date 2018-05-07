<div class="form-group {{ $errors->has('id_karyawan') ? 'has-error' : ''}}">
    <label for="id_karyawan" class="col-md-4 control-label">{{ 'Id Karyawan' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="id_karyawan" type="number" id="id_karyawan" value="{{ $notapenerimaan->id_karyawan or ''}}" >
        {!! $errors->first('id_karyawan', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('id_nota_beli') ? 'has-error' : ''}}">
    <label for="id_nota_beli" class="col-md-4 control-label">{{ 'Id Nota Beli' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="id_nota_beli" type="number" id="id_nota_beli" value="{{ $notapenerimaan->id_nota_beli or ''}}" >
        {!! $errors->first('id_nota_beli', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('status') ? 'has-error' : ''}}">
    <label for="status" class="col-md-4 control-label">{{ 'Status' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="status" type="text" id="status" value="{{ $notapenerimaan->status or ''}}" >
        {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('tgl') ? 'has-error' : ''}}">
    <label for="tgl" class="col-md-4 control-label">{{ 'Tgl' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="tgl" type="date" id="tgl" value="{{ $notapenerimaan->tgl or ''}}" >
        {!! $errors->first('tgl', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        <input class="btn btn-primary" type="submit" value="{{ $submitButtonText or 'Create' }}">
    </div>
</div>
