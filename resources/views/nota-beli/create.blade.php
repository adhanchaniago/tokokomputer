@extends('layouts.app')
@section('title','Pembelian Barang')
@section('content')
    <div class="container">
        <div class="row">  
        @include('admin.sidebar')
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Tambah Nota Pembelian</div>
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
                         {!! Form::open(['url' => '/nota-beli', 'method' => 'post', 'class' => 'form-horizontal', 'files' => true]) !!}
                        <div class="row form-group">
                                <label class="col-md-2" style="text-align: right;">No Nota</label>
                                
                                <label  class="col-md-3" style="text-align: left;">{{ $notabeli }}</label>
                                <label class="col-md-2"></label>
                                <label class="col-md-2" style="text-align: right;">Tanggal</label>
                                
                                <label  class="col-md-3" style="text-align: left;">{{$tgl}} <input type="hidden" name="tgl" id='tgl' value="{{date('Y-m-d')}}"> </label>
                        </div>
                          <div class="row form-group">
                            <label class="col-md-2" style="text-align: right;">Jatuh Tempo</label>
                            <div class="col-md-3">
                            <input type="date" name="jatuhtempo" id='jatuhtempo' class="form-control" readonly value="{{date('Y-m-d')}}">
                            </div>
                            <label class="col-md-2"></label>
                             <label class="col-md-2" style="text-align: right;">Jam</label>
                             <label  class="col-md-3" style="text-align: left;">{{  date('H:i')}}</label>
                        </div>
                        <div class="row form-group">
                            <label class="col-md-2" style="text-align: right;">Supplier</label>
                            <div class="col-md-3">
                            <select class=" form-control" onchange="nohp(this)" required name="id_supplier" id="id_supplier">
                                <option value="">-- Pilih Supplier --</option>
                                @foreach($suppliers as $sup)
                                    <option value="{{$sup->id}}">{{$sup->nama}}</option>
                                @endforeach
                            </select>
                            </div>
                            <label class="col-md-2"></label>
                             <label class="col-md-2" style="text-align: right;">Status Bayar</label>
                             <label class="col-md-2"></label>
                            <div class="col-md-3">
                            <select class=" form-control" name="jenis_bayar" onchange="ubahjenis(this)" id="jenis_bayar">
                                <option value="lunas">Lunas</option>
                                <option value="kredit">Kredit</option>
                            </select>
                            </div>
                          
                        </div>
                       
                        <div class="row form-group">
                              <label class="col-md-2" style="text-align: right;">Telp</label>
                            <div class="col-md-3">
                            <input type="text" name="telp" id='telp' required class="form-control" readonly>
                            </div>
                            <label class="col-md-2"></label>
                            <label class="col-md-2" style="text-align: right;">Catatan</label>
                            <div class="col-md-3">
                            <textarea name="catatan" class="form-control" rows="3" style="resize: none"></textarea>
                            </div>
                            
                        </div>


                                <hr>
                                <div class="table table-responsive">
                                      <table class="table">
                                        <thead>
                                           
                                            <th>Barang</th>
                                            <th>Qty</th>
                                            <th>Harga</th>
                                            <th>Total</th>
                                            <th>Aksi</th>                                          
                                        </thead>     
                                        <input type="hidden" name="no" id="no" value="0">
                                        <input type="hidden" name="jum" id="jum" value="0">
                                        <input type="hidden" name="arrbar" id="arrbar">                   
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
                                            <tr>
                                            
                                                <td></td>
                                                <td></td>
                                                <td align="right">GRAND TOTAL</td>
                                                <td>
                                                    <input type="text" class='form-control' readonly value=0 name="grandTot" id="grandTot">
                                                </td>
                                                <td></td>
                                            </tr>
                                            <tr class="bayar" id="cara_bayar">
                                                
                                               
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
    $('#tambah').click(function(){
        var itung=$("#no").val();

        itung++;
        var baris = "<tr  id='no"+itung+"'>"+
                                                "<td>"+
                                                    "<select id='barang"+itung+"' name='barang[]' class='barang form-control' required onchange='getHarga("+itung+")'>"+"<option value=''>-- pilih barang --</option>"+
                                                        @foreach ($barangs as $item)
                                                           "<option value='{{ $item->id }}'> {{$item -> nama}}</option>"+
                                                        @endforeach
                                                    "</select>"+
                                                "</td>"+
                                                "<td><input type='number' name='qty[]' class='qty form-control' required id='qty"+itung+"' min='0' value='0' onchange='getTotal("+itung+")'></td>"+
                                                "<td ><input type='number' step='any' name='price[]' id='price"+itung+"' required class='form-control' onchange='getTotal("+itung+")'></td>"+
                                                "<td><input type='number' readonly name='total[]' id='total"+itung+"' class='form-control'></td>"+
                                                "<td width='5%' ><a style='background-color:#fffff; font-weight:bold; color:red;' id='"+itung+"'  onclick='hapus(this,event)' class='form-control btn btnhapus' >X</a></td>"
                                                "</tr>";
           
            
         
        
        $('#detail').append(baris);
        $('#no').val(itung);

        var temp=$('#arrbar').val()
        // alert(temp)
        if(temp){
            var arrbar=temp.split(',');
            var select=document.getElementById('barang'+itung)
            // alert(select.length)
            if(arrbar.length==1){
                 for(var j =0;j<select.length;j++){
                  if (select.options[j].value == arrbar )
                    {   select.remove(j);
                    break
                    }
                }
            }else{
                 for(var a=0;a<arrbar.length;a++){
                    for(var j =0;j<select.length;j++){
                      if (select.options[j].value == arrbar[a] )
                        {   select.remove(j);
                        break
                        }
                    }
                }
            }
            
        }

        if(temp){
           // var arrbar=temp.split(',');
            temp+=',-1'
            $('#arrbar').val(temp)

        }else{
            $('#arrbar').val('-1')
        }

    });



    $('#norek').hide();
    $('#bank').hide();
    $('#pengirim').hide();
});

function hapus(param, e){
    e.preventDefault()
    var bar=$('#barang'+param.id).val()
    var arraybarang = document.getElementsByName('barang[]');

    var arrb=''
    for(var i=0;i<arraybarang.length;i++){
            // alert(arraybarang[i].value+"=="+bar)
        if(arrb=='' && arraybarang[i].value!=bar){
            arrb=arraybarang[i].value
        }else if(arrbar!=''&&arraybarang[i].value!=bar){
            arrb+=','+arraybarang[i].value
        }
    }

    $('#arrbar').val(arrb)
    // alert(arrb)

    $('#no'+param.id).remove();
    getGrandTotal()

    // return false;
}

function ubahjenis(param){
    if(param.value=='lunas'){
        var tgl=$('#tgl').val()
        $('#jatuhtempo').val(tgl)
        $('#jatuhtempo').attr('readonly',true)
        $('#pembayaran').attr('required', true);
        $('#cara_bayar').show();

    }else{
         $('#jatuhtempo').removeAttr('readonly')
         $('.bayar').hide()
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

function getGrandTotal(){
    var arraytotal = document.getElementsByName('total[]');
    var tot=0;
    for(var i=0;i<arraytotal.length;i++){
        if(parseInt(arraytotal[i].value))
            tot += parseInt(arraytotal[i].value);
    }
    document.getElementById('grandTot').value = tot;
}

function nohp(param){
    var pilih=$('#id_supplier').val()
    if(pilih){
        var id_cus=[
            @foreach ($suppliers as $item)
                [ "{{ $item->id }}" ], 
            @endforeach
        ];
        var telp=[
            @foreach ($suppliers as $item)
                [ "{{ $item->telp }}" ], 
            @endforeach
        ];

        for(var i=0;i<id_cus.length;i++){
            if(id_cus[i]==pilih){
                $('#telp').val(telp[i]);
            }
        }
    }else{
         $('#telp').val("");
    }
}

function getHarga(no)
    {
        var option = $("#barang"+no).val();
        var arraybarang = document.getElementsByName('barang[]');
        var temp=$('#arrbar').val()
        if(option){
            var split=temp.split(',')
            if(split.length==1){
                $('#arrbar').val(option)
            }else{
                var arrb=''
                for(var i=0;i<split.length;i++){
                    if(i==0){
                        arrb=arraybarang[i].value
                    }else{
                        arrb+=','+arraybarang[i].value
                    }
                }

                $('#arrbar').val(arrb)
            }
        }
        

  
        var nomer=no;
        /* setting input box value to selected option value */
        var kodebarang = [
        @foreach ($barangs as $item)
            [ "{{ $item->id }}" ], 
        @endforeach
        ];
        var harga = [
        @foreach ($barangs as $item)
            @if($item->harga_beli_rata)
            [ "{{ $item->harga_beli_rata }}" ], 
            @else
             [ "{{ $item->harga_asli }}" ],
             @endif 
        @endforeach
        ];
        for(var i=0;i<kodebarang.length;i++){
            if(kodebarang[i]==option){
                $('#price'+no).val(harga[i]);
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

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection