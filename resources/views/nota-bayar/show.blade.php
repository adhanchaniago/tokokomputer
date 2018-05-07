@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">notaBayar {{ $notabayar->id }}</div>
                    <div class="panel-body">

                        <a href="{{ url('/nota-bayar') }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Kembali</button></a>
                       
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $notabayar->id }}</td>
                                    </tr>
                                    <tr><th> Tgl Bayar </th><td> {{ $notabayar->tgl_bayar }} </td></tr>
                                    <tr><th> Total Harga </th><td> {{ $notabayar->total_harga }} </td></tr>
                                    <tr><th> Nonota Beli </th><td> {{ $notabayar->id_nota_beli }} </td></tr>
                                    <tr><th> User </th><td> {{ $notabayar->user->name }} </td></tr>
                                    <tr><th> Status </th><td> {{ ucwords($notabayar->status) }} </td></tr>
                                    <tr><th> Catatan </th><td> {{ ($notabayar->catatan)?$notabayar->catatan:'' }} </td></tr>
                                    <tr><th> Jenis Pembayaran </th><td> {{ ucwords($notabayar->jenis_pembayaran) }} </td></tr>
                                    @if($notabayar->jenis_pembayaran=='transfer')
                                    <tr><th> Nama Bank </th><td> {{ $notabayar->nama_bank }} </td></tr>
                                    <tr><th> Nomer Rekening </th><td> {{ $notabayar->no_rek }} </td></tr>
                                    <tr><th> Pengirim </th><td> {{ $notabayar->pengirim }} </td></tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
