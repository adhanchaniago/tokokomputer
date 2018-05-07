<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\detailSperpart;
use Illuminate\Http\Request;
use Session;

class detailSperpartsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $detailsperparts = detailSperpart::where('id_nota', 'LIKE', "%$keyword%")
				->orWhere('id_barang', 'LIKE', "%$keyword%")
				->orWhere('qty', 'LIKE', "%$keyword%")
				->orWhere('harga', 'LIKE', "%$keyword%")
				->orWhere('sub_total', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $detailsperparts = detailSperpart::paginate($perPage);
        }

        return view('detail-sperparts.index', compact('detailsperparts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('detail-sperparts.create');
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
        
        detailSperpart::create($requestData);

        Session::flash('flash_message', 'detailSperpart added!');

        return redirect('detail-sperparts');
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
        $detailsperpart = detailSperpart::findOrFail($id);

        return view('detail-sperparts.show', compact('detailsperpart'));
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
        $detailsperpart = detailSperpart::findOrFail($id);

        return view('detail-sperparts.edit', compact('detailsperpart'));
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
        
        $detailsperpart = detailSperpart::findOrFail($id);
        $detailsperpart->update($requestData);

        Session::flash('flash_message', 'detailSperpart updated!');

        return redirect('detail-sperparts');
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
        detailSperpart::destroy($id);

        Session::flash('flash_message', 'detailSperpart deleted!');

        return redirect('detail-sperparts');
    }
}
