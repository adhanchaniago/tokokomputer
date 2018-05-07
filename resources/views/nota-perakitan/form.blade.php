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
</div><div class="form-group {{ $errors->has('biaya') ? 'has-error' : ''}}">
    {!! Form::label('biaya', 'Biaya', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('biaya', null, ['class' => 'form-control']) !!}
        {!! $errors->first('biaya', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary']) !!}
    </div>
</div>
