<div class="form-group {{ $errors->has('id_paket') ? 'has-error' : ''}}">
    <label for="id_paket" class="col-md-4 control-label">{{ 'Id Paket' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="id_paket" type="number" id="id_paket" value="{{ $barangpaket->id_paket or ''}}" >
        {!! $errors->first('id_paket', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('id_barang') ? 'has-error' : ''}}">
    <label for="id_barang" class="col-md-4 control-label">{{ 'Id Barang' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="id_barang" type="number" id="id_barang" value="{{ $barangpaket->id_barang or ''}}" >
        {!! $errors->first('id_barang', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        <input class="btn btn-primary" type="submit" value="{{ $submitButtonText or 'Create' }}">
    </div>
</div>
