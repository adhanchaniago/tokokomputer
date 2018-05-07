@extends('layouts.app')
@section('title','Pembelian Barang')
@section('content')
    <div class="container">
        <div class="row">  
        @include('admin.sidebar')
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Tambah Nota Service</div>
                    <div class="panel-body">

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                        @php
                        setlocale(LC_ALL, 'IND');
                        $tgl=strftime('%d %B %Y',strtotime($notaservice->tgl));
                        @endphp
                         {!! Form::open(['url' => ['/nota-service',$notaservice->id], 'method' => 'patch', 'class' => 'form-horizontal', 'files' => true]) !!}
                        <div class="row form-group">
                                <label class="col-md-2" style="text-align: right;">No Nota</label>
                                
                                <label  class="col-md-3" style="text-align: left;">{{ $notaservice->id }}</label>
                                <label class="col-md-2"></label>
                                <label class="col-md-2" style="text-align: right;">Tanggal</label>
                                
                                <label  class="col-md-3"> {{$tgl}} {{date('H:i', strtotime($notaservice->tgl))}} </label>
                        </div>
                        <div class="row form-group">
                            <label class="col-md-2" style="text-align: right;">Customer</label>
                            <div class="col-md-3">
                            <select class=" form-control" name="id_customer" id="id_customer">
                                @foreach($customers as $cus)
                                    @if($notaservice->id_customer==$cus->id)
                                    <option value="{{$cus->id}}" selected>{{$cus->nama}}</option>
                                    @else
                                    <option value="{{$cus->id}}" selected>{{$cus->nama}}</option>
                                    @endif
                                @endforeach
                            </select>
                            </div>
                            <label class="col-md-2"></label>
                            <label class="col-md-2" style="text-align: right;">Tanggal Selesai</label>
                            <div class="col-md-3">
                            <input type="date" name="tgl_selesai" id='tgl_selesai' class="form-control" value="{{$notaservice->tgl_selesai}}">
                            </div>
                        </div>
                         <div class="row form-group">
                            <label class="col-md-2" style="text-align: right;">Catatan</label>
                            <div class="col-md-3">
                            <textarea name="catatan" class="form-control" rows="3" style="resize: none">{{$notaservice->catatan}}</textarea>
                            </div>
                            <label class="col-md-2"></label>
                            <label class="col-md-2" style="text-align: right;">Detail Service</label>
                            <div class="col-md-3">
                              <select class=" form-control" name="status" onchange="ubahjenis(this)" id="status">
                                <option value="belum selesai" {{ ($notaservice->status=="belum selesai")?'selected':'' }}>Belum Selesai</option>
                                <option value="selesai" {{ ($notaservice->status=="selesai")?'selected':'' }}>Selesai</option>
                            </select> 
                            </div>
                        </div>

                         <div class="row form-group">
                           
                            <label class="col-md-2" style="text-align: right;">Status Garansi</label>
                            <div class="col-md-3">
                              <select class=" form-control" name="status_garansi" onchange="ubahgaransi(this)" id="status_garansi">
                                <option value="tidak garansi">Tidak Garansi</option>
                                <option value="garansi">Garansi</option>
                            </select> 
                            </div>
                        </div>
                                <hr>
                                <div class="table table-responsive">
                                      <table class="table">
                                        <thead>
                                           
                                            <th>Barang</th>
                                            <th>Qty</th>
                                            <th>Keterangan</th>
                                            <th>Harga Service</th>
                                            <th>Total</th>
                                            <th>Aksi</th>                                          
                                        </thead>     
                                         @php
                                        $itung=1;
                                        $grantot=0;
                                      
                                        @endphp
                                        <input type="hidden" name="no" id="no" value="{{$detailnota->count()}}">
                                        <input type="hidden" name="jum" id="jum" value="0">                                   
                                        <tbody id='detail'>
                                        @php
                                        $itung=1;
                                        $grandtot=0;
                                        @endphp
                                        @foreach($detailnota as $detail)
                                            <tr  id='no{{$itung}}'>
                                                <td>
                                                    <input type='text' required id='barang{{$itung}}' name='barang[]' class='barang form-control' value="{{$detail->barang}}">
                                                </td>
                                                <td><input type='number' name='qty[]' class='qty form-control' id='qty{{$itung}}' min='0' value='{{$detail->qty}}' onchange='getTotal({{$itung}})' onkeyup='getTotal({{$itung}})'></td>
                                                 <td>
                                                    <textarea name='keterangan[]' required id='keterangan{{$itung}}' class='form-control' rows='3' style='resize: none'>{{$detail->keterangan}}</textarea>
                                                </td>
                                                <td ><input type='number' step='any' name='price[]' id='price{{$itung}}' onkeyup='getTotal({{$itung}})' value="{{$detail->harga}}" class='form-control' onchange='getTotal({{$itung}}'></td>
                                                "<td><input type='number' readonly name='total[]' value="{{$detail->sub_total}}" id='total{{$itung}}' class='form-control'></td>
                                                <td width='5%' ><a style='background-color:#fffff; font-weight:bold; color:red;' id='{{$itung}}'  onclick='hapus(this,event)' class='form-control btn btnhapus' >X</a></td>
                                                </tr>
                                        @php
                                        $itung++;
                                        $grandtot+=$detail->qty*$detail->harga;
                                        @endphp
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                             
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td><a href='#' class='btn btn-default' id='tambah' align='right'> Tambah </a></td>
                                              
                                            </tr>
                                            <tr> <td colspan="6"> <input type="checkbox" id="tampilsperpart"> Pakai Sperpart </td></tr>
                                        </tfoot>
                                    </table>

                                     <table class="table table-responsive" id="sperpart">
                                         <thead>
                                           
                                            <th>Barang</th>
                                            <th>Qty</th>
                                            <th>Harga</th>
                                            <th>Total</th>
                                            <th>Aksi</th>                                          
                                        </thead>     
                                        <input type="hidden" name="nosperpart" id="nosperpart" value="{{$sperparts->count()}}">
                                        <tbody id="detailsperpart">
                                        @php
                                        $itung=1;
                                        @endphp
                                        @foreach($sperparts as $detail)
                                            <tr  id='nosperpart{{$itung}}'>
                                                <td>
                                                    <select id='sperpart{{$itung}}' name='sperpart[]' class='barang form-control' onchange='getHarga({{$itung}})'>"+"<option>-- pilih barang --</option>
                                                        @foreach ($barangs as $item)
                                                            @if($detail->id_barang==$item->id)
                                                            <option value='{{ $item->id }}' selected> {{$item -> nama}}</option>
                                                            @else
                                                           <option value='{{ $item->id }}'> {{$item -> nama}}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td><input type='number' name='qtysperpart[]' class='qty form-control' id='qtysperpart{{$itung}}' min='0' value="{{$detail->qty}}" onchange='getTotal({{$itung}})'></td>
                                                <td ><input type='number' value="{{$detail->harga}}" step='any' name='pricesperpart[]' id='pricesperpart{{$itung}}' class='form-control' onchange='getTotal({{$itung}})'></td>
                                                <td><input type='number' value="{{$detail->sub_total}}"  readonly name='totalsperpart[]' id='totalsperpart{{$itung}}' class='form-control'></td>
                                                <td width='5%' ><a style='background-color:#fffff; font-weight:bold; color:red;' id='btnsperpart{{$itung}}'  onclick='hapussperpart({{$itung}},event)' class='form-control btn btnhapus' >X</a></td>
                                                </tr>
                                        @php
                                        $itung++;
                                        $grandtot+=$detail->harga*$detail->qty;
                                        @endphp
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td><a href='#' class='btn btn-default' id='tambahsperpart' align='right'> Tambah </a></td>
                                              
                                            </tr>
                                        </tfoot>
                                    </table>


                                    <table align="right">
                                            <tr>
                                                <td align="right">GRAND TOTAL </td>
                                                <td>
                                                    <input type="text" class='form-control' readonly value='{{$grandtot}}' name="grandTot" id="grandTot">
                                                </td>
                                            </tr>
                                            <tr> 
                                                <td align="right">Jenis Pembayaran </td>
                                                <td>
                                                    <select name="pembayaran" required class="form-control" id="pembayaran" onChange="getRekening()">
                                                        <option value="">-- Pilih jenis pembayaran --</option>
                                                        <option value="tunai">Tunai</option>
                                                        <option value="transfer" >Transfer</option>
                                                    </select>
                                                </td>
                                            </tr>
                                          
                                          <tr id="bank">
                                                <td align="right">Nama Bank </td>
                                                <td>
                                                    <select name="bank" class="form-control" id="bank" >
                                                     <option value="">-- Pilih Bank --</option>
                                                    <option value="Mandiri">Mandiri</option>
                                                    <option value="BNI">BNI</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr   id="norek">
                                                <td colspan="5" align="right">No. Rekening </td>
                                                <td>
                                                    <input type="text" name="norek" value="{{$notaservice->no_rek}}" class='form-control'>
                                                </td>
                                            </tr>
                                            <tr  id="pengirim">
                                                <td align="right">Pengirim </td>
                                                <td>
                                                    <input type="text"  name="pengirim" value="{{$notaservice->pengirim}}" class='form-control'>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><a href="{{url('nota-service')}}" class="btn btn-warning">Kembali</a></td>
                                                <td><button class="btn btn-default"> Simpan </button></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                              
                            {!! Form::close() !!}

                 
<script type="text/javascript"> 
 $(document).ready( function ()
{
    document.getElementById('pembayaran').value='{{$notaservice->pembayaran}}'
    // alert({{$notaservice->pembayaran}})
    $('#sperpart').hide()
    $('#tambah').click(function(){
        var itung=$("#no").val();
        itung++;
        var baris = "<tr  id='no"+itung+"'>"+
                                                "<td>"+
                                                    "<input type='text' required id='barang"+itung+"' name='barang[]' class='barang form-control'>"+
                                                "</td>"+
                                                "<td><input type='number' name='qty[]' class='qty form-control' id='qty"+itung+"' min='0' value='0' onchange='getTotal("+itung+")' onkeyup='getTotal("+itung+")'></td>"+
                                                 "<td>"+
                                                    "<textarea name='keterangan[]' required id='keterangan"+itung+"' class='form-control' rows='3' style='resize: none'></textarea>"+
                                                "</td>"+
                                                "<td ><input type='number' step='any' name='price[]' id='price"+itung+"' onkeyup='getTotal("+itung+")' min='0' class='form-control' onchange='getTotal("+itung+")'></td>"+
                                                "<td><input type='number' readonly name='total[]' id='total"+itung+"' class='form-control'></td>"+
                                                "<td width='5%' ><a style='background-color:#fffff; font-weight:bold; color:red;' id='"+itung+"'  onclick='hapus(this,event)' class='form-control btn btnhapus' >X</a></td>"
                                                "</tr>";
        $('#detail').append(baris);
        $('#no').val(itung);
    });


    $('#tambahsperpart').click(function(){
        var itung=$("#nosperpart").val();
        itung++;
        var baris = "<tr  id='nosperpart"+itung+"'>"+
                                                "<td>"+
                                                    "<select id='sperpart"+itung+"' name='sperpart[]' class='sperpart form-control' required onchange='getHarga("+itung+")'>"+"<option value=''>-- pilih barang --</option>"+
                                                        @foreach ($barangs as $item)
                                                           "<option value='{{ $item->id }}'> {{$item -> nama}}</option>"+
                                                        @endforeach
                                                    "</select>"+
                                                "</td>"+
                                                "<td><input type='number' name='qtysperpart[]' class='qtysperpart form-control' required id='qtysperpart"+itung+"' min='0' value='0' onchange='getTotalSperpart("+itung+")'></td>"+
                                                "<td ><input type='number' step='any' name='pricesperpart[]' id='pricesperpart"+itung+"' required class='form-control' onchange='getTotalSperpart("+itung+")'></td>"+
                                                "<td><input type='number' readonly name='totalsperpart[]' id='totalsperpart"+itung+"' class='form-control'></td>"+
                                                "<td width='5%' ><a style='background-color:#fffff; font-weight:bold; color:red;' id='btnsperpart"+itung+"'  onclick='hapussperpart("+itung+",event)' class='form-control btn btnhapus' >X</a></td>"
                                                "</tr>";
        $('#detailsperpart').append(baris);
        $('#nosperpart').val(itung);
    });

    $('#tampilsperpart').click(function(){
        if(document.getElementById('tampilsperpart').checked){
            $('#sperpart').show()
        }else{
            $('#sperpart').hide()
        }
    })




     $('#norek').hide();
    $('#bank').hide();
    $('#pengirim').hide();

    @if($notaservice->nama_bank)
    $('#norek').show();
    $('#bank').show();
    $('#pengirim').show();

    var aaa='{{$notaservice->nama_bank}}'
    document.getElementById('bank').value=aaa
    aaa='{{$notaservice->pembayaran}}'
    document.getElementById('pembayaran').value=aaa
    document.getElementById('status_garansi').value='{{$notaservice->status_garansi}}'

    @endif

    @if($sperparts->count())
        $('#sperpart').show()
    @endif
});

function ubahgaransi(param){
    if(param.value=="tidak garansi"){
        document.getElementById('tampilsperpart').disabled=false
    }else{
        document.getElementById('tampilsperpart').disabled=true
        $('#sperpart').hide()
    }
}

function hapus(param, e){
    e.preventDefault()
    $('#no'+param.id).remove();
    getGrandTotal()

    // return false;
}

function hapussperpart(param,e){
    e.preventDefault()
    $('#nosperpart'+param).remove();
    getGrandTotal()
}

function getTotal(no){
    var qty=$("#qty"+no).val();
    
    var harga=$('#price'+no).val();
    var total= qty*harga;
    $('#total'+no).val(total);
    getGrandTotal();
}

function getTotalSperpart(no){
    var qty=$("#qtysperpart"+no).val();

    var harga=$('#pricesperpart'+no).val();
    var total= qty*harga;
    $('#totalsperpart'+no).val(total);
    getGrandTotal();
}


function getGrandTotal(){
    var arraytotal = document.getElementsByName('total[]');
    var tot=0;
    for(var i=0;i<arraytotal.length;i++){
        if(parseInt(arraytotal[i].value))
            tot += parseInt(arraytotal[i].value);
    }

     var arraytotal=document.getElementsByName('totalsperpart[]');
    if(arraytotal){
        for(var i=0;i<arraytotal.length;i++){
            if(parseInt(arraytotal[i].value))
                tot += parseInt(arraytotal[i].value);
        }
    }
    document.getElementById('grandTot').value = tot;
}



function getHarga(no)
    {
        var option = $("#sperpart"+no).val();
  
        var nomer=no;
        /* setting input box value to selected option value */
        var kodebarang = [
        @foreach ($barangs as $item)
            [ "{{ $item->id }}" ], 
        @endforeach
        ];
        var harga = [
        @foreach ($barangs as $item)
            [ "{{ $item->harga_beli_rata }}" ], 
        @endforeach
        ];
        for(var i=0;i<kodebarang.length;i++){
            if(kodebarang[i]==option){
                $('#pricesperpart'+no).val(harga[i]);
                //alert(price);
                //price[itung].html(harga[i]);
            }
        }
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
    }
 </script>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection