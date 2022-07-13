<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Records extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = "";
        return view('forms.record', compact('id'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('forms.record', compact('id'));
    }
}
