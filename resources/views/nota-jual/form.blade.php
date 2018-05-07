<div class="form-group {{ $errors->has('nonota') ? 'has-error' : ''}}">
    {!! Form::label('nonota', 'Nonota', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('nonota', null, ['class' => 'form-control']) !!}
        {!! $errors->first('nonota', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('tgl') ? 'has-error' : ''}}">
    {!! Form::label('tgl', 'Tgl', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::date('tgl', null, ['class' => 'form-control']) !!}
        {!! $errors->first('tgl', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('jenis_pembayaran') ? 'has-error' : ''}}">
    {!! Form::label('jenis_pembayaran', 'Jenis Pembayaran', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('jenis_pembayaran', null, ['class' => 'form-control']) !!}
        {!! $errors->first('jenis_pembayaran', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('total_harga') ? 'has-error' : ''}}">
    {!! Form::label('total_harga', 'Total Harga', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('total_harga', null, ['class' => 'form-control']) !!}
        {!! $errors->first('total_harga', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('id_user') ? 'has-error' : ''}}">
    {!! Form::label('id_user', 'Id User', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('id_user', null, ['class' => 'form-control']) !!}
        {!! $errors->first('id_user', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary']) !!}
    </div>
</div>
