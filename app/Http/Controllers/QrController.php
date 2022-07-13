<?php

namespace App\Http\Controllers;

use App\Models\Fea;
use App\Models\QrItems;
use App\Models\qrtagging;
use App\Models\SerialPropertyCode;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class QrController extends Controller
{
    public function printing($id)
    {
        return view('property.qr-printing', compact('id'));
    }


    public function transaction($id)
    {
        return view('property.qr-trans', compact('id'));
    }


    public function status_c($id)
    {
        return view('custodian.qr-status', compact('id'));
    }

    public function create()
    {
        return view('custodian.qr-create');
    }

    public function logs($id)
    {
        return view('property.qr-logs', compact('id'));
    }


    public function fea($id)
    {
        $items = SerialPropertyCode::where('fea_number', $id)->get();
        $subdept = (Fea::where('fea_number', $id)->first())->subdept_code;

        $customPaper = array(0, 0, 115, 130);
        $pdf = PDF::setPaper($customPaper)->loadView('pdf-form.fea-qr', compact('items', 'subdept'));
        return $pdf->stream('fea' . $id . 'ItemsQRCodes.pdf');
    }


    public function QRpdf($id)
    {
        $items = QrItems::where('rqr_number', $id)->where('item_status', 'Approved')->get();

        $subdept = (qrtagging::where('rqr_number', $id)->first())->subdept_code;

        $customPaper = array(0, 0, 115, 130);
        $pdf = PDF::setPaper($customPaper)->loadView('pdf-form.qr-request', compact('items', 'subdept'));

        return $pdf->download('rqr' . $id . '-subdept' . $subdept . '-qrcodes.pdf');
    }

    //ENDDDDDD
}
