@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Laporan Buku Besar</div>
                    <div class="panel-body">

                    <form action="{{url('laporanbukubesar')}}" class="form-horizontal" method="post">
                    {{ csrf_field() }}
                        <div class="row form-group">
                            <label class="control-label col-md-2">Periode</label>
                            <div class="col-md-5">
                            <select name="periode" class="form-control">
                            @php
                            setlocale(LC_ALL, 'IND');
                            @endphp
                                @foreach($periodes as $p)
                                @if($periode->id==$p->id)
                                <option value="{{$p->id}}" selected>{{strftime('%d %B %Y', strtotime($p->tgl_awal))}} sampai {{strftime('%d %B %Y', strtotime($p->tgl_akhir))}}</option>
                                @else
                                <option value="{{$p->id}}">{{strftime('%d %B %Y', strtotime($p->tgl_awal))}} sampai {{strftime('%d %B %Y', strtotime($p->tgl_akhir))}}</option>
                                @endif
                                @endforeach
                            </select>
                           
                            </div>
                             <div class="col-md-2">
                                <input type="submit" name="pilih" value="PILIH" class="btn btn-primary">
                            </div>
                        </div>
                    </form>
                        
                        <br/>
                        <br/>
                        <div class="table-responsive">
                        @foreach($akuns as $akun)
                            <h4>No: {{$akun->nomor_akun}} ({{$akun->akun->nama}})</h4>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Keterangan</th>
                                        <th>Debet</th>
                                        <th>Kredit</th>
                                        <th>Saldo Debet</th>
                                        <th>Saldo Kredit</th>
                                        <th>Bukti</th>
                                    </tr>
                                    
                                </thead>
                                @php
                                $transaksi=$akun->gettransaksi($akun->nomor_akun,$akun->id_periode);
                                $saldo=$akun->saldo_awal;
                                @endphp
                                <tbody>
                                <tr>
                                        <td></td>
                                        <td>Saldo Awal</td>
                                        <td>{{($akun->akun->saldo_normal>0)?'Rp '.number_format($akun->saldo_awal,0,",","."):'-'}}</td>
                                        <td>{{($akun->akun->saldo_normal<0)?'Rp '.number_format($akun->saldo_awal,0,",","."):'-'}}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                </tr>
                                @foreach($transaksi as $item)
                    
                                    @php

                                    if($akun->akun->saldo_normal>0){
                                        $saldo=$saldo+ $item->nominal_debet - $item->nominal_kredit;
                                    }
                                    else{
                                        $saldo=$saldo-$item->nominal_debet+$item->nominal_kredit;
                                    }

                                    if($item->jurnal->keterangan=='Penutupan Modal Laba Rugi'){
                                        $saldo=$item->nominal_kredit;
                                    }
                                    
                                    @endphp
                                    <tr>
                                        <td>{{$item->jurnal->tgl}}</td>
                                        <td>{{$item->jurnal->keterangan}}</td>
                                        <td>Rp {{number_format($item->nominal_debet,0,",",".")}}</td>
                                        <td>Rp {{number_format($item->nominal_kredit,0,",",".")}}</td>
                                        <td>{{($akun->akun->saldo_normal>0)?'Rp '.number_format($saldo,0,",",".") :'-'}}</td>
                                        <td>{{($akun->akun->saldo_normal<0)?'Rp '.number_format($saldo,0,",",".") :'-'}}</td>
                                        <td>{{$item->no_bukti}}</td>
                                    </tr>
                                
                                @endforeach
                                
                               


                                    
                                
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td colspan="2">Saldo akhir</td>
                                        <td>{{($akun->akun->saldo_normal>0)?'Rp '.number_format($saldo,0,",","."):'-'}}</td>
                                        <td>{{($akun->akun->saldo_normal<0)?'Rp '.number_format($saldo,0,",","."):'-'}}</td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        @endforeach

                        @if($iktisar!='')
                        <h4>No: {{$iktisar->nomor_akun}} ({{$iktisar->akun->nama}})</h4>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Keterangan</th>
                                        <th>Debet</th>
                                        <th>Kredit</th>
                                        <th>Bukti</th>
                                    </tr>
                                    
                                </thead>
                                 @php
                                $transaksi=$iktisar->gettransaksi($iktisar->nomor_akun,$iktisar->id_periode);
                                $saldo=0;
                                @endphp

                                 @foreach($transaksi as $item)
                    
                                   
                                    <tr>
                                        <td>{{$item->jurnal->tgl}}</td>
                                        <td>{{$item->jurnal->keterangan}}</td>
                                        <td>Rp {{number_format($item->nominal_debet,0,",",".")}}</td>
                                        <td>Rp {{number_format($item->nominal_kredit,0,",",".")}}</td>
                                        <td>{{$item->no_bukti}}</td>
                                    </tr>
                                
                                @endforeach
                        @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
