<?php

namespace App\Http\Controllers;

use App\Models\Fea;
use App\Models\Receivingreports;
use App\Models\RoleUser;
use App\Models\Rritems;
use App\Models\SerialPropertyCode;
use App\Models\SubDepartment;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Support\Facades\Auth;

class FeaController extends Controller
{
    //Custodian
    public function transaction_c($id)
    {
        return view('custodian.fea-sign', compact('id'));
    }


    public function status_c($id)
    {
        return view('custodian.fea-status', compact('id'));
    }


    //Property
    public function transaction($id)
    {
        return view('property.fea-sign', compact('id'));
    }


    public function status($id)
    {
        return view('property.fea-status', compact('id'));
    }

    public function create($id)
    {
        return view('property.fea-create', compact('id'));
    }


    public function pdf($id)
    {
        $user = Auth::user()->id;
        $role = RoleUser::where('user_id', $user)->first();

        switch ($role->role_id) {
            case 3:
            case "3":
                try {
                    $fea = Fea::where('fea_number', $id)->first();
                } catch (Exception $e) {
                    return abort(404);
                }

                break;
            case 2:
            case "2":
            case 6:
            case "6":
                try {
                    $fea = Fea::where('fea_number', $id)->first();
                } catch (Exception $e) {
                    return abort(404);
                }
                break;

            default:
                return abort(403);
                break;
        }


        if (!empty($fea->checkedby)) {
            $cby = User::where('school_id', $fea->checkedby)->first();
            $checkedby = $cby->first_name . ' ' . $cby->last_name;
            $cby_date = $fea->prepared_date;
            $cby_sig = $cby->signature_path;
        }

        if (!empty($fea->notedby)) {
            $nby =  $checkedby;
            $nby_date = $fea->noted_date;
            $nby_sig = $cby_sig;
        }

        if (!empty($fea->recordedby)) {
            $rby =  $checkedby;
            $rby_date = $fea->recorded_date;
            $rby_sig = $cby_sig;
        }


        if (!empty($fea->rnotedby)) {
            $r = User::where('school_id', $fea->rnotedby)->first();
            $rnby =  $r->first_name . ' ' . $r->last_name;
            $rnby_date = $fea->rnoted_date;
            $rnby_sig = $r->signature_path;
        }

        if (!empty($fea->receivedby)) {
            $reby =  $rnby;
            $reby_date = $fea->received_date;
            $reby_sig = $rnby_sig;
        }

        if (!empty($fea->rr_number)) {
            $rr = Receivingreports::where('rr_number', $fea->rr_number)->first();
            $po = $rr->ponum . '-' . $rr->rr_number;
            $ddate = $rr->delivery_date;
            $idate = $rr->invoice_date;
            $invoice = $rr->invoice;
            $s = $rr->supplier_code;
            $rritems = Rritems::where('rr_number', $rr->rr_number)->get();
            if (!empty($s)) {
                $sup = Supplier::where('supplier_code', $s)->first();
                $sname = $sup->name;
                $sadd = $sup->address;
                $telnum = $sup->telnum . ' / ' . $sup->telnum;
                $faxnum =  $sup->faxnum . ' / ' . $sup->faxnum_al;
            }
        }


        if (!empty($fea->subdept_code)) {
            $sub = SubDepartment::where('subdept_code', $fea->subdept_code)->first();
            $sbname = $sub->description;
        }

        $items = SerialPropertyCode::where('fea_number', $fea->fea_number)->get();

        $val[] = array(
            'feanum' => $fea->fea_number,
            'po' => $po,
            'ddate' => $ddate,
            'idate' => $idate,
            'invoice' => $invoice,
            'items' => $items,
            'rritems'  => $rritems,
            'subdept' => $fea->subdept_code,
            'dept' => $fea->dept_code,
            'sbname' =>  $sbname,

            'sname' => strtoupper($sname),
            'sadd' => $sadd,
            'telnum' => $telnum,
            'faxnum' => $faxnum,

            'cbyname' => $checkedby,
            'cbydate' => $cby_date,
            'cby' => $cby_sig,

            'nbyname' => $nby,
            'nbydate' => $cby_date,
            'nby' => $cby_sig,

            'rbyname' => $rby,
            'rbydate' => $rby_date,
            'rby' => $rby_sig,

            'rnbyname' => $rnby,
            'rnbydate' => $rnby_date,
            'rnby' => $rnby_sig,


            'rebyname' => $reby,
            'rebydate' => $reby_date,
            'reby' => $reby_sig,
        );


        $pdf = PDF::setPaper('Letter',  'Portrait')->loadView('pdf-form.fea', compact('val'));
        return $pdf->stream('fea' . $id . 'ItemsQRCodes.pdf');
    }
}
