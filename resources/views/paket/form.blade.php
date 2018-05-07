<div class="form-group {{ $errors->has('nama') ? 'has-error' : ''}}">
    {!! Form::label('nama', 'Nama', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('nama', null, ['class' => 'form-control']) !!}
        {!! $errors->first('nama', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('detail') ? 'has-error' : ''}}">
    {!! Form::label('detail', 'Detail', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::textarea('detail', null, ['class' => 'form-control']) !!}
        {!! $errors->first('detail', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('total_harga_jual') ? 'has-error' : ''}}">
    {!! Form::label('total_harga_jual', 'Total Harga Jual', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('total_harga_jual', null, ['class' => 'form-control']) !!}
        {!! $errors->first('total_harga_jual', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('total_harga_asli') ? 'has-error' : ''}}">
    {!! Form::label('total_harga_asli', 'Total Harga Asli', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('total_harga_asli', null, ['class' => 'form-control']) !!}
        {!! $errors->first('total_harga_asli', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('stok') ? 'has-error' : ''}}">
    {!! Form::label('stok', 'Stok', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('stok', null, ['class' => 'form-control']) !!}
        {!! $errors->first('stok', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary']) !!}
    </div>
</div>
