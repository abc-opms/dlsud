<?php

namespace App\Http\Controllers;

use App\Models\Receivingreports;
use App\Models\RoleUser;
use Exception;
use App\Models\Rritems;
use App\Models\Supplier;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReceivingreportController extends Controller
{
    //Warehouse
    public function transaction($id)
    {
        return view('warehouse.rr_trans', compact('id'));
    }

    public function status($id)
    {
        return view('warehouse.rr_status', compact('id'));
    }

    public function create()
    {
        return view('warehouse.rr_create');
    }

    public function pdf($rrnum)
    {
        $id = Auth::user()->id;
        $role = RoleUser::where('user_id', $id)->first();

        switch ($role->role_id) {
            case 3:
            case "3":


                try {
                    $rr = Receivingreports::where('receivedby', Auth::user()->school_id)
                        ->where('rr_number', $rrnum)->first();
                } catch (Exception $e) {
                    return abort(404);
                }

                break;
            case 4:
            case "4":
                try {
                    $rr = Receivingreports::where('rr_number', $rrnum)->first();
                } catch (Exception $e) {
                    return abort(404);
                }
                break;

            default:
                return abort(404);
                break;
        }

        if (!empty($rr)) {
            $item = Rritems::where('rr_number', $rrnum)->get();
            if (!empty($rr->receivedby)) {
                $rby = User::where('school_id', $rr->receivedby)->first();
                $receivedby = $rby->first_name . ' ' . $rby->last_name;
                $rby_date = $rr->received_date;
                $rby_sig = $rby->signature_path;
            }


            if (!empty($rr->preparedby)) {
                $pby = User::where('school_id', $rr->preparedby)->first();
                $preparedby = $pby->first_name . ' ' . $pby->last_name;
                $pby_date = $rr->prepared_date;
                $pby_sig = $pby->signature_path;
            }

            if (!empty($rr->checkedby)) {
                $checkedby = $preparedby;
                $cby_date = $rr->checked_date;
                $cby_sig = $pby_sig;
            }

            if (!empty($rr->supplier_code)) {
                $sup = Supplier::where('supplier_code', $rr->supplier_code)->first();
                $sname = $sup->name;
                $sadd = $sup->address;
                $telnum = $sup->telnum . ' ' . $sup->telnum . ' / ' . $sup->faxnum . ' ' . $sup->faxnum_al;
                $skey = $rr->supplier_code;
            }

            $val[] = array(
                'rr' => $rr,
                'item' => $item,
                'rby_date' => $rby_date,
                'cby_date' => $cby_date,
                'pby_date' => $pby_date,
                'receivedby' => $receivedby,
                'preparedby' => $preparedby,
                'checkedby' => $checkedby,
                'rby_sig' => $rby_sig,
                'pby_sig' => $pby_sig,
                'cby_sig' => $cby_sig,
                'sname' => strtoupper($sname),
                'sadd' => $sadd,
                'telnum' => $telnum,
                'skey' => $skey,
            );

            $pdf = PDF::loadView('pdf-form.rr', compact('val'));
            return $pdf->download('rr-' . $rrnum . '.pdf');
        } else {
            return abort(404);
        }
    }



    //Custodian
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function status_c($id)
    {
        return view('custodian.rrstatus', compact('id'));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function sign_c($id)
    {
        if ($id == "logs") {
            return view('custodian.rrsign', compact('id'));
        } else {
            try {
                $val = Receivingreports::where('receivedby', Auth::user()->school_id)->where('rr_number', $id)->first();
                if (!empty($val->id)) {
                    return view('custodian.rrsign', compact('id'));
                } else {
                    return abort(404);
                }
            } catch (Exception $e) {
                return abort(404);
            }
        }
    }
}
