@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Laporan Jurnal</div>
                    <div class="panel-body">
                    <form action="{{url('laporanjurnal')}}" class="form-horizontal" method="post">
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
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Keterangan</th>
                                        <th>Akun</th>
                                        <th>Debet</th>
                                        <th>Kredit</th>
                                        <th>Nomor Bukti</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($jurnals as $apa)
                                @php
                                $details=$apa->getdetail($apa->id);
                                @endphp
                                    @foreach($details as $item)
                                        <tr>
                                            <td>{{ $item->jurnal->tgl }}</td>
                                            <td>{{ $item->jurnal->keterangan }}</td>
                                            <td>{{ $item->akun->nama }}</td>
                                            <td>Rp {{ number_format($item->nominal_debet,0,",",".") }}</td>
                                            <td>Rp {{ number_format($item->nominal_kredit,0,",",".") }}</td>
                                            <td>{{ $item->jurnal->no_bukti }}</td>
                                        </tr>
                                    @endforeach
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
