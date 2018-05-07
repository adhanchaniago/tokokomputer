<div class="form-group {{ $errors->has('jenis_barang') ? 'has-error' : ''}}">
    {!! Form::label('jenis_barang', 'Jenis Barang', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('jenis_barang', null, ['class' => 'form-control']) !!}
        {!! $errors->first('jenis_barang', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary']) !!}
    </div>
</div>
