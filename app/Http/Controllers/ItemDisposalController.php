<?php

namespace App\Http\Controllers;

use App\Models\DisposalItem;
use App\Models\ItemDisposal;
use App\Models\RoleUser;
use App\Models\SubDepartment;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ItemDisposalController extends Controller
{
    public function create()
    {
        return view('custodian.itemd-create');
    }

    public function status_c($id)
    {
        return view('custodian.itemd-status', compact('id'));
    }




    //Property
    public function sign_p($id)
    {
        return view('property.itemd-sign', compact('id'));
    }
    public function status_p($id)
    {
        return view('property.itemd-status', compact('id'));
    }
    public function post($id)
    {
        return view('property.itemd-post', compact('id'));
    }


    //Finance
    public function sign_f($id)
    {
        return view('finance.itemd-sign', compact('id'));
    }
    public function status_f($id)
    {
        return view('finance.itemd-status', compact('id'));
    }


    //WAREHOUSE
    public function sign_w($id)
    {
        return view('warehouse.itemd-sign', compact('id'));
    }
    public function status_w($id)
    {
        return view('warehouse.itemd-status', compact('id'));
    }

    //PDF
    public function pdf($rdf)
    {
        $id = Auth::user()->id;
        $role = RoleUser::where('user_id', $id)->first();

        switch ($role->role_id) {
            case 3:
            case "3":
                try {
                    $rr = ItemDisposal::where('from', Auth::user()->school_id)
                        ->where('rdf_number', $rdf)->first();
                } catch (Exception $e) {
                    return abort(404);
                }

                break;
            case 2:
            case "2":
            case 6:
            case "6":
                try {
                    $rr = ItemDisposal::where('rdf_number', $rdf)->first();
                } catch (Exception $e) {
                    return abort(404);
                }
                break;

            default:
                return abort(404);
                break;
        }

        if (!empty($rr)) {
            $item = DisposalItem::where('item_disposal_id', $rr->id)->get();

            if (!empty($rr->from)) {
                $rby = User::where('school_id', $rr->from)->first();
                $from = $rby->first_name . ' ' . $rby->last_name;
                $from_date = $rr->received_date;
                $from_sig = $rby->signature_path;
            }


            if (!empty($rr->endorsedto)) {
                $pby = User::where('school_id', $rr->endorsedto)->first();
                $endorsedto = $pby->first_name . ' ' . $pby->last_name;
                $e_date = $rr->prepared_date;
                $e_sig = $pby->signature_path;
            }

            if (!empty($rr->checkedby)) {
                $cby = User::where('school_id', $rr->checkedby)->first();
                $checkedby = $cby->first_name . ' ' . $cby->last_name;
                $cby_date = $rr->checked_date;
                $cby_sig = $cby->signature_path;
            }

            if (!empty($rr->evaluatedby)) {
                $ev = User::where('school_id', $rr->evaluatedby)->first();
                $evby = $ev->first_name . ' ' . $ev->last_name;
                $evby_date = $rr->evaluated_date;
                $evby_sig = $ev->signature_path;
            }

            if (!empty($rr->approvedby)) {
                $aby = User::where('school_id', $rr->approvedby)->first();
                $apby = $aby->first_name . ' ' . $aby->last_name;
                $aby_date = $rr->evaluated_date;
                $aby_sig = $aby->signature_path;
            }

            if (!empty($rr->subdept_code)) {
                $subdept = (SubDepartment::where('subdept_code', $rr->subdept_code)->first())
                    ->description;
                $date = $rr->date;
            }

            $val[] = array(
                'rdf' => $rr,
                'item' => $item,
                'subdept' => $subdept,
                'date' => $date,
                'from' => $from,
                'from_sig' => $from_sig,
                'cname' => $checkedby . ' / ' . $cby_date,
                'cby_sig' =>  $cby_sig,
                'drname' => $endorsedto . ' / ' . $e_date,
                'drby_sig' => $e_sig,
                'aname' =>  $apby . ' / ' . $aby_date,
                'aby_sig' => $aby_sig,
                'ename' => $evby . ' / ' . $evby_date,
                'eby_sig' => $evby_sig,
            );

            $pdf = PDF::loadView('pdf-form.rdf', compact('val'))->download('rdf-' . $rdf . '.pdf');
            return $pdf;
        } else {
            return abort(404);
        }
    }
}
