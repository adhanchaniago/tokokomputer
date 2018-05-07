<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\detailNotaService;
use Illuminate\Http\Request;
use Session;

class detailNotaServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $detailnotaservice = detailNotaService::where('nonota', 'LIKE', "%$keyword%")
				->orWhere('id_barang', 'LIKE', "%$keyword%")
				->orWhere('qty', 'LIKE', "%$keyword%")
				->orWhere('sub_total', 'LIKE', "%$keyword%")
				->orWhere('harga', 'LIKE', "%$keyword%")
				->orWhere('keterangan', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $detailnotaservice = detailNotaService::paginate($perPage);
        }

        return view('detail-nota-service.index', compact('detailnotaservice'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('detail-nota-service.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        
        $requestData = $request->all();
        
        detailNotaService::create($requestData);

        Session::flash('flash_message', 'detailNotaService added!');

        return redirect('detail-nota-service');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $detailnotaservice = detailNotaService::findOrFail($id);

        return view('detail-nota-service.show', compact('detailnotaservice'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $detailnotaservice = detailNotaService::findOrFail($id);

        return view('detail-nota-service.edit', compact('detailnotaservice'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        
        $requestData = $request->all();
        
        $detailnotaservice = detailNotaService::findOrFail($id);
        $detailnotaservice->update($requestData);

        Session::flash('flash_message', 'detailNotaService updated!');

        return redirect('detail-nota-service');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        detailNotaService::destroy($id);

        Session::flash('flash_message', 'detailNotaService deleted!');

        return redirect('detail-nota-service');
    }
}
