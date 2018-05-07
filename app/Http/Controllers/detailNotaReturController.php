<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\detailNotaRetur;
use Illuminate\Http\Request;
use Session;

class detailNotaReturController extends Controller
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
            $detailnotaretur = detailNotaRetur::where('nonota', 'LIKE', "%$keyword%")
				->orWhere('id_barang', 'LIKE', "%$keyword%")
				->orWhere('qty', 'LIKE', "%$keyword%")
				->orWhere('sub_total', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $detailnotaretur = detailNotaRetur::paginate($perPage);
        }

        return view('detail-nota-retur.index', compact('detailnotaretur'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('detail-nota-retur.create');
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
        
        detailNotaRetur::create($requestData);

        Session::flash('flash_message', 'detailNotaRetur added!');

        return redirect('detail-nota-retur');
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
        $detailnotaretur = detailNotaRetur::findOrFail($id);

        return view('detail-nota-retur.show', compact('detailnotaretur'));
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
        $detailnotaretur = detailNotaRetur::findOrFail($id);

        return view('detail-nota-retur.edit', compact('detailnotaretur'));
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
        
        $detailnotaretur = detailNotaRetur::findOrFail($id);
        $detailnotaretur->update($requestData);

        Session::flash('flash_message', 'detailNotaRetur updated!');

        return redirect('detail-nota-retur');
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
        detailNotaRetur::destroy($id);

        Session::flash('flash_message', 'detailNotaRetur deleted!');

        return redirect('detail-nota-retur');
    }
}
