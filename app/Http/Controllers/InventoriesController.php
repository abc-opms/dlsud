<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\InventoryItems;
use App\Models\RoleUser;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class InventoriesController extends Controller
{
    public function create()
    {
        return view('property.inv_create');
    }

    public function logs()
    {
        return view('property.inv-logs');
    }



    public function monitor($id)
    {
        return view('property.inv-monitor', compact('id'));
    }


    public function custodian($id)
    {
        return view('custodian.inventory', compact('id'));
    }



    //PDF
    public function pdf($inv)
    {
        $id = Auth::user()->id;
        $role = RoleUser::where('user_id', $id)->first();

        switch ($role->role_id) {
            case 3:
            case "3":
                try {
                    $rr = Inventory::where('receivedby', Auth::user()->school_id)
                        ->where('inv_number', $inv)->first();
                } catch (Exception $e) {
                    return abort(404);
                }

                break;
            case 2:
            case "2":
            case 6:
            case "6":
                try {
                    $rr = Inventory::where('inv_number', $inv)->first();
                } catch (Exception $e) {
                    return abort(404);
                }
                break;

            default:
                return abort(404);
                break;
        }

        if (!empty($rr)) {
            $item = InventoryItems::where('inv_number', $rr->inv_number)->get();

            if (!empty($rr->receivedby)) {
                $rby = User::where('school_id', $rr->receivedby)->first();
                $rname = $rby->first_name . ' ' . $rby->last_name;
                $r_date = $rr->received_date;
                $r_sig = $rby->signature_path;
            }


            if (!empty($rr->countedby)) {
                $pby = User::where('school_id', $rr->countedby)->first();
                $cname = $pby->first_name . ' ' . $pby->last_name;
                $c_date = $rr->counted_date;
                $c_sig = $pby->signature_path;
            }


            $val[] = array(
                'rdf' => $rr,
                'item' => $item,
                'rname' => $rname,
                'r_sig' => $r_sig,
                'cname' => $cname,
                'c_date' => $c_date,
                'c_sig' => $c_sig,
            );

            $pdf = PDF::loadView('pdf-form.inventory', compact('val'))->stream('rr.pdf');
            return $pdf;
        } else {
            return abort(404);
        }
    }
}
