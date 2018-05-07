<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\detailPenerimaan;
use Illuminate\Http\Request;
use Session;

class detailPenerimaanController extends Controller
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
            $detailpenerimaan = detailPenerimaan::where('id_nota', 'LIKE', "%$keyword%")
				->orWhere('id_barang', 'LIKE', "%$keyword%")
				->orWhere('qty', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $detailpenerimaan = detailPenerimaan::paginate($perPage);
        }

        return view('detail-penerimaan.index', compact('detailpenerimaan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('detail-penerimaan.create');
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
        
        detailPenerimaan::create($requestData);

        Session::flash('flash_message', 'detailPenerimaan added!');

        return redirect('detail-penerimaan');
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
        $detailpenerimaan = detailPenerimaan::findOrFail($id);

        return view('detail-penerimaan.show', compact('detailpenerimaan'));
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
        $detailpenerimaan = detailPenerimaan::findOrFail($id);

        return view('detail-penerimaan.edit', compact('detailpenerimaan'));
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
        
        $detailpenerimaan = detailPenerimaan::findOrFail($id);
        $detailpenerimaan->update($requestData);

        Session::flash('flash_message', 'detailPenerimaan updated!');

        return redirect('detail-penerimaan');
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
        detailPenerimaan::destroy($id);

        Session::flash('flash_message', 'detailPenerimaan deleted!');

        return redirect('detail-penerimaan');
    }
}
