@extends('layouts.app')
@section('title','Tampil Pembelian Barang')
@section('content')
    <div class="container">
        <div class="row">
           @include('admin.sidebar')
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Tampil Nota Pembelian</div>
                    <div class="panel-body">

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                         {!! Form::open(['url' => '/nota-beli', 'method' => 'post', 'class' => 'form-horizontal', 'files' => true]) !!}
                         @php
                            setlocale(LC_ALL, 'IND');
                            
                            $tgl= strftime('%d %B %Y', strtotime($notabeli->tgl));
                         @endphp
                        <div class="row">
                                <label class="col-md-2" style="text-align: right;">No Nota</label>
                                
                                <label  class="col-md-3" style="text-align: left;">{{ $notabeli->id }}</label>
                                <label class="col-md-2"></label>
                                <label class="col-md-2" style="text-align: right;">Tanggal</label>
                                
                                <label  class="col-md-3">{{$tgl}}</label>
                        </div>
                        <div class="row">
                            <label class="col-md-2" style="text-align: right;">Supplier</label>
                            <label  class="col-md-3">{{$notabeli->supplier->nama}}</label>
                            <label class="col-md-2"></label>
                            <label class="col-md-2" style="text-align: right;">Jatuh Tempo</label>
                            <label  class="col-md-3">{{strftime('%d %B %Y', strtotime($notabeli->jatuh_tempo))}}</label>
                        </div>
                                <hr>
                                <div class="table table-responsive">
                                      <table class="table">
                                        <thead>
                                           
                                            <th>Barang</th>
                                            <th>Qty</th>
                                            <th>Harga</th>
                                            <th>Total</th>                                      
                                        </thead>     
                                        <input type="hidden" name="no" id="no" value="0">
                                        <input type="hidden" name="jum" id="jum" value="0">                                   
                                        <tbody id='detail'>
                                            @foreach($details as $detail)
                                            <tr>
                                            <td>{{$detail->barang->nama}}</td>
                                            <td>{{$detail->qty}}</td>
                                            <td>Rp {{number_format($detail->harga,0,",",".")}}</td>
                                            <td>Rp {{number_format($detail->sub_total,0,",",".")}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                          
                                            <tr>
                                            
                                                <td></td>
                                                <td></td>
                                                <td align="right">GRAND TOTAL</td>
                                                <td>
                                                   <label>Rp {{number_format($notabeli->total_harga,0,",",".")}}</label>
                                                </td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                
                                               
                                                <td></td>
                                                <td></td>
                                                <td align="right">Jenis Pembayaran</td>
                                                <td>
                                                  <label>{{ucfirst($notabeli->jenis_pembayaran)}}</label>
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
                                                <td></td>
                                                <td></td>
                                                <td><a href="{{url('nota-beli')}}" class="btn btn-warning">Kembali</a></td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                              
                            {!! Form::close() !!}

                 
<script type="text/javascript"> 
 

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

function getHarga(no)
    {
   
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