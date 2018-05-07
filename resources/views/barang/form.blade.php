<div class="form-group {{ $errors->has('nama') ? 'has-error' : ''}}">
    {!! Form::label('nama', 'Nama', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('nama', null, ['class' => 'form-control']) !!}
        {!! $errors->first('nama', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('detail') ? 'has-error' : ''}}">
    {!! Form::label('detail', 'Detail', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        <input type="file" name="detail" class="form-control"  accept="image/*">
    </div>
</div>
@if(!isset($barang))
<div class="form-group {{ $errors->has('harga_asli') ? 'has-error' : ''}}">
    {!! Form::label('harga_beli', 'Harga Beli', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('harga_asli', null, ['class' => 'form-control']) !!}
        {!! $errors->first('harga_beli', '<p class="help-block">:message</p>') !!}
    </div>
</div>
@endif
<div class="form-group {{ $errors->has('harga_jual') ? 'has-error' : ''}}">
    {!! Form::label('harga_jual', 'Harga Jual', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('harga_jual', null, ['class' => 'form-control']) !!}
        {!! $errors->first('harga_jual', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('id_jenis_barang') ? 'has-error' : ''}}">
    {!! Form::label('id_jenis_barang', 'Jenis Barang', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {{ Form::select('id_jenis_barang', $jenisbarangs, null, array('class'=>'form-control', 'placeholder'=>'Pilih Jenis Barang')) }}
        <!-- {!! Form::number('id_jenis_barang', null, ['class' => 'form-control']) !!} -->
        {!! $errors->first('id_jenis_barang', '<p class="help-block">:message</p>') !!}
    </div>

</div>
@if(!isset($barang))
<div class="form-group {{ $errors->has('stok') ? 'has-error' : ''}}">
    {!! Form::label('stok', 'Stok', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('stok', null, ['class' => 'form-control', 'min'=>'0']) !!}
        {!! $errors->first('stok', '<p class="help-block">:message</p>') !!}
    </div>
</div>
@endif

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary']) !!}
    </div>
</div>
