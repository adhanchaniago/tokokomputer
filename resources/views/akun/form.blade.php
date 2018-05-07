<div class="form-group {{ $errors->has('nomor') ? 'has-error' : ''}}">
    <label for="nomor" class="col-md-4 control-label">{{ 'Nomor' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="nomor" type="text" id="nomor" value="{{ $akun->nomor or ''}}" >
        {!! $errors->first('nomor', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('nama') ? 'has-error' : ''}}">
    <label for="nama" class="col-md-4 control-label">{{ 'Nama' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="nama" type="text" id="nama" value="{{ $akun->nama or ''}}" >
        {!! $errors->first('nama', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        <input class="btn btn-primary" type="submit" value="{{ $submitButtonText or 'Create' }}">
    </div>
</div>
