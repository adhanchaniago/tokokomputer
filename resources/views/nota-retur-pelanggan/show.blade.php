@extends('layouts.app')
@section('title','Retur Pembelian Barang')
@section('content')
    <div class="container">
        <div class="row">
        @include('admin.sidebar')
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Tambah Retur Jual Barang</div>
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
                            
                            $tgl= strftime('%d %B %Y', strtotime($notaretur->tgl));
                            $tglselesai=strftime('%d %B %Y', strtotime($notaretur->tgl_selesai));
                        @endphp

                        {!! Form::open(['url' => ['/nota-retur-pelanggan',$notaretur->id], 'method' => 'patch', 'class' => 'form-horizontal', 'files' => true]) !!}
                        <div class="row form-group">
                                <label class="col-md-2" style="text-align: right;">No Nota</label>
                                
                                <label  class="col-md-3" style="text-align: left;">{{ $notaretur->id }}</label>
                                <label class="col-md-2"></label>
                                <label class="col-md-2" style="text-align: right;">Tanggal</label>
                                
                                <div  class="col-md-3"> {{$tgl}} {{date('H:i',strtotime($notaretur->tgl))}} </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-md-2" style="text-align: right;">Customer</label>
                            <label class="col-md-3">
                                {{$notaretur->customer->nama}}
                            </label>
                            <label class="col-md-2"></label>
                            <label class="col-md-2" style="text-align: right;">Tanggal Selesai</label>
                            <label class="col-md-3">
                            {{$tglselesai}}
                            </label>
                        </div>
                         <div class="row form-group">
                            <label class="col-md-2" style="text-align: right;">Catatan</label>
                            <label class="col-md-3">{{$notaretur->catatan}}
                            </label>
                            <label class="col-md-2"></label>
                            <label class="col-md-2" style="text-align: right;">Jenis Retur</label>
                            <label class="col-md-3">
                                {{ucwords($notaretur->jenis_retur)}}
                            </label>
                        </div>
                        <div class="row form-group">
                            <label class="col-md-2" style="text-align: right;">Status</label>
                            <label class="col-md-3">
                                {{ucwords($notaretur->status)}}
                            </label>
                        </div>      
                        <input type="hidden" id="no" value="{{$details->count()}}">
                        <table id="tabelBarang" class="table" >
                             <thead>
                                <th>Barang</th>
                                <th>Qty Retur</th>
                                <th>Harga</th>
                                <th>Total Retur</th>
                                                           
                            </thead>    
                            <tbody id="detail">
                                  @php
                                        $itung=1;
                                        $grantot=0;
                                     
                                        @endphp

                                @foreach($details as $detail)
                                          <tr >
                                                <td>
                                                    {{$detail->barang->nama}}
                                                </td>
                                                
                                                <td>{{$detail->qty}}</td>
                                                @if($notaretur->jenis_retur=='uang')
                                                <td>{{$detail->barang->harga_jual}}</td>
                                                <td>{{$detail->sub_total}}</td>
                                                @endif
                                               </tr>

                                        @php
                                        $itung++;
                                        $grantot+=$detail->sub_total;
                                        @endphp
                                        @endforeach
                            </tbody>
                            <tfoot>
                                            <tr>
                                             
                                                
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                 <td></td>
                                                <td></td>
                                                <td></td>
                                               
                                            </tr>
                                            @if($notaretur->jenis_retur=='uang')
                                            <tr>
                                            
                                                    
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td align="right">GRAND TOTAL</td>
                                                <td colspan="2">
                                                    <input type="text" class='form-control' readonly name="grandTot" value="{{$grantot}}" id="grandTot">
                                                </td>
                                                <td></td>
                                            </tr>
                                      
                                           @endif
                                            <tr>
                                                <td></td>
                                                <td><a href="{{url('nota-retur-pelanggan')}}" class="btn btn-warning">Kembali</a></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                        </table>

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection