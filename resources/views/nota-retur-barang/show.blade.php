@extends('layouts.app')
@section('title','Retur Pembelian Barang')
@section('content')
    <div class="container">
        <div class="row">
        @include('admin.sidebar')
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Tambah Retur Pembelian Barang</div>
                    <div class="panel-body">

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        {!! Form::open(['url' => ['/nota-retur-barang',$notaretur->id], 'method' => 'PATCH', 'class' => 'form-horizontal', 'files' => true]) !!}

                         @php
                            setlocale(LC_TIME, 'IND');
                            
                            $tgl= strftime('%d %B %Y', strtotime($notaretur->tgl_retur));
                            $tglselesai=strftime('%d %B %Y', strtotime($notaretur->tgl_selesai));
                        @endphp
                        <div class="row form-group">
                                <label class="col-md-2" style="text-align: right;">No Nota</label>
                                
                                <label  class="col-md-3" style="text-align: left;">{{ $notaretur->id }}</label>
                                <label class="col-md-2"></label>
                                <label class="col-md-2" style="text-align: right;">Tanggal</label>
                                
                                <label  class="col-md-3"> {{$tgl}} {{date('H:i',strtotime($notaretur->tgl_retur))}}</label>
                        </div>
                        <div class="row form-group">
                            <label class="col-md-2" style="text-align: right;">Supplier</label>
                            <label class="col-md-3">
                           
                            {{$notaretur->supplier->nama}}
                                  
                            </label>
                            <label class="col-md-2"></label>
                            <label class="col-md-2" style="text-align: right;">Tanggal Selesai</label>
                            <label class="col-md-3">
                            {{$tglselesai}}
                            </label>
                        </div>
                         <div class="row form-group">
                            <label class="col-md-2" style="text-align: right;">Catatan</label>
                            <label class="col-md-3">
                            {{$notaretur->catatan}}
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
                                <th>Harga</th>
                                <th>Qty Retur</th>
                                <th>Total Retur</th>                  
                            </thead>
                                @php
                                $itung=1;
                                $grantot=0;
                              
                                
                                $qtyada=0;
                                $hargaada=0;
                             
                                @endphp    
                            <tbody id="detail">
                                 @foreach($details as $detail)
                                 <tr >
                                                <td>
                                                   {{$detail->barang->nama}}
                                                </td>
                                                <td >Rp {{$detail->barang->harga_beli_rata}}</td>
                                                <td >{{$detail->qty}}</td>
                                               
                                                <td>{{$detail->sub_total}}</td>
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


                                            <tr>
                                            
                                                
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td align="right">GRAND TOTAL</td>
                                                <td colspan="2">
                                                    <input type="text" class='form-control' readonly value="{{$grantot}}" name="grandTot" id="grandTot">
                                                </td>
                                                <td></td>
                                            </tr>
                                           <!--  <tr>
                                                
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td align="right">Jenis Pembayaran</td>
                                                <td colspan="2">
                                                    <select name="pembayaran" required class="form-control" id="pembayaran" onChange="getRekening()">
                                                        <option value="">-- Pilih jenis pembayaran --</option>
                                                        <option value="tunai">Tunai</option>
                                                        <option value="transfer">Transfer</option>
                                                        <option value="kredit">Kredit</option>
                                                    </select>
                                                </td>
                                            </tr> -->
                                           <!--  <tr  name="norek" id="norek">
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td align="right">No. Rekening</td>
                                                <td>
                                                    <input type="number" class='form-control'>
                                                </td>
                                            </tr> -->
                                           
                                            <tr>
                                                <td></td>
                                                <td><a href="{{url('nota-retur-barang')}}" class="btn btn-warning">Kembali</a></td>
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