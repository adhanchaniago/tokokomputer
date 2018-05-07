<div class="form-group {{ $errors->has('tgl_bayar') ? 'has-error' : ''}}">
    {!! Form::label('tgl_bayar', 'Tgl Bayar', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::date('tgl_bayar', date('Y-m-d'), ['class' => 'form-control', 'readonly'=> true]) !!}
        {!! $errors->first('tgl_bayar', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('total_harga') ? 'has-error' : ''}}">
    {!! Form::label('total_harga', 'Total Harga', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('total_harga', null, ['class' => 'form-control','min'=>'10000', 'id'=>'tagihan']) !!}
        {!! $errors->first('total_harga', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('nonota_beli') ? 'has-error' : ''}}">
    {!! Form::label('nonota_beli', 'Nonota Beli', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
            @if(isset($notabayar))
            <input type="text" readonly name="id_nota_beli" value="{{$notabayar->id_nota_beli}}" class="form-control">
            @else
           <select name="id_nota_beli" class="form-control" onclick="setharga(this)" required>
           <option>--Pilih Nota Beli--</option>

               @foreach($notabelis as $notabeli)
                <option value="{{$notabeli->id}}"  >{{$notabeli->tgl}} - {{$notabeli->id}}</option>
               @endforeach
           </select>
           @endif
            {!! $errors->first('nonota_beli', '<p class="help-block">:message</p>') !!}
    </div>
    <input type="hidden" name="id_user" value="{{auth::user()->id}}">
    <input type="hidden" name="status">
</div><div class="form-group">
 {!! Form::label('catatan', 'Catatan', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
<textarea name="catatan" class="form-control" rows="3" style="resize: none;"></textarea>
    </div>
</div>
<div class="form-group">
 {!! Form::label('jenis', 'Jenis Pembayaran', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        <select name="pembayaran" required class="form-control" id="pembayaran" onChange="getRekening()">
            <option value="">-- Pilih jenis pembayaran --</option>
            <option value="tunai">Tunai</option>
            <option value="transfer">Transfer</option>
            <!-- <option value="kredit">Kredit</option> -->
        </select>
    </div>
</div>
<div class="form-group" id ="bank">
 {!! Form::label('bank', 'Nama Bank', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        <select name="bank" class="form-control" >
            <option value="">-- Pilih Bank --</option>
            <option value="Mandiri">Mandiri</option>
            <option value="BNI">BNI</option>
        </select>
    </div>
</div>
<div class="form-group" id ="norek">
 {!! Form::label('norek', 'No. Rekening', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
       <input type="text" name="norek" class='form-control'>
    </div>
</div>
<div class="form-group" id ="pengirim">
 {!! Form::label('pengirim', 'Pengirim', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        <input type="text" name="pengirim"  class='form-control'>
    </div>
</div>



<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Simpan', ['class' => 'btn btn-primary']) !!}
    </div>
</div>


<script type="text/javascript">
    function setharga(param){

        var id=param.value;
        var url="../settagihan/"+id
        $.get(url, function(data){
            $('#tagihan').attr({
                'min':10000,
                'max':data
            })
            $('#tagihan').val(data)
        })

    }
    function getRekening()
    {
        if($('#pembayaran').val()=='transfer'){
             $('#norek').show();
             $('#bank').show();
             $('#pengirim').show();
             $('#norek').attr('required', true);
             $('#bank').attr('required', true);
             $('#pengirim').attr('required', true);
        }
        else{
            $('#norek').removeAttr('required');
            $('#bank').removeAttr('required');
            $('#pengirim').removeAttr('required');
            $('#norek').hide();
            $('#bank').hide();
            $('#pengirim').hide();
        }
        if($('#pembayaran').val()=='kredit'){
            $('#jenis_bayar').val('utang');
             $('#jatuhtempo').removeAttr('readonly')
        }else{
            //$('#jenis_bayar').val('lunas');
            //  var tgl=$('#tgl').val()
            // $('#jatuhtempo').val(tgl)
            // $('#jatuhtempo').attr('readonly',true)
        }
    }
</script>
