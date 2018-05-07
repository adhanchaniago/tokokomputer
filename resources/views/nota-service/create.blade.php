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
                            setlocale(LC_TIME, 'IND');
                            
                            $tgl= strftime('%d %B %Y', strtotime(date('Y-m-d')));
                        @endphp

                         {!! Form::open(['url' => '/nota-service', 'method' => 'post', 'class' => 'form-horizontal', 'files' => true]) !!}
                        <div class="row form-group">
                                <label class="col-md-2" style="text-align: right;">No Nota</label>
                                
                                <label  class="col-md-3" style="text-align: left;">{{ $notaservice }}</label>
                                <label class="col-md-2"></label>
                                <label class="col-md-2" style="text-align: right;">Tanggal</label>
                                
                                <label  class="col-md-3"> {{$tgl}} {{date('H:i')}} <input type="hidden" id="tgl" value="{{date('Y-m-d')}}" > </label>
                        </div>
                        <div class="row form-group">
                            <label class="col-md-2" style="text-align: right;">Customer</label>
                            <div class="col-md-3">
                            <select class=" form-control" name="id_customer" id="id_customer">
                                @foreach($customers as $cus)
                                    <option value="{{$cus->id}}">{{$cus->nama}}</option>
                                @endforeach
                            </select>
                            </div>
                            <label class="col-md-2"></label>
                            <label class="col-md-2" style="text-align: right;">Tanggal Selesai</label>
                            <div class="col-md-3">
                            <input type="date" name="tgl_selesai" id='tgl_selesai' class="form-control" value="">
                            </div>
                        </div>
                         <div class="row form-group">
                            <label class="col-md-2" style="text-align: right;">Catatan</label>
                            <div class="col-md-3">
                            <textarea name="catatan" class="form-control" rows="3" style="resize: none"></textarea>
                            </div>
                            <label class="col-md-2"></label>
                            <label class="col-md-2" style="text-align: right;">Status</label>
                            <div class="col-md-3">
                            <select class=" form-control" name="status" onchange="ubahjenis(this)" id="status">
                                <option value="belum selesai">Belum Selesai</option>
                                <option value="selesai">Selesai</option>
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
                                            <th>Jasa</th>
                                            <th>Total</th>
                                            <th>Aksi</th>                                          
                                        </thead>     
                                        <input type="hidden" name="no" id="no" value="0">
                                        <input type="hidden" name="jum" id="jum" value="0">                                   
                                        <tbody id='detail'>
                                            
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
                                        <input type="hidden" name="nosperpart" id="nosperpart" value="0">
                                        <tbody id="detailsperpart">
                                            
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

                                        <table class="table table-responsive">
                                        <tfoot>

                                            
                                            <tr>
                                            
                                                <td></td>
                                                <td></td>
                                                <td align="right">GRAND TOTAL</td>
                                                <td>
                                                    <input type="text" class='form-control' readonly value=0 name="grandTot" id="grandTot">
                                                </td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                
                                               
                                                <td></td>
                                                <td></td>
                                                <td align="right">Jenis Pembayaran</td>
                                                <td>
                                                    <select name="pembayaran" required class="form-control" id="pembayaran" onChange="getRekening()">
                                                        <option value="">-- Pilih jenis pembayaran --</option>
                                                        <option value="tunai">Tunai</option>
                                                        <option value="transfer">Transfer</option>
                                                    </select>
                                                </td>
                                            </tr>
                                           <tr  name="bank" id="bank">
                                               
                                               
                                                <td></td>
                                                <td></td>
                                                <td align="right">Nama Bank</td>
                                                <td>
                                                    <select name="bank" class="form-control" id="bank" >
                                                     <option value="">-- Pilih Bank --</option>
                                                    <option value="Mandiri">Mandiri</option>
                                                    <option value="BNI">BNI</option>
                                                    </select>
                                                </td>
                                                 <td></td>
                                            </tr>
                                            <tr  id="norek">
                                                <td></td>
                                                <td></td>
                                                <td align="right">No. Rekening</td>
                                                <td>
                                                    <input type="text" name="norek"  class='form-control'>
                                                </td>
                                                 <td></td>
                                            </tr>
                                            <tr id="pengirim">
                                                <td></td>
                                                <td></td>
                                                <td align="right">Pengirim</td>
                                                <td>
                                                    <input type="text" name="pengirim" class='form-control'>
                                                </td>
                                                 <td></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td><a href="{{url('nota-beli')}}" class="btn btn-warning">Kembali</a></td>
                                                <td></td>
                                                <td><button class="btn btn-default"> Simpan </button></td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                              
                            {!! Form::close() !!}

                 
<script type="text/javascript"> 
 $(document).ready( function ()
{
    $('#norek').hide();
    $('#sperpart').hide()
    $('#bank').hide();
    $('#pengirim').hide();
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
                                                "<td ><input type='number' step='any' name='price[]' id='price"+itung+"' onkeyup='getTotal("+itung+")' class='form-control' min='0' onchange='getTotal("+itung+")'></td>"+
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
    
});

function hapus(param, e){
    e.preventDefault()
    $('#no'+param.id).remove();
    getGrandTotal()

    // return false;
}

function ubahjenis(param){
    if(param.value=='selesai'){
        var tgl=$('#tgl').val()
        $('#tgl_selesai').val(tgl)
        $('#tgl_selesai').attr('readonly',true)
        
    }else{
         $('#tgl_selesai').removeAttr('readonly')
          $('#tgl_selesai').val('')
         $('#pembayaran').removeAttr('required');

    }
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

function ubahgaransi(param){
    if(param.value=="tidak garansi"){
        document.getElementById('tampilsperpart').disabled=false
    }else{
        document.getElementById('tampilsperpart').disabled=true
        $('#sperpart').hide()
    }
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

function hapussperpart(param,e){
    e.preventDefault()
    $('#nosperpart'+param).remove();
    getGrandTotal()
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