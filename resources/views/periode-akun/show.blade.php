@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">periodeAkun {{ $periodeakun->id }}</div>
                    <div class="panel-body">

                        <a href="{{ url('/periode-akun') }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/periode-akun/' . $periodeakun->id . '/edit') }}" title="Edit periodeAkun"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                        <form method="POST" action="{{ url('periodeakun' . '/' . $periodeakun->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-xs" title="Delete periodeAkun" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                        </form>
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $periodeakun->id }}</td>
                                    </tr>
                                    <tr><th> Id Periode </th><td> {{ $periodeakun->id_periode }} </td></tr><tr><th> Nomor Akun </th><td> {{ $periodeakun->nomor_akun }} </td></tr><tr><th> Saldo Akhir </th><td> {{ $periodeakun->saldo_akhir }} </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
