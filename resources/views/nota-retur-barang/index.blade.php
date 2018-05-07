@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Notareturbarang</div>
                    <div class="panel-body">
                        <a href="{{ url('/nota-retur-barang/create') }}" class="btn btn-success btn-sm" title="Add New notaReturBarang">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New
                        </a>

                        {!! Form::open(['method' => 'GET', 'url' => '/nota-retur-barang', 'class' => 'navbar-form navbar-right', 'role' => 'search'])  !!}
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Search...">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                        {!! Form::close() !!}

                        <br/>
                        <br/>
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Supplier</th>
                                        <th>Tgl Retur</th><th>Tgl Selesai</th><th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($notareturbarang as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{$item->supplier->nama}}</td>
                                        <td>{{ $item->tgl_retur }}</td>
                                        <td>{{ $item->tgl_selesai }}</td>
                                        <td>
                                            <a href="{{ url('/nota-retur-barang/' . $item->id) }}" title="View notaReturBarang"><button class="btn btn-info btn-xs"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                            @if($item->status!='selesai' &&$item->status!='diterima')
                                            <a href="{{ url('/nota-retur-barang/' . $item->id . '/edit') }}" title="Edit notaReturBarang"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                                            {!! Form::open([
                                                'method'=>'DELETE',
                                                'url' => ['/nota-retur-barang', $item->id],
                                                'style' => 'display:inline'
                                            ]) !!}
                                                {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                                        'type' => 'submit',
                                                        'class' => 'btn btn-danger btn-xs',
                                                        'title' => 'Delete notaReturBarang',
                                                        'onclick'=>'return confirm("Confirm delete?")'
                                                )) !!}
                                            {!! Form::close() !!}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $notareturbarang->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
