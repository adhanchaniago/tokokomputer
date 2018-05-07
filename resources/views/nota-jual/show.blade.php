@extends('layouts.app')
@section('title','Penjualan Barang')
@section('content')
    <div class="container">
        <div class="row">
         @include('admin.sidebar')
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Detail Nota Jual</div>
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
                                
                                <label  class="col-md-3" style="text-align: left;">{{ $notajual->id }}</label>
                                <label class="col-md-2"></label>
                                <label class="col-md-2" style="text-align: right;">Tanggal</label>
                                
                                <label  class="col-md-3">{{strftime('%d %B %Y', strtotime($notajual->tgl))}}</label>
                        </div>
                        <div class="row">
                            <label class="col-md-2" style="text-align: right;">Customer</label>
                             <label  class="col-md-3">{{$notajual->customer->nama}}</label>
                            <label class="col-md-2"></label>
                            <label class="col-md-2" style="text-align: right;">Telp</label>
                              <label  class="col-md-3">{{$notajual->telp}}</label>
                        </div>
                                <hr>
                                <div class="table table-responsive">
                                @if($barangs->count())
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
                                             @foreach($barangs as $detail)
                                            <tr>
                                            <td>{{$detail->barang->nama}}</td>
                                            <td>{{$detail->qty}}</td>
                                            <td>Rp {{$detail->harga}}</td>
                                            <td>Rp {{$detail->sub_total}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                             
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                              
                                            </tr>
                                          
                                         
                                           
                                        </tfoot>

                                    </table>
                                    @endif

                                    @if($pakets->count())
                                    <table class="table">
                                        <thead>
                                           
                                            <th>Paket</th>
                                            <th>Qty</th>
                                            <th>Detail</th>
                                            <th>Harga</th>
                                            <th>Total</th>                                        
                                        </thead>     
                                        <input type="hidden" name="nopaket" id="nopaket" value="0">
                                                                         
                                        <tbody id='detailpaket'>
                                        @foreach($pakets as $detail)
                                            <tr>
                                            <td>@if($detail->id_paket)
                                            {{$detail->paket->nama}}
                                            @else
                                            Custom
                                            @endif
                                            </td>
                                            <td>{{$detail->qty}}</td>
                                            <td>
                                                @php
                                                    $detailbarangs=$detail->detailbarang($detail->id_nota,$detail->no_baris);
                                                @endphp
                                                @foreach($detailbarangs as $bar)
                                                @php
                                                    $qty=$bar->getqty($bar->id_nota,$bar->no_baris_paket,$bar->id_barang);
                                                @endphp
                                                {{$qty}} {{$bar->barang->nama}} <br>
                                                @endforeach
                                            </td>
                                            <td>Rp {{$detail->harga}}</td>
                                            <td>Rp {{$detail->sub_total}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                    
                                           
                                        </tfoot>

                                    </table>
                                    @endif
                                     <table class="table">
                                            <tr>
                                            
                                                <td></td>
                                                <td></td>
                                                <td align="right">GRAND TOTAL</td>
                                                <td>
                                                     <label>Rp {{$notajual->total_harga}}</label>
                                                </td>
                                                
                                            </tr>
                                            <tr>
                                                
                                               
                                                <td></td>
                                                <td></td>
                                                <td align="right">Jenis Pembayaran</td>
                                                <td>
                                                   <label>{{ucfirst($notajual->jenis_pembayaran)}}</label>
                                                </td>
                                            </tr>
                                            @if($notajual->jenis_pembayaran=="transfer")
                                            <tr >
                                               
                                               
                                                <td></td>
                                                <td></td>
                                                <td align="right">Nama Bank</td>
                                                <td>{{$notajual->nama_bank}}</td>
                                                 <td></td>
                                            </tr>
                                            
                                             <tr class="bayar"  id="norek">
                                                <td></td>
                                                <td></td>
                                                <td align="right">No. Rekening</td>
                                                <td>
                                                    {{$notajual->no_rek}}
                                                </td>
                                                 <td></td>
                                            </tr>
                                          
                                            <tr class="bayar"  id="pengirim">
                                                <td></td>
                                                <td></td>
                                                <td align="right">Pengirim</td>
                                                <td>{{ucwords($notajual->pengirim)}}</td>
                                                 <td></td>
                                            </tr>
                                            @endif
                                             <tr>
                                                <td></td>
                                                <td><a href="{{url('nota-jual')}}" class="btn btn-warning">Kembali</a></td>
                                                <td></td>
                                                <td></td>
                                                
                                            </tr>
                                        </table>
                                </div>
                              
                            {!! Form::close() !!}

                 
<script type="text/javascript"> 

 </script>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection