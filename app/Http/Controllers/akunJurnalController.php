<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\akunJurnal;
use Illuminate\Http\Request;
use Session;

class akunJurnalController extends Controller
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
            $akunjurnal = akunJurnal::where('id_jurnal', 'LIKE', "%$keyword%")
				->orWhere('nomor_akun', 'LIKE', "%$keyword%")
				->orWhere('nominal_debet', 'LIKE', "%$keyword%")
				->orWhere('nominal_kredit', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $akunjurnal = akunJurnal::paginate($perPage);
        }

        return view('akun-jurnal.index', compact('akunjurnal'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('akun-jurnal.create');
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
        
        akunJurnal::create($requestData);

        Session::flash('flash_message', 'akunJurnal added!');

        return redirect('akun-jurnal');
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
        $akunjurnal = akunJurnal::findOrFail($id);

        return view('akun-jurnal.show', compact('akunjurnal'));
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
        $akunjurnal = akunJurnal::findOrFail($id);

        return view('akun-jurnal.edit', compact('akunjurnal'));
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
        
        $akunjurnal = akunJurnal::findOrFail($id);
        $akunjurnal->update($requestData);

        Session::flash('flash_message', 'akunJurnal updated!');

        return redirect('akun-jurnal');
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
        akunJurnal::destroy($id);

        Session::flash('flash_message', 'akunJurnal deleted!');

        return redirect('akun-jurnal');
    }
}
