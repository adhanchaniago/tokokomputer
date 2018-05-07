@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">paket {{ $paket->id }}</div>
                    <div class="panel-body">

                        <a href="{{ url('/paket') }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Kembali</button></a>
                       
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $paket->id }}</td>
                                    </tr>
                                    <tr><th> Nama </th><td> {{ $paket->nama }} </td></tr>
                                    <tr><th> Detail </th>
                                    <td>  @php
                                            $details=$paket->barang;
                                        @endphp

                                        @foreach($details as $det)
                                        {{$det->qty}} {{$det->barang->nama}} <br>
                                        @endforeach </td></tr><tr><th> Total Harga Jual </th><td> {{ $paket->total_harga_jual }} </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
