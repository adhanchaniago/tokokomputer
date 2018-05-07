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
                         {!! Form::open(['url' => ['/paket',$paket->id], 'method' => 'PATCH', 'class' => 'form-horizontal', 'files' => true]) !!}
                        <div class="row">
                                <label class="col-md-2" style="text-align: right;">Nama</label>
                                <div  class="col-md-3" style="text-align: left;">
                                    <input type="text" name="nama" class="form-control" value="{{$paket->nama}}" required>
                                </div>
                                <label class="col-md-1"></label>
                                <label class="col-md-2" style="text-align: right;">Detail</label>
                                <div  class="col-md-4">
                                    <textarea class="form-control" rows="3" style="resize: none;" name="detail" required>{{$paket->detail}}</textarea>
                                </div>
                        </div>
                                <hr>
                                <div class="table table-responsive">
                                      <table class="table">
                                        <thead>
                                            <th>Barang</th>
                                            <th>Harga</th>
                                            <th>Aksi</th>                                          
                                        </thead>
                                        @php
                                        $itung=1;
                                        $to=0;
                                        @endphp     
                                        <input type="hidden" name="no" id="no" value="{{$details->count()}}">
                                        <input type="hidden" name="jum" id="jum" value="0">                                   
                                        <tbody id='detail'>
                                        @foreach($details as $detail)
                                            <tr  id='no{{$itung}}'>
                                               <td>
                                                   <select id='barang{{$itung}}' name='barang[]' class='barang form-control' onchange='getHarga({{$itung}})'>"+"<option>-- pilih barang --</option>
                                                        @foreach ($barangs as $item)
                                                            @if($item->id==$detail->id_barang)
                                                          <option value='{{ $item->id }}' selected> {{$item -> nama}}</option>
                                                            $to=$item->harga_jual;
                                                            @else
                                                             <option value='{{ $item->id }}'> {{$item -> nama}}</option>
                                                            @endif
                                                        @endforeach
                                                   </select>

                                               </td>
                                               <td>
                                                <input type='number' class="form-control" min="0" name='total[]' id='total{{$itung}}' value="{{$detail->barang->harga_jual}}" >
                                               </td>
                                               
                                               <td width='5%' ><a style='background-color:#fffff; font-weight:bold; color:red;' id='{{$itung}}'  onclick='hapus(this,event)' class='form-control btn btnhapus' >X</a></td>
                                                </tr>

                                        @php
                                        $itung++;
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
                                            <tr>
                                            
                                                <td></td>
                                                <td></td>
                                                <td align="right">Total Harga Beli</td>
                                                <td>
                                                    <input type="number" class='form-control' required name="total_harga_asli" id="grandTot" value="{{$paket->total_harga_asli}}">
                                                </td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                
                                               
                                                <td></td>
                                                <td></td>
                                                <td align="right">Total Harga Jual</td>
                                                <td>
                                                    <input type="number" class='form-control' required name="total_harga_jual" id="totaljual" value="{{$paket->total_harga_jual}}">
                                                </td>
                                            </tr>
                                          
                                           <!--  <tr  name="norek" id="norek">
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td align="right">Cara Pengiriman</td>
                                                <td>
                                                    <select name="shipping" class="form-control">
                                                        <option value="">-- Pilih cara pengiriman --</option>
                                                        <option value="Langsung">Barang diambil langsung</option>
                                                        <option value="Shipping Point">Biaya kirim ditanggung perusahaan</option>
                                                        <option value="Destination Point">Biaya kirim ditanggung penjual</option>
                                                    </select>
                                                </td>
                                            </tr> -->
                                            <tr>
                                                <td></td>
                                                <td><a href="{{url('paket')}}" class="btn btn-warning">Kembali</a></td>
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
                                               "<td><input type='number' class='form-control' min='0' name='total[]' id='total"+itung+"' ></td>"+
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
    $('#totaljual').val(tot)
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
        var tot=0
        for(var i=0;i<kodebarang.length;i++){
            if(kodebarang[i]==option){
                $('#total'+no).val(harga[i])
            }
        }
        getGrandTotal()
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
