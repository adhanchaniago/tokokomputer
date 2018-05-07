@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Laporan Laba Rugi</div>
                    <div class="panel-body">

                      <form action="{{url('laporanlabarugi')}}" class="form-horizontal" method="post">
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
                            <table class="table table-borderless">
                                    <tr>
                                        <th colspan="2">Pendapatan</th>
                                    </tr>
                                    @php
                                    $grantot=0;
                                    @endphp
                                @foreach($pendapatan as $item)
                                @php
                                $saldoakir=$item->gettotal($item->nomor_akun,$item->id_periode);
                                @endphp
                                    
                                    <tr>
                                        <td>{{ $item->akun->nama }}</td>
                                        <td>Rp {{ number_format($saldoakir,0,",",".") }}</td>
                                    </tr>
                                    @php
                                    $grantot+=$saldoakir;
                                    @endphp
                                    
                                @endforeach
                                <tr>
                                    <th >Total Pendapatan</th>
                                    <th>Rp {{number_format($grantot,0,",",".")}}</th>
                                </tr>
                                @php
                                $grantotbiaya=0;
                                @endphp
                                <tr>
                                    <th colspan="2">Biaya</th>
                                </tr>
                                @foreach($biaya as $item)
                                @php
                                $saldoakir=$item->gettotal($item->nomor_akun,$item->id_periode);
                                @endphp
                                    @if($periode->id==$item->id_periode)
                                    <tr>
                                        <td>{{ $item->akun->nama }}</td>
                                        <td>Rp {{ number_format($saldoakir,0,",",".") }}</td>
                                    </tr>
                                    @php
                                    $grantotbiaya+=$saldoakir;
                                    @endphp
                                    @endif
                                @endforeach
                                <tr>
                                    <th >Total Biaya</th>
                                    <th>Rp {{number_format($grantotbiaya,0,",",".")}}</th>
                                </tr>
                                @php
                                $grantot-=$grantotbiaya;
                                @endphp
                                
                                <tr>
                                    <th >Laba/Rugi</th>
                                    <th>Rp {{number_format($grantot,0,",",".")}}</th>
                                </tr>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
