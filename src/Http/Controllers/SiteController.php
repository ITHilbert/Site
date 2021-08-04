<?php

namespace ITHilbert\Site\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use ITHilbert\Site\Entities\Site;
use ITHilbert\LaravelKit\Helpers\HButton;
use Yajra\DataTables\Facades\DataTables;

class SiteController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $data = Site::latest()->where('deleted_at', NULL)->get();

        if ($request->ajax()) {
            $user = Auth::user(); // find(Auth::id());
            return Datatables::of($data)
                    /* ->addIndexColumn() */
 /*                    ->addColumn('cname', function($row){
                            return $row->getName();
                    }) */
                    ->addColumn('action', function($row) use ($user){
                        $ausgabe = '<div style="white-space: nowrap;">';
                            //$ausgabe .= HButton::show(route('permission.show', $row->ID), '');
                            if($user->hasPermission('site_edit')){
                                $ausgabe .= HButton::edit(route('site.edit', $row->ID), '');
                            }
                            if($user->hasPermission('site_delete')){
                                $ausgabe .= HButton::delete($row->ID, '');
                            }

                        $ausgabe .= '</div>';

                        return $ausgabe;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }


        return view('site::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('site::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $site = Site::create($request->all());

        return redirect()->route('site')->with([
            'message'    => 'Die Site wurde erfolgreich angelegt',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('site::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $site = Site::find($id);
        return view('site::edit')->with(compact('site'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {

        $site = Site::find($id);
        $site->fill($request->all());
        $site->update();

        return redirect()->route('site')->with([
            'message'    => 'Die Site wurde erfolgreich angepasst',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function delete($id)
    {
        $site = Site::find($id);
        $site->delete();

        return redirect()->route('site')->with([
            'message'    => 'Die Site wurde erfolgreich gelöscht',
            'alert-type' => 'success',
        ]);
    }
}
