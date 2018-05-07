<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\periodeAkun;
use Illuminate\Http\Request;
use Session;

class periodeAkunController extends Controller
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
            $periodeakun = periodeAkun::where('id_periode', 'LIKE', "%$keyword%")
				->orWhere('nomor_akun', 'LIKE', "%$keyword%")
				->orWhere('saldo_akhir', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $periodeakun = periodeAkun::paginate($perPage);
        }

        return view('periode-akun.index', compact('periodeakun'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('periode-akun.create');
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
        
        periodeAkun::create($requestData);

        Session::flash('flash_message', 'periodeAkun added!');

        return redirect('periode-akun');
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
        $periodeakun = periodeAkun::findOrFail($id);

        return view('periode-akun.show', compact('periodeakun'));
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
        $periodeakun = periodeAkun::findOrFail($id);

        return view('periode-akun.edit', compact('periodeakun'));
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
        
        $periodeakun = periodeAkun::findOrFail($id);
        $periodeakun->update($requestData);

        Session::flash('flash_message', 'periodeAkun updated!');

        return redirect('periode-akun');
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
        periodeAkun::destroy($id);

        Session::flash('flash_message', 'periodeAkun deleted!');

        return redirect('periode-akun');
    }
}
