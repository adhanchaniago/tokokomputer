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
                        setlocale(LC_ALL, 'IND');
                        $tgl=strftime('%d %B %Y',strtotime($notaservice->tgl));
                        $tglselesai=strftime('%d %B %Y',strtotime($notaservice->tgl_selesai));
                        @endphp
                         {!! Form::open(['url' => ['/nota-service',$notaservice->id], 'method' => 'patch', 'class' => 'form-horizontal', 'files' => true]) !!}
                        <div class="row form-group">
                                <label class="col-md-2" style="text-align: right;">No Nota</label>
                                
                                <label  class="col-md-3" style="text-align: left;">{{ $notaservice->id }}</label>
                                <label class="col-md-2"></label>
                                <label class="col-md-2" style="text-align: right;">Tanggal</label>
                                
                                <label  class="col-md-3"> {{$tgl}} {{date('H:i', strtotime($notaservice->tgl))}} </label>
                        </div>
                        <div class="row form-group">
                            <label class="col-md-2" style="text-align: right;">Customer</label>
                            <label class="col-md-3">
                            {{$notaservice->customer->nama}}
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
                            {{$notaservice->catatan}}
                            </label>
                            <label class="col-md-2"></label>
                            <label class="col-md-2" style="text-align: right;">Detail Service</label>
                            <label class="col-md-3">
                             {{$notaservice->status}}
                            </label>
                        </div>

                         <div class="row form-group">
                           
                            <label class="col-md-2" style="text-align: right;">Status Garansi</label>
                            <label class="col-md-3">
                              {{$notaservice->status_garansi}}
                            </label>
                        </div>
                                <hr>
                                <div class="table table-responsive">
                                      <table class="table">
                                        <thead>
                                           
                                            <th>Barang</th>
                                            <th>Qty</th>
                                            <th>Keterangan</th>
                                            <th>Harga Service</th>
                                            <th>Total</th>                                          
                                        </thead>     
                                         @php
                                        $itung=1;
                                        $grantot=0;
                                      
                                        @endphp
                                        <input type="hidden" name="jum" id="jum" value="0">                                   
                                        <tbody id='detail'>
                                        @php
                                        $itung=1;
                                        $grandtot=0;
                                        @endphp
                                        @foreach($detailnota as $detail)
                                            <tr>
                                                <td>
                                                    {{$detail->barang}}
                                                </td>
                                                <td>{{$detail->qty}}</td>
                                                 <td>
                                                    {{$detail->keterangan}}
                                                </td>
                                                <td >{{$detail->harga}}</td>
                                                <td>{{$detail->sub_total}}</td>
                                                
                                            </tr>
                                        @php
                                        $itung++;
                                        $grandtot+=$detail->qty*$detail->harga;
                                        @endphp
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                            
                                        </tfoot>
                                    </table>
                                    @if($sperparts->count())
                                     <table class="table table-responsive" id="sperpart">
                                         <thead>
                                           
                                            <th>Sparepart</th>
                                            <th>Qty</th>
                                            <th>Harga</th>
                                            <th>Total</th>                                          
                                        </thead>     
                                      
                                        <tbody id="detailsperpart">
                                        @php
                                        $itung=1;
                                        @endphp
                                        @foreach($sperparts as $detail)
                                            <tr  >
                                                <td>
                                                  {{$detail->barang->nama}}
                                                </td>
                                                <td>{{$detail->qty}}</td>
                                                <td >{{$detail->harga}}</td>
                                                <td>{{$detail->sub_total}}</td>
                                               
                                                </tr>
                                        @php
                                        $itung++;
                                        $grandtot+=$detail->harga*$detail->qty;
                                        @endphp
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                          
                                        </tfoot>
                                    </table>
                                    @endif


                                    <table width="100%" align="right" style="padding: 5px 0; font-size: 1em">
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td align="right" style="font-weight: bold; font-size: 1.3em ">GRAND TOTAL : </td>
                                                <td align="right" style="font-weight: bold; font-size: 1.5em">
                                                  Rp. {{$grandtot}}
                                                </td>
                                            </tr>
                                            <tr> 
                                                <td></td>
                                                <td></td>
                                                <td align="right">Jenis Pembayaran </td>
                                                <td align="right">
                                                   {{$notaservice->pembayaran}}
                                                </td>
                                            </tr>
                                          @if($notaservice->pembayaran=="transfer")
                                          <tr id="bank">
                                                <td></td>
                                                <td></td>
                                                <td align="right">Nama Bank </td>
                                                <td align="right">
                                                    {{$notaservice->nama_bank}}
                                                </td>
                                            </tr>
                                            <tr   id="norek">
                                                <td></td>
                                                <td></td>
                                                <td align="right">No. Rekening </td>
                                                <td align="right">
                                                    {{$notaservice->no_rek}}
                                                </td>
                                            </tr>
                                            <tr  id="pengirim">
                                                <td></td>
                                                <td></td>
                                                <td align="right">Pengirim </td>
                                                <td align="right" >
                                                    {{$notaservice->pengirim}}
                                                </td>
                                            </tr>
                                            @endif
                                            <tr>
                                                <td><a href="{{url('nota-service')}}" class="btn btn-warning">Kembali</a></td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                              
                            {!! Form::close() !!}

          

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection