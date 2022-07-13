<?php

namespace App\Http\Controllers;

use App\Models\FurnitureItem;
use App\Models\RoleUser;
use App\Models\SubDepartment;
use App\Models\TransferFurniture;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransferFurnitureController extends Controller
{
    public function create()
    {
        return view('custodian.rtf-create');
    }


    public function status_c($id)
    {
        return view('custodian.rtf-status', compact('id'));
    }

    public function sign_c($id)
    {
        return view('custodian.rtf-sign', compact('id'));
    }

    public function received($id)
    {
        return view('custodian.rtf-received', compact('id'));
    }


    //Property
    public function status_p($id)
    {
        return view('property.rtf-status', compact('id'));
    }

    public function sign_p($id)
    {
        return view('property.rtf-sign', compact('id'));
    }

    public function post($id)
    {
        return view('property.rtf-post', compact('id'));
    }


    //Finance
    public function status_f($id)
    {
        return view('finance.rtf-status', compact('id'));
    }

    public function sign_f($id)
    {
        return view('finance.rtf-sign', compact('id'));
    }

    public function pdf($rtf)
    {
        $id = Auth::user()->id;
        $role = RoleUser::where('user_id', $id)->first();

        switch ($role->role_id) {
            case 3:
            case "3":
                try {
                    $rr = TransferFurniture::where('from', Auth::user()->school_id)
                        ->orWhere('custodian', Auth::user()->school_id)
                        ->where('rtf_number', $rtf)->first();
                } catch (Exception $e) {
                    return abort(404);
                }

                break;
            case 2:
            case "2":
            case 6:
            case "6":
                try {
                    $rr = TransferFurniture::where('rtf_number', $rtf)->first();
                } catch (Exception $e) {
                    return abort(404);
                }
                break;

            default:
                return abort(404);
                break;
        }

        if (!empty($rr)) {
            $item = FurnitureItem::where('transfer_furniture_id', $rr->id)->get();

            if (!empty($rr->from)) {
                $rby = User::where('school_id', $rr->from)->first();
                $from = $rby->first_name . ' ' . $rby->last_name;
                $from_date = $rr->received_date;
                $from_sig = $rby->signature_path;
            }

            if (!empty($rr->dept_head)) {
                $rby = User::where('school_id', $rr->dept_head)->first();
                $to = $rby->first_name . ' ' . $rby->last_name;
                $to_date = $rr->received_date;
                $to_sig = $rby->signature_path;
            }


            if (!empty($rr->checkedby)) {
                $cby = User::where('school_id', $rr->checkedby)->first();
                $checkedby = $cby->first_name . ' ' . $cby->last_name;
                $cby_date = $rr->checked_date;
                $cby_sig = $cby->signature_path;
            }

            if (!empty($rr->approvedby)) {
                $aby = User::where('school_id', $rr->approvedby)->first();
                $apby = $aby->first_name . ' ' . $aby->last_name;
                $aby_date = $rr->evaluated_date;
                $aby_sig = $aby->signature_path;
            }


            if (!empty($item)) {
                $bby = User::whereRoleIs('BFMO')->first();
                $bpby = substr($bby->first_name, 0, 1) . '. ' . $bby->last_name;
                $bby_date = $rr->evaluated_date;
                $bby_sig = $bby->signature_path;

                $iby = User::whereRoleIs('ICTC')->first();
                $ipby = substr($iby->first_name, 0, 1) . '. ' . $iby->last_name;
                $iby_date = $rr->evaluated_date;
                $iby_sig = $iby->signature_path;
            }


            if (!empty($rr->subdept_code)) {
                $subdept = (SubDepartment::where('subdept_code', $rr->subdept_code)->first())
                    ->description;
            }

            $val[] = array(
                'rdf' => $rr,
                'item' => $item,
                'subdept' => $subdept,
                'from' => $from,
                'from_sig' => $from_sig,
                'cname' => $checkedby . ' / ' . $cby_date,
                'cby_sig' =>  $cby_sig,
                'aname' =>  $apby . ' / ' . $aby_date,
                'aby_sig' => $aby_sig,
                'ename' => $checkedby . ' / ' . $cby_date,
                'eby_sig' => $cby_sig,
                'tname' => $to,
                'tby_sig' => $to_sig,
                'bname' => $bpby,
                'bby_sig' => $bby_sig,
                'iname' => $ipby,
                'iby_sig' => $iby_sig,
            );

            $pdf = Pdf::loadView('pdf-form.rtf', compact('val'))
                ->download('rtf-' . $rtf . '.pdf');
            return $pdf;
        } else {
            return abort(404);
        }
    }
}
