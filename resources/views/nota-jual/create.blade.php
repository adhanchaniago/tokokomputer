@extends('layouts.app')
@section('title','Penjualan Barang')
@section('content')
    <div class="container">
        <div class="row">
          @include('admin.sidebar')
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Tambah Nota Jual</div>
                    <div class="panel-body">

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                         {!! Form::open(['url' => '/nota-jual', 'method' => 'post', 'class' => 'form-horizontal', 'files' => true]) !!}
                        <div class="row">
                                <label class="col-md-2" style="text-align: right;">No Nota</label>
                                
                                <label  class="col-md-3" style="text-align: left;">{{ $notajual }}</label>
                                <label class="col-md-2"></label>
                                <label class="col-md-2" style="text-align: right;">Tanggal</label>
                                
                                <label  class="col-md-3">{{$tgl}}</label>
                        </div>
                        <div class="row">
                            <label class="col-md-2" style="text-align: right;">Customer</label>
                            <div class="col-md-3">
                            <select class=" form-control" onchange='nohp(this)' required name="id_customer" id="id_customer">
                            <option value="">-- pilih customer --</option>
                                @foreach($customers as $cus)
                                    <option value="{{$cus->id}}">{{$cus->nama}}</option>
                                @endforeach
                            </select>
                            </div>
                            <label class="col-md-2"></label>
                            <label class="col-md-2" style="text-align: right;">Telp</label>
                            <div class="col-md-3">
                            <input type="text" name="telp" id='telp' class="form-control" required>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-2" style="text-align: right;">Status</label>
                            <div class="col-md-3">
                            <select class=" form-control" required name="status" id="status">
                                    <option value="belum bayar">Belum Bayar</option>
                                    <option value="lunas">Lunas</option>
                            </select>
                            </div>
                           
                        </div>
                                <hr>
                                <div class="table table-responsive">
                                      <table class="table">
                                        <thead>
                                           
                                            <th>Barang</th>
                                            <th>Stok</th>
                                            <th>Qty</th>
                                            <th>Harga</th>
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
                                          
                                           
                                        </tfoot>

                                    </table>
                                    <hr>
                                    <table class="table">
                                        <thead>
                                           
                                            <th>Paket</th>
                                            <th>Qty</th>
                                            <th>Harga</th>
                                            <th>Total</th>
                                            <th>Detail</th>
                                            <th>Aksi</th>                                          
                                        </thead>     
                                        <input type="hidden" name="nopaket" id="nopaket" value="0">
                                                                         
                                        <tbody id='detailpaket'>
                                            
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                             
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td><a href='#' class='btn btn-default' id='tambahpaket' align='right'> Tambah </a></td>
                                              
                                            </tr>
                                          
                                         
                                           
                                        </tfoot>

                                    </table>
                                     <table class="table">
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
                                                        <!-- <option value="kredit">Kredit</option> -->
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr  class="bayar" id="bank">
                                               
                                               
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
                                            <tr class="bayar"  id="norek">
                                                <td></td>
                                                <td></td>
                                                <td align="right">No. Rekening</td>
                                                <td>
                                                    <input type="text" name="norek" class='form-control'>
                                                </td>
                                                 <td></td>
                                            </tr>
                                            <tr class="bayar"  id="pengirim">
                                                <td></td>
                                                <td></td>
                                                <td align="right">Pengirim</td>
                                                <td>
                                                    <input type="text" name="pengirim"  class='form-control'>
                                                </td>
                                                 <td></td>
                                            </tr>
                                             <tr>
                                                <td></td>
                                                <td><a href="{{url('nota-jual')}}" class="btn btn-warning">Kembali</a></td>
                                                <td></td>
                                                <td><button class="btn btn-default"> Simpan </button></td>
                                                <td></td>
                                            </tr>
                                        </table>
                                </div>
                              
                            {!! Form::close() !!}

                 
<script type="text/javascript"> 
 $(document).ready( function ()
{
    $('#tambah').click(function(){
        var itung=$("#no").val();
        itung++;
        var baris = "<tr  id='no"+itung+"'>"+
                                                "<td>"+
                                                    "<select id='barang"+itung+"' name='barang[]' class='barang form-control' onchange='getHarga("+itung+")'>"+"<option>-- pilih barang --</option>"+
                                                        @foreach ($barangs as $item)
                                                           "<option value='{{ $item->id }}'> {{$item -> nama}}</option>"+
                                                        @endforeach
                                                    "</select>"+
                                                "</td>"+
                                                "<td><input type='number' name='stok[]' class='form-control' id='stok"+itung+"' min='1' value='1' readonly></td>"+
                                                "<td><input type='number' name='qty[]' class='qty form-control' id='qty"+itung+"' min='1'  onchange='getTotal("+itung+")'></td>"+
                                                "<td ><input type='number' step='any' name='price[]' id='price"+itung+"' class='form-control' onchange='getTotal("+itung+")'></td>"+
                                                "<td><input type='number' readonly name='total[]' id='total"+itung+"' class='form-control'></td>"+
                                                "<td width='5%' ><a style='background-color:#fffff; font-weight:bold; color:red;' id='"+itung+"'  onclick='hapus(this,event)' class='form-control btn btnhapus' >X</a></td>"
                                                "</tr>";
        $('#detail').append(baris);
        $('#no').val(itung);
        // $('#min'+itung).attr('min')
       
    });
     $('#tambahpaket').click(function(){
        var itung=$("#nopaket").val();
        itung++;
        var baris = "<tr  id='nopaket"+itung+"'>"+
                                                "<td>"+
                                                    "<input type='hidden' id='barangpaket"+itung+"' name='barangpaket"+itung+"' value=''>"+
                                                    "<input type='hidden' id='qtybarangpaket"+itung+"' name='qtybarangpaket"+itung+"' value=''>"+
                                                    "<input type='hidden' id='pricebarangpaket"+itung+"' name='pricebarangpaket"+itung+"' value=''>"+
                                                    "<select id='paket"+itung+"' name='paket[]' class='barang form-control' onchange='getHargapaket("+itung+")'>"+"<option value=''>-- pilih paket --</option>"+
                                                        "<option value='custom'>Custom Paket</option>"+
                                                        @foreach ($pakets as $item)
                                                           "<option value='{{ $item->id }}'> {{$item->nama}}</option>"+
                                                        @endforeach
                                                    "</select>"+
                                                "</td>"+
                                                "<td><input type='number' name='qtypaket[]' class='qty form-control' id='qtypaket"+itung+"' min='0' value='0' onchange='getTotalpaket("+itung+")'></td>"+
                                                "<td ><input type='number' step='any' name='pricepaket[]' id='pricepaket"+itung+"' class='form-control' onchange='getTotalpaket("+itung+")'></td>"+
                                                "<td><input type='number' readonly name='total[]' id='totalpaket"+itung+"' class='form-control'></td>"+
                                                "<td id='det"+itung+"'></td>"+
                                                "<td width='5%' ><a style='background-color:#fffff; font-weight:bold; color:red;' id='paket"+itung+"'  onclick='hapuspaket("+itung+",event)' class='form-control btn btnhapus' >X</a></td>"
                                                "</tr>";
        $('#detailpaket').append(baris);
        $('#nopaket').val(itung);
    });


     $('#tambahdetpaket').click(function(){
        var itung=$("#nobardetail").val();
        itung++;
        var baris = "<tr  id='nobardetail"+itung+"'>"+
                                                "<td>"+

                                                    "<select id='barangdet"+itung+"' name='barangdet[]' class='barang form-control' onchange='getHargaDet("+itung+")'>"+"<option>-- pilih barang --</option>"+
                                                        @foreach ($barangs as $item)
                                                           "<option value='{{ $item->id }}'> {{$item -> nama}}</option>"+
                                                        @endforeach
                                                    "</select>"+
                                                "</td>"+
                                                "<td><input type='number' name='qtydet[]' class='qty form-control' id='qtydet"+itung+"' min='0' value='0' onchange='getTotaldet("+itung+")'></td>"+
                                               "<td><input type='number' min='0' class='form-control' name='pricedet[]' id='pricedet"+itung+"' ></td>"+
                                                "<td width='5%' ><a style='background-color:#fffff; font-weight:bold; color:red;' id='det"+itung+"'  onclick='hapusdet("+itung+",event)' class='form-control btn btnhapus' >X</a></td>"
                                                "</tr>";
        $('#datapaket').append(baris);
        $('#nobardetail').val(itung);
    });

  

    
    $('#bank').hide();
    $('#pengirim').hide();
    $('#norek').hide();
});

function hapus(param, e){
    e.preventDefault()
    $('#no'+param.id).remove();
    getGrandTotal()

    // return false;
}

function hapuspaket(param, e){
    e.preventDefault()
    $('#nopaket'+param).remove();

     var url="../hapuscustom/"+param;

    $.get(url, function(r) {
            // alert(r)
        });
    getGrandTotal()

    // return false;
}

function hapusdet(param,e){
    e.preventDefault()
    
    $('#nobardetail'+param).remove();
    getGrandTotaldet()

    // return false;
}

function getTotal(no){
    var qty=$("#qty"+no).val();
    
    var harga=$('#price'+no).val();
    var total= qty*harga;
    $('#total'+no).val(total);
    getGrandTotal();
}

function getTotalpaket(no){
    var qty=$("#qtypaket"+no).val();
    
    var harga=$('#pricepaket'+no).val();
    var total= qty*harga;
    // alert(total)
    $('#totalpaket'+no).val(total);
    getGrandTotal();
}

function getTotaldet(no){
    
    getGrandTotaldet();
}

function getGrandTotal(){
    var arraytotal = document.getElementsByName('total[]');
    var tot=0;
    for(var i=0;i<arraytotal.length;i++){
        if(parseInt(arraytotal[i].value))
            tot += parseInt(arraytotal[i].value);
    }
    document.getElementById('grandTot').value = tot;
}
function getGrandTotaldet(){
    var arrayharga = document.getElementsByName('pricedet[]');
    var arrayqty=document.getElementsByName('qtydet[]');
    var tot=0;
    for(var i=0;i<arrayharga.length;i++){
        if(parseInt(arrayharga[i].value)&&parseInt(arrayqty[i].value)){
            tot += parseInt(arrayharga[i].value)*parseInt(arrayqty[i].value);
        }
    }
    document.getElementById('grandTotdet').value = tot;
}

function nohp(param){
    var pilih=$('#id_customer').val()
    var id_cus=[
        @foreach ($customers as $item)
            [ "{{ $item->id }}" ], 
        @endforeach
    ];
    var telp=[
        @foreach ($customers as $item)
            [ "{{ $item->telp }}" ], 
        @endforeach
    ];

    for(var i=0;i<id_cus.length;i++){
        if(id_cus[i]==pilih){
            $('#telp').val(telp[i]);
            //alert(price);
            //price[itung].html(harga[i]);
        }
    }
}

function getHarga(no)
{
    var option = $("#barang"+no).val();

    var nomer=no;
    /* setting input box value to selected option value */
    var kodebarang = [
    @foreach ($barangs as $item)
        [ "{{ $item->id }}" ], 
    @endforeach
    ];
    var harga = [
    @foreach ($barangs as $item)
        [ "{{ $item->harga_jual }}" ], 
    @endforeach
    ];

    var stok = [
    @foreach ($barangs as $item)
        [ "{{ $item->stok_baik }}" ], 
    @endforeach
    ];
    
        for(var i=0;i<kodebarang.length;i++){
            if(kodebarang[i]==option){
                $('#price'+no).val(harga[i]);
                $('#stok'+no).val(stok[i])
            }
        }
    
}

function getHargaDet(no)
{
    var option = $("#barangdet"+no).val();

    var nomer=no;
    /* setting input box value to selected option value */
    var kodebarang = [
    @foreach ($barangs as $item)
        [ "{{ $item->id }}" ], 
    @endforeach
    ];
    var harga = [
    @foreach ($barangs as $item)
        [ "{{ $item->harga_jual }}" ], 
    @endforeach
    ];

    var stok = [
    @foreach ($barangs as $item)
        [ "{{ $item->stok }}" ], 
    @endforeach
    ];
    
        for(var i=0;i<kodebarang.length;i++){
            if(kodebarang[i]==option){
                $('#pricedet'+no).val(harga[i]);
                $('#qtydet'+no).attr({
                    min:1
                })
            }
        }
    
}
function getHargapaket(no)
{
    var option = $("#paket"+no).val();

    var nomer=no;
    /* setting input box value to selected option value */
    var kodebarang = [
    @foreach ($pakets as $item)
        [ "{{ $item->id }}" ], 
    @endforeach
    ];
    var harga = [
    @foreach ($pakets as $item)
        [ "{{ $item->total_harga_jual }}" ], 
    @endforeach
    ];

    var stok = [
    @foreach ($pakets as $item)
        [ "{{ $item->stok }}" ], 
    @endforeach
    ];
    if(option&&option!='custom'){
        for(var i=0;i<kodebarang.length;i++){
            if(kodebarang[i]==option){
                $('#pricepaket'+no).val(harga[i]);
                $('#qtypaket'+no).attr({
                    min:1
                })
                $("#det"+no).html("")
                // $("#det"+no).html("<button value='"+no+"' class='btn btn-primary btn-xs openedit' data-title='Lihat' data-toggle='modal' data-target='#myModal' ><span data-placement='top' data-toggle='tooltip' title='Lihat'><span class='fa fa-eye'></span></button><span>")
                //price[itung].html(harga[i]);
            }
        }
    }else if(option=='custom'){
        $('#qty'+no).attr({
            min:1
        })
        $("#det"+no).html("<button value='"+no+"' class='btn btn-primary btn-xs openedit' data-title='Lihat' data-toggle='modal' data-target='#myModal' onclick='setmodaldialog("+no+",event)' ><span data-placement='top' data-toggle='tooltip' title='Lihat'><span class='fa fa-eye'></span></button><span>")
    }else{
          $("#det"+no).html("")
    }

}

function setmodaldialog(no,e) {
    e.preventDefault()
                document.getElementById('grandTotdet').value =0
             document.getElementById('totaljualdet').value =0
        $('#barispaket').val(no)
         $('#datapaket').html("")
        var url="../tampilcustom/"+no;
        $.get(url, function(r) {
            // alert(r)
           
          $('#datapaket').html(r)
        });
        url="../hitungtotal/"+no;
        $.get(url, function(r) {
            nilai=r.split('_')

          $('#grandTotdet').val(parseInt(nilai[2]))
             $('#totaljualdet').val(parseInt(nilai[1]))
        });

        url="../getjumitung/"+no;
        $.get(url, function(r) {
            // alert(r)
           
          $('#nobardetail').val(r)
        });
       
}

function simpanPaket(){
    // e.preventDefault()
    var baris=$('#barispaket').val();
    var nobar=$('#nobardetail').val();
    var arraybarang=document.getElementsByName('barangdet[]');
    var arrayharga = document.getElementsByName('pricedet[]');
    var arrayqty=document.getElementsByName('qtydet[]');
    var totjual=document.getElementById('totaljualdet').value
    // // alert()
        var barangdet=''
        var qtydet=''
        var pricedet=''
        var tot=0;

    for(var i=0;i<arrayharga.length;i++){

        if(i>0){
            barangdet+="|"+parseInt(arraybarang[i].value)
            qtydet+="|"+parseInt(arrayqty[i].value)
            pricedet+="|"+parseInt(arrayharga[i].value)
        }else{
            barangdet+=parseInt(arraybarang[i].value)
            qtydet+=parseInt(arrayqty[i].value)
            pricedet+=parseInt(arrayharga[i].value)

        }
    }

    // alert(barangdet)

    var url="../storecustom/"+baris+"/"+barangdet+"/"+qtydet+"/"+pricedet+"/"+totjual
    $.get(url, function(r) {
      // alert(r)
    });

    $('#barangpaket'+baris).val(barangdet)
    $('#qtybarangpaket'+baris).val(qtydet)
    $('#pricebarangpaket'+baris).val(pricedet)

    $('#pricepaket'+baris).val(totjual)    


     $('#myModal').modal('hide');

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



<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
     <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Detail Paket</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="post" enctype="multipart/form-data">
                   <input type="hidden" name="iddata" id='iddata' value="">
                   <!-- <input type="hidden" name="gambar" value="<?php echo isset($data[2])?$data[2]:''; ?>"> -->
                    <div class="box-body">
                         <table class="table">
                                        <thead>
                                            <th>Barang</th>
                                            <th>Qty</th>
                                            <th>Harga</th>
                                            <th>Aksi</th>
                                        </thead>     
                                        <input type="hidden" name="nobardetail" id="nobardetail" value="0">
                                        <input type="hidden" name="jumdet" id="jumdet" value="0">
                                        <input type="hidden" name="barispaket" id="barispaket" value="">                                   
                                        <tbody id='datapaket'>
                                            
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                             
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td><a href='#' class='btn btn-default' id='tambahdetpaket' align='right'> Tambah </a></td>
                                              
                                            </tr>
                                            <tr>
                                            
                                                <td></td>
                                                
                                                <td align="right">Total Harga Beli</td>
                                                <td>
                                                    <input type="number" class='form-control' required name="total_harga_asli" id="grandTotdet">
                                                </td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                
                                               
                                                <td></td>
                                               
                                                <td align="right">Total Harga Jual</td>
                                                <td>
                                                    <input type="number" class='form-control' required name="total_harga_jual" id="totaljualdet">
                                                </td>
                                                 <td></td>
                                            </tr>
                                        
                                        </tfoot>
                                    </table>
                        
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <a onclick="simpanPaket()"  class="btn btn-primary pull-right" id='btnsave'>Simpan</a>
                    </div>
                    <!-- /.box-footer -->
                </form>
            </div>
            </div>
    </div>
</div>







                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection