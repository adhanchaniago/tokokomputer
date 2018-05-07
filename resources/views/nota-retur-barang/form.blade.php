<div class="form-group {{ $errors->has('nonota') ? 'has-error' : ''}}">
    {!! Form::label('nonota', 'Nonota', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('nonota', null, ['class' => 'form-control']) !!}
        {!! $errors->first('nonota', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('tgl_retur') ? 'has-error' : ''}}">
    {!! Form::label('tgl_retur', 'Tgl Retur', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::textarea('tgl_retur', null, ['class' => 'form-control']) !!}
        {!! $errors->first('tgl_retur', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('tgl_selesai') ? 'has-error' : ''}}">
    {!! Form::label('tgl_selesai', 'Tgl Selesai', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('tgl_selesai', null, ['class' => 'form-control']) !!}
        {!! $errors->first('tgl_selesai', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('jenis_retur') ? 'has-error' : ''}}">
    {!! Form::label('jenis_retur', 'Jenis Retur', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('jenis_retur', null, ['class' => 'form-control']) !!}
        {!! $errors->first('jenis_retur', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary']) !!}
    </div>
</div>
