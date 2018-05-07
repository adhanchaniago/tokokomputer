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
                         {!! Form::open(['url' => '/nota-penerimaan', 'method' => 'post', 'class' => 'form-horizontal', 'files' => true]) !!}
                        <div class="row form-group">
                                <label class="col-md-2" style="text-align: right;">No Nota</label>
                                
                                <label  class="col-md-3" style="text-align: left;">{{ $notapenerimaan->id }}</label>
                                <label class="col-md-2"></label>
                                <label class="col-md-2" style="text-align: right;">Tanggal</label>
                                @php
                                setlocale(LC_ALL, 'IND');
                            
                                $tgl= strftime('%d %B %Y', strtotime($notapenerimaan->tgl));
                                @endphp
                                 <label>{{$tgl}}</label>
                        </div>
                          <div class="row form-group">
                                <label class="col-md-2" style="text-align: right;">No Nota Beli</label>
                                
                                <label class="col-md-3" style="text-align: left;">
                                   {{$notapenerimaan->id_nota_beli}}
                                </label>
                                <label class="col-md-2"></label>
                                <label class="col-md-2" style="text-align: right;">Catatan</label>
                                <label class="col-md-3">
                                {{$notapenerimaan->catatan}}
                                </label>
                        </div>
                       
                       
                                <hr>
                                <div class="table table-responsive">
                                      <table class="table">
                                        <thead>
                                           
                                            <th>Barang</th>
                                            <th>Qty</th>                                       
                                        </thead>     
                                        <input type="hidden" name="no" id="no" value="0">
                                        <input type="hidden" name="jum" id="jum" value="0">                                   
                                        <tbody id='detail'>
                                        @foreach($details as $detail)
                                            <tr  id='no$itung'>
                                                <td>
                                                <label> {{$detail->barang->nama}} </label>
                                                </td>
                                                <td>
                                                    <label>{{$detail->qty}}</label>
                                                </td>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                         
                                           

                                            <tr>
                                                <td></td>
                                                <td><a href="{{url('nota-penerimaan')}}" class="btn btn-warning">Kembali</a></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
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