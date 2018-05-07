@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Jurnal Penutup</div>
                    <div class="panel-body">
                    		<a href="{{url('periode')}}" class="btn btn-warning">Kembali</a>
                        
                        <br/>
                        <br/>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Akun</th>
                                        <th>Debet</th>
                                        <th>Kredit</th>
                                        <th>Saldo Akhir Sebelum Closing</th>
                                        <th>Saldo Akhir Setelah Closing</th>
                                    </tr>
                                    
                                </thead>
                                
                                <tbody>
                                
                                
                               
                                    @foreach($akuns as $item)
                                    <tr>
                                        <td>{{$item->akun->nama}}</td>
                                        <td>{{($item->akun->saldo_normal>0)?'Rp '.number_format($item->saldo_awal,0,",","."):'-'}}</td>
                                        <td>{{($item->akun->saldo_normal<0)?'Rp '.number_format($item->saldo_awal,0,",","."):'-'}}</td>
                                        <td>Rp
                                        @php
		                                	$transaksi=$item->getdetail($item->nomor_akun);
		                                	$saldo=0;
		                                @endphp
		                                @php
		                                foreach($transaksi as $it)
		                                
		                                    if($item->akun->saldo_normal>0){
		                                        $saldo=$saldo+ $it->nominal_debet - $it->nominal_kredit;
		                                    }
		                                    else{
		                                        $saldo=$saldo-$it->nominal_debet+$it->nominal_kredit;
		                                    }
	                                    
	                                    @endphp
                                        {{number_format($saldo,0,",",".")}}
                                        </td>
                                        <td>Rp {{number_format($item->saldo_akhir,0,",",".")}}</td>
                                        
                                    </tr>

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
