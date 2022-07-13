<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function generate()
    {
        return view('property.report');
    }

    public function logs()
    {
        return view('property.report-logs');
    }

    //
    public function pdf()
    {
        return view('pdf-form.report');
    }
}
