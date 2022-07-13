<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountabilitiesController extends Controller
{
    public function property()
    {
        return view('property.acc');
    }

    public function property_data()
    {
        //
    }



    //Custodian
    public function custodian()
    {
        return view('custodian.myacc');
    }

    public function custodian_data()
    {
        //
    }
}
