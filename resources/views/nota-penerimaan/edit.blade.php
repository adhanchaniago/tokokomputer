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
                            
                            $tgl= strftime('%d %B %Y', strtotime($notapenerimaan->tgl));
                        @endphp
                         {!! Form::open(['url' => ['/nota-penerimaan',$notapenerimaan->id], 'method' => 'patch', 'class' => 'form-horizontal', 'files' => true]) !!}
                        <div class="row form-group">
                                <label class="col-md-2" style="text-align: right;">No Nota</label>
                                
                                <label  class="col-md-3" style="text-align: left;">{{ $notapenerimaan->id }}</label>
                                <label class="col-md-2"></label>
                                <label class="col-md-2" style="text-align: right;">Tanggal</label>
                                
                                 <div  class="col-md-3"> {{$tgl}} {{date('H:i',strtotime($notapenerimaan->tgl))}} </div>
                        </div>
                          <div class="row form-group">
                                <label class="col-md-2" style="text-align: right;">No Nota Beli</label>
                                
                                <div  class="col-md-3" style="text-align: left;">
                                    <select required name="notabeli" class="form-control" onchange="tampildetail(this)">
                                    <option>-- Pilih Nota Beli --</option>
                                    @foreach($notabelis as $beli)
                                    @if($notapenerimaan->id_nota_beli==$beli->id)
                                    <option value="{{$beli->id}}" selected>({{$beli->tgl}}) - {{$beli->id}}</option>
                                    @else
                                     <option value="{{$beli->id}}">({{$beli->tgl}}) - {{$beli->id}}</option>
                                    @endif
                                    @endforeach
                                    </select>
                                </div>
                                <label class="col-md-2"></label>
                                <label class="col-md-2" style="text-align: right;">Catatan</label>
                                <div class="col-md-3">
                                <textarea name="catatan" class="form-control" rows="3" style="resize: none">{{$notapenerimaan->catatan}}</textarea>
                                </div>
                        </div>
                       
                       
                                <hr>
                                <div class="table table-responsive">
                                      <table class="table">
                                        <thead>
                                           
                                            <th>Barang</th>
                                            <th>Qty</th>

                                            <th>Aksi</th>                                          
                                        </thead>     
                                        <input type="hidden" name="no" id="no" value="{{$details->count()}}">
                                        <input type="hidden" name="jum" id="jum" value="0">                                   
                                        <tbody id='detail'>
                                        @foreach($details as $detail)
                                            <tr  id='no$itung'>
                                                <td><label>{{ $detail->barang->nama}} </label>
                                                    "<input type='hidden' id='barang$itung' name='barang[]' value='{{$detail->barang->id}}'>
                                                </td>
                                                <td><input type='number' name='qty[]' class='qty form-control' id='qty$itung' min='1' max='$sisa' value='{{$detail->qty}}'></td>
                                                <td width='5%' >
                                                <a style='background-color:#fffff; font-weight:bold; color:red;' id='$itung'  onclick='hapus(this,event)' class='form-control btn btnhapus' >X</a></td>

                                                </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                         
                                           

                                            <tr>
                                                <td></td>
                                                <td><a href="{{url('nota-penerimaan')}}" class="btn btn-warning">Kembali</a></td>
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
                                                    "<select id='barang"+itung+"' name='barang[]' class='barang form-control' onchange='getHarga("+itung+")'>"+"<option>-- pilih barang --</option>"+
                                                        @foreach ($barangs as $item)
                                                           "<option value='{{ $item->id }}'> {{$item -> nama}}</option>"+
                                                        @endforeach
                                                    "</select>"+
                                                "</td>"+
                                                "<td><input type='number' name='qty[]' class='qty form-control' id='qty"+itung+"' min='0' value='0' onchange='getTotal("+itung+")'></td>"+
                                                "<td ><input type='number' step='any' name='price[]' id='price"+itung+"' class='form-control' onchange='getTotal("+itung+")'></td>"+
                                                "<td><input type='number' readonly name='total[]' id='total"+itung+"' class='form-control'></td>"+
                                                "<td width='5%' ><a style='background-color:#fffff; font-weight:bold; color:red;' id='"+itung+"'  onclick='hapus(this,event)' class='form-control btn btnhapus' >X</a></td>"
                                                "</tr>";
        $('#detail').append(baris);
        $('#no').val(itung);
    });
    $('#norek').hide();
});

function hapus(param, e){
    e.preventDefault()
    $('#no'+param.id).remove();
    getGrandTotal()

    // return false;
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

function tampildetail(param) {
    var id=param.value;
    var url=./loaddetail/"+id
    $.get(url, function(data){
        $('#detail').html(data)
    })
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
            [ "{{ $item->harga_beli_rata }}" ], 
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
        }
        else{
            $('#norek').hide();
        }
    }
 </script>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection