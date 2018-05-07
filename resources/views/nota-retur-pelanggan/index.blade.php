@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Notareturpelanggan</div>
                    <div class="panel-body">
                        <a href="{{ url('/nota-retur-pelanggan/create') }}" class="btn btn-success btn-sm" title="Add New notaReturPelanggan">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New
                        </a>

                        <form method="GET" action="{{ url('/nota-retur-pelanggan') }}" accept-charset="UTF-8" class="navbar-form navbar-right" role="search">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" placeholder="Search...">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="submit">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        </form>
                    
                        <br/>
                        <br/>
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>#</th><th>Tgl</th><th>Tgl Selesai</th><th>Jenis Retur</th><th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($notareturpelanggan as $item)
                                    <tr>
                                        <td>{{ $loop->iteration or $item->id }}</td>
                                        <td>{{ $item->tgl }}</td><td>{{ $item->tgl_selesai }}</td><td>{{ $item->jenis_retur }}</td>
                                        <td>
                                            <a href="{{ url('/nota-retur-pelanggan/' . $item->id) }}" title="View notaReturPelanggan"><button class="btn btn-info btn-xs"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                            @if($item->status!='selesai')
                                            <a href="{{ url('/nota-retur-pelanggan/' . $item->id . '/edit') }}" title="Edit notaReturPelanggan"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                                            <form method="POST" action="{{ url('/nota-retur-pelanggan' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-danger btn-xs" title="Delete notaReturPelanggan" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                                            </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $notareturpelanggan->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
