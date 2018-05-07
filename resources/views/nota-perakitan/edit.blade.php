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
                         {!! Form::open(['url' => ['/nota-perakitan',$notaperakitan->id], 'method' => 'patch', 'class' => 'form-horizontal', 'files' => true]) !!}
                        <div class="row">
                                <label class="col-md-2" style="text-align: right;">No Nota</label>
                                
                                <label  class="col-md-3" style="text-align: left;">{{ $notaperakitan->id }}</label>
                                <label class="col-md-2"></label>
                                <label class="col-md-2" style="text-align: right;">Tanggal</label>
                                
                                <label  class="col-md-3">{{strftime('%d %B %Y',strtotime($notaperakitan->tgl))}}</label>
                        </div>
                       
                        <div class="row">
                            <label class="col-md-2" style="text-align: right;">Status</label>
                            <div class="col-md-3">
                            <select class=" form-control" required name="status" id="status">
                                    <option value="menunggu">Dikerjakan</option>
                                    <option value="selesai">Selesai</option>
                            </select>
                            </div>
                           
                        </div>
                                <hr>
                                <div class="table table-responsive">
                                     
                                    <table class="table">
                                        <thead>
                                           
                                            <th>Paket</th>
                                            <th>Qty</th>
                                            <th>Detail</th>
                                                                                  
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
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                    
                                           
                                        </tfoot>

                                    </table>
                                     <table class="table">
                                             <tr>
                                                <td></td>
                                                <td><a href="{{url('nota-perakitan')}}" class="btn btn-warning">Kembali</a></td>
                                                <td></td>
                                                <td><button class="btn btn-default"> Simpan </button></td>
                                                <td></td>
                                            </tr>
                                        </table>
                                </div>
                              
                            {!! Form::close() !!}

         









                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection