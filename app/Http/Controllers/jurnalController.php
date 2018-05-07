<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\jurnal;
use Illuminate\Http\Request;
use Session;

class jurnalController extends Controller
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
            $jurnal = jurnal::where('tgl', 'LIKE', "%$keyword%")
				->orWhere('keterangan', 'LIKE', "%$keyword%")
				->orWhere('jenis', 'LIKE', "%$keyword%")
				->orWhere('id_periode', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $jurnal = jurnal::paginate($perPage);
        }

        return view('jurnal.index', compact('jurnal'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('jurnal.create');
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
        
        jurnal::create($requestData);

        Session::flash('flash_message', 'jurnal added!');

        return redirect('jurnal');
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
        $jurnal = jurnal::findOrFail($id);

        return view('jurnal.show', compact('jurnal'));
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
        $jurnal = jurnal::findOrFail($id);

        return view('jurnal.edit', compact('jurnal'));
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
        
        $jurnal = jurnal::findOrFail($id);
        $jurnal->update($requestData);

        Session::flash('flash_message', 'jurnal updated!');

        return redirect('jurnal');
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
        jurnal::destroy($id);

        Session::flash('flash_message', 'jurnal deleted!');

        return redirect('jurnal');
    }
}
