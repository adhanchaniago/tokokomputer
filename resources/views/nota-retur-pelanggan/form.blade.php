<div class="form-group {{ $errors->has('tgl') ? 'has-error' : ''}}">
    <label for="tgl" class="col-md-4 control-label">{{ 'Tgl' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="tgl" type="date" id="tgl" value="{{ $notareturpelanggan->tgl or ''}}" >
        {!! $errors->first('tgl', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('tgl_selesai') ? 'has-error' : ''}}">
    <label for="tgl_selesai" class="col-md-4 control-label">{{ 'Tgl Selesai' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="tgl_selesai" type="date" id="tgl_selesai" value="{{ $notareturpelanggan->tgl_selesai or ''}}" >
        {!! $errors->first('tgl_selesai', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('jenis_retur') ? 'has-error' : ''}}">
    <label for="jenis_retur" class="col-md-4 control-label">{{ 'Jenis Retur' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="jenis_retur" type="text" id="jenis_retur" value="{{ $notareturpelanggan->jenis_retur or ''}}" >
        {!! $errors->first('jenis_retur', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('id_user') ? 'has-error' : ''}}">
    <label for="id_user" class="col-md-4 control-label">{{ 'Id User' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="id_user" type="number" id="id_user" value="{{ $notareturpelanggan->id_user or ''}}" >
        {!! $errors->first('id_user', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('status') ? 'has-error' : ''}}">
    <label for="status" class="col-md-4 control-label">{{ 'Status' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="status" type="text" id="status" value="{{ $notareturpelanggan->status or ''}}" >
        {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('catatan') ? 'has-error' : ''}}">
    <label for="catatan" class="col-md-4 control-label">{{ 'Catatan' }}</label>
    <div class="col-md-6">
        <textarea class="form-control" rows="5" name="catatan" type="textarea" id="catatan" >{{ $notareturpelanggan->catatan or ''}}</textarea>
        {!! $errors->first('catatan', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('nama_bank') ? 'has-error' : ''}}">
    <label for="nama_bank" class="col-md-4 control-label">{{ 'Nama Bank' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="nama_bank" type="text" id="nama_bank" value="{{ $notareturpelanggan->nama_bank or ''}}" >
        {!! $errors->first('nama_bank', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('no_rek') ? 'has-error' : ''}}">
    <label for="no_rek" class="col-md-4 control-label">{{ 'No Rek' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="no_rek" type="text" id="no_rek" value="{{ $notareturpelanggan->no_rek or ''}}" >
        {!! $errors->first('no_rek', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('pengirim') ? 'has-error' : ''}}">
    <label for="pengirim" class="col-md-4 control-label">{{ 'Pengirim' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="pengirim" type="text" id="pengirim" value="{{ $notareturpelanggan->pengirim or ''}}" >
        {!! $errors->first('pengirim', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        <input class="btn btn-primary" type="submit" value="{{ $submitButtonText or 'Create' }}">
    </div>
</div>
