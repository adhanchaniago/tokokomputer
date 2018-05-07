@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Periode</div>
                    <div class="panel-body">
                    @if(strtotime(date('Y-m-d'))>=strtotime($aktif->tgl_akhir))
                        <a href="{{ url('/periode/create') }}" class="btn btn-success btn-sm" title="Add New periode">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New
                        </a>
                    @endif

                        <form method="GET" action="{{ url('/periode') }}" accept-charset="UTF-8" class="navbar-form navbar-right" role="search">
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
                                        <th>#</th>
                                        <th>Tgl Awal</th>
                                        <th>Tgl Akhir</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($periode as $item)
                                    <tr>
                                        <td>{{ $loop->iteration or $item->id }}</td>
                                        <td>{{ $item->tgl_awal }}</td>
                                        <td>{{ $item->tgl_akhir }}</td>

                                        <td> @if($item->status=="aktif")
                                        <span class="label-success label">
                                        @else
                                        <span class="label-danger label">
                                        @endif
                                        {{ucfirst($item->status)}}</span></td>
                                        <td>
                                           
                                            @if($item->status!='selesai' &&strtotime(date('Y-m-d'))>=strtotime($aktif->tgl_akhir))
                                            <a href="{{ url('/tutupperiode/' . $item->id) }}" title="View periode"><button class="btn btn-danger btn-xs"><i class="fa fa-close" aria-hidden="true"></i> Close</button></a>
                                            @endif

                                            
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $periode->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
