@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Notabayar</div>
                    <div class="panel-body">
                        <a href="{{ url('/nota-bayar/create') }}" class="btn btn-success btn-sm" title="Add New notaBayar">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New
                        </a>

                        {!! Form::open(['method' => 'GET', 'url' => '/nota-bayar', 'class' => 'navbar-form navbar-right', 'role' => 'search'])  !!}
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Search...">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                        {!! Form::close() !!}

                        @php
                            setlocale(LC_TIME, 'IND');
                            
                            $tgl= strftime('%d %B %Y H:s', strtotime(date('Y-m-d H:i:s')));
                        @endphp

                        <br/>
                        <br/>
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tgl Bayar</th>
                                        <th>Supplier</th>
                                        <th>Total Harga</th>
                                        <th>Nonota Beli</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($notabayar as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ strftime('%d %B %Y', strtotime($item->tgl_bayar)) }} {{date('H:s',strtotime($item->tgl_bayar))}}</td>
                                        <td>{{$item->notabeli->supplier->nama}}</td>
                                        <td>{{ $item->total_harga }}</td>
                                        <td>{{ $item->id_nota_beli }}</td>
                                        <td>
                                            <a href="{{ url('/nota-bayar/' . $item->id) }}" title="View notaBayar"><button class="btn btn-info btn-xs"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                            @if($item->status!="lunas")
                                            <a href="{{ url('/nota-bayar/' . $item->id . '/edit') }}" title="Edit notaBayar"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                                            {!! Form::open([
                                                'method'=>'DELETE',
                                                'url' => ['/nota-bayar', $item->id],
                                                'style' => 'display:inline'
                                            ]) !!}
                                                {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                                        'type' => 'submit',
                                                        'class' => 'btn btn-danger btn-xs',
                                                        'title' => 'Delete notaBayar',
                                                        'onclick'=>'return confirm("Confirm delete?")'
                                                )) !!}
                                            {!! Form::close() !!}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $notabayar->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
