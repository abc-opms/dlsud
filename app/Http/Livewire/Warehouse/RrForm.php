<?php

namespace App\Http\Livewire\Warehouse;

use App\Mail\FormEmailNotification;
use App\Models\Account;
use App\Models\Department;
use App\Models\Receivingreports;
use App\Models\Rritems;
use App\Models\SubDepartment;
use App\Models\Supplier;
use App\Models\User;
use App\Notifications\OpmsNotification;
use Livewire\Component;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\WithFileUploads;

class RrForm extends Component
{
    use WithFileUploads;
    public $ItemArray = array(), $iteration, $showbuttonupdate, $itemid;
    public $previewreceipt, $updateRRnumPic, $oldamount;

    public $supplier_code, $delivery_date, $invoice, $invoice_date, $ponum, $dept_code,
        $receivedby, $receipt, $total, $rr_number;

    public $item, $acc_code, $oum, $unit_cost, $order_qty, $deliver_qty, $amount;
    public $preparedby, $ItemPreview, $name, $isItemSave, $rrID;


    /*-------------------------------------------------------------------
     Save RR
    -------------------------------------------------------------------*/


    public function closeRR()
    {
        if (
            empty($this->supplier_code) && empty($this->delivery_date) &&
            empty($this->invoice) && empty($this->invoice_date) && empty($this->ponum)  &&
            empty($this->dept_code) && empty($this->receivedby) && empty($this->total) &&
            empty($this->receipt) && empty($this->ItemArray)
        ) {
            return redirect('/receivingreport/sign/logs');
        } else {
            $this->dispatchBrowserEvent('openRrForm');
        }
    }

    public function yes()
    {
        $this->clearItem();
        $this->clearItem();
        $this->dispatchBrowserEvent('closeRrForm');
        return redirect('/receivingreport/sign/logs');
    }


    public function esign()
    {
        $date = Carbon::now()->format('m/d/y');
        $v = Auth::user()->first_name . " " . Auth::user()->last_name . ' / ' . $date;
        $this->preparedby = $v;
    }

    public function clearesign()
    {
        $this->preparedby = null;
    }


    /*-------------------------------------------------------------------
     Save RR
    -------------------------------------------------------------------*/

    public function saveRR()
    {
        try {
            $this->validate($this->rrRules());
            if (!empty($this->preparedby)) {
                $this->createRRid();

                $tempid = Receivingreports::create($this->saveData());
                $this->rrID = $tempid->id;

                $this->saveItems();

                if ($this->isItemSave == true) {
                    if (!empty($this->receipt)) {
                        $this->receipt->store('public/receipt');
                    }

                    $this->notif();
                    $this->sendEmail();

                    $this->clearItem();
                    $this->clearTop();

                    $this->dispatchBrowserEvent('swal_mode', [
                        'text' => 'Saved.',
                        'type' => 'success',
                        'w' => 300,
                        'timer' => 2000,
                    ]);
                    return redirect('/receivingreport/sign/logs');
                }
            } else {
                $this->dispatchBrowserEvent('swal_mode', [
                    'text' => 'Signature is required.',
                    'type' => 'warning',
                    'w' => 300,
                    'timer' => 2000,
                ]);
            }
        } catch (Exception $e) {
            //error message
            $this->dispatchBrowserEvent('swal_mode', [
                'text' => 'Something went wrong. Please try again later.',
                'type' => 'warning',
                'w' => 400,
                'timer' => 4000,
            ]);
        }
    }

    public function saveData()
    {
        return [
            'rr_number' => $this->rr_number,
            'supplier_code' => $this->supplier_code,
            'delivery_date' => $this->delivery_date,
            'ponum' => $this->ponum,
            'invoice' => $this->invoice,
            'invoice_date' => $this->invoice_date,
            'receipt_photo_path' => $this->receipt->hashName(),
            'total' => $this->total,
            'preparedby' => Auth::user()->school_id,
            'prepared_date' => Carbon::now(),
            'dept_code' => $this->dept_code,
            'status' => "Active",
            'receivedby' => $this->receivedby,
        ];
    }

    /*-------------------------------------------------------------------
     CREATE RR ID
    -------------------------------------------------------------------*/

    public function createRRid()
    {
        $val = date("Y");

        $num = Receivingreports::count();

        if ($num == 0 || $num == null) {
            $rrid = 1;
        } else {
            $rrid = $num + 1;
        }

        $count = strlen($rrid);

        if ($count == "1")
            $val .= "000";
        if ($count == "2")
            $val .= "00";
        if ($count == "3")
            $val .= "0";

        $val .= $rrid;
        $this->rr_number = "$val";
    }

    public function saveItems()
    {
        try {
            foreach ($this->ItemArray as $i) {
                Rritems::create(
                    [
                        'receivingreport_id' => $this->rrID,
                        'item_description' => $i['item'],
                        'name' => $i['name'],
                        'acc_code' => $i['acc_code'],
                        'oum' => $i['oum'],
                        'unit_cost' => $i['unit_cost'],
                        'order_qty' => $i['order_qty'],
                        'deliver_qty' => $i['deliver_qty'],
                        'amount' => $i['amount'],
                        'rr_number' => $this->rr_number,
                        'acq_date' => $this->invoice_date,
                    ]
                );
            }
            $this->isItemSave = true;
        } catch (Exception $e) {
            $this->isItemSave = false;

            //delete RR
            try {
                Receivingreports::where('id', $this->rrID)->delete();
            } catch (Exception $e) {
                //
            }

            //error message
            $this->dispatchBrowserEvent('swal_mode', [
                'text' => 'Something went wrong. Please try again later.',
                'type' => 'warning',
                'w' => 400,
                'timer' => 3000,
            ]);
        }
    }

    /*-------------------------------------------------------------------
     SEND EMAIL
    -------------------------------------------------------------------*/

    public function sendEmail()
    {
        try {
            $emailto = User::where('school_id', $this->receivedby)->first();
            $subject = "New Receiving report form has been created.";
            $form_type = "Receiving report";
            $form_number = $this->rr_number;
            $link = "http://127.0.0.1:8000/c/receivingreport/sign/" . $this->rr_number;
            $s = "Active";

            Mail::to($emailto->email)->queue(new FormEmailNotification($subject, $form_type, $form_number, $link, $s));
            $emailto = User::where('school_id', $this->receivedby)->first();
            $subject = "New Receiving report form has been created.";
            $form_type = "Receiving report";
            $form_number = $this->rr_number;
            $link = "http://127.0.0.1:8000/c/receivingreport/sign/" . $this->rr_number;
            $s = "Active";

            Mail::to($emailto->email)->queue(new FormEmailNotification($subject, $form_type, $form_number, $link, $s));
        } catch (Exception $e) {
            //
        }
    }


    public function notif()
    {
        try {
            $s = "Active";
            $type = 'Receiving Report';
            $message =  "A new receiving report has been created by the Warehouse personnel.";
            $link = '/c/receivingreport/sign/' . $this->rr_number;
            $user = User::where('school_id', $this->receivedby)->first();

            Notification::send($user, new OpmsNotification($type, $message, $link, $s));
        } catch (Exception $e) {
            //
        }
    }

    /*-------------------------------------------------------------------
     Preview The whole RR before saving
    -------------------------------------------------------------------*/

    public function preview()
    {
        if (!empty($this->preparedby)) {
            $this->validate($this->rrRules());
            if (count($this->ItemArray) >= 1) {
                try {
                    $data = Supplier::where('supplier_code', $this->supplier_code)->first();
                    $this->sid = $this->supplier_code;
                    $this->sname = $data->name;
                    $this->saddress = $data->address;
                    $this->stelnum = $data->telnum . " / "  . $data->faxnum;

                    $this->r_ddate = $this->delivery_date;
                    $this->r_ponum = $this->ponum;
                    $this->r_invoice = $this->invoice;
                    $this->r_idate = $this->invoice_date;
                    $this->ItemPreview = $this->ItemArray;
                    $this->dept = $this->dept_code;
                    try {
                        $rby = User::where('school_id', $this->receivedby)->first();
                        $this->rby = $rby->first_name . ' ' . $rby->last_name;
                        $this->dispatchBrowserEvent('open-modalRR');
                    } catch (Exception $e) {
                        $this->dispatchBrowserEvent('swal_mode', [
                            'text' => 'Received by field is empty.',
                            'type' => 'warning',
                            'w' => 300,
                            'timer' => 3000,
                        ]);
                    }
                } catch (Exception $e) {
                    //Popup message for error
                    $this->dispatchBrowserEvent('swal_mode', [
                        'text' => 'Please make sure you fill out all the fields.',
                        'type' => 'warning',
                        'w' => 300,
                        'timer' => 4000,
                    ]);
                }
            } else {
                //Popup message for error
                $this->dispatchBrowserEvent('swal_mode', [
                    'text' => 'Please input item.',
                    'type' => 'warning',
                    'w' => 300,
                    'timer' => 3000,
                ]);
            }
        } else {
            $this->dispatchBrowserEvent('swal_mode', [
                'text' => 'Signature is required.',
                'type' => 'warning',
                'w' => 300,
                'timer' => 2000,
            ]);
        }
    }


    /*-------------------------------------------------------------------
     Preview Receipt Image
    -------------------------------------------------------------------*/


    public function updatedReceipt()
    {
        $this->clickpreview = null;
        $this->previewreceipt = null;
        if ($this->validate([
            'receipt' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ])) {
            $this->clickpreview = "true";
            $this->cancelChangeReceipt  = null;
        }
    }
    public function showReceipt()
    {
        $this->previewreceipt = "true";
        $this->cancelChangeReceipt  = null;
    }

    public function closeReceipt()
    {
        $this->previewreceipt = null;
    }


    /*-------------------------------------------------------------------
     Delete Item to Array
    -------------------------------------------------------------------*/


    public function deleteItem($id)
    {
        try {
            $this->total -= $this->amount;
            unset($this->ItemArray[$id]);
            $this->clearItem();
            $this->copyArray();
        } catch (Exception $e) {
            $this->dispatchBrowserEvent('swal_mode', [
                'text' => 'Something went wrong. Please try again later.',
                'type' => 'error',
                'w' => 300,
                'timer' => 2000,
            ]);
        }
    }

    public function copyArray()
    {
        $array2 = array();

        foreach ($this->ItemArray as $i) {
            $array2[] = array(
                'item' => $i['item'],
                'name' => $i['name'],
                'acc_code' => $i['acc_code'],
                'oum' => $i['oum'],
                'unit_cost' => $i['unit_cost'],
                'order_qty' => $i['order_qty'],
                'deliver_qty' => $i['deliver_qty'],
                'amount' => $i['amount'],
            );
        }
        $this->ItemArray = array();

        foreach ($array2 as $i) {
            $this->ItemArray[] = array(
                'item' => $i['item'],
                'name' => $i['name'],
                'acc_code' => $i['acc_code'],
                'oum' => $i['oum'],
                'unit_cost' => $i['unit_cost'],
                'order_qty' => $i['order_qty'],
                'deliver_qty' => $i['deliver_qty'],
                'amount' => $i['amount'],
            );
        }
        $array2 = array();
    }

    /*-------------------------------------------------------------------
     Edit Item to Array
    -------------------------------------------------------------------*/

    public function updatesaveItems($id)
    {
        try {
            $this->validate($this->itemRule());
            $this->updatedataItem($id);
            $this->total = ($this->total - $this->oldamount) +  $this->amount;
            $this->clearItem();
        } catch (Exception $e) {
            //error message
            $this->dispatchBrowserEvent('swal_mode', [
                'text' => 'Something went wrong. Please try again later.',
                'type' => 'warning',
                'w' => 400,
                'timer' => 3000,
            ]);
        }
    }

    public function updatedataItem($id)
    {
        $this->ItemArray[$id] = array(
            'item' => $this->item,
            'name' => $this->name,
            'acc_code' => $this->acc_code,
            'oum' => $this->oum,
            'unit_cost' => floatval($this->unit_cost),
            'order_qty' => floatval($this->order_qty),
            'deliver_qty' => floatval($this->deliver_qty),
            'amount' => floatval($this->amount),
        );
    }



    /** EDIT */
    public function showItemdata($i)
    {
        try {
            $this->itemid = $i;
            $this->showbuttonupdate = "true";

            $this->item = $this->ItemArray[$i]['item'];
            $this->acc_code = $this->ItemArray[$i]['acc_code'];
            $this->name = $this->ItemArray[$i]['name'];;
            $this->oum = $this->ItemArray[$i]['oum'];
            $this->unit_cost = $this->ItemArray[$i]['unit_cost'];
            $this->order_qty = $this->ItemArray[$i]['order_qty'];
            $this->deliver_qty = $this->ItemArray[$i]['deliver_qty'];
            $this->amount = $this->ItemArray[$i]['amount'];
            $this->oldamount = $this->ItemArray[$i]['amount'];
        } catch (Exception $e) {
            //error message
            $this->dispatchBrowserEvent('swal_mode', [
                'text' => 'Something went wrong. Please try again later.',
                'type' => 'warning',
                'w' => 400,
                'timer' => 3000,
            ]);
        }
    }


    /*-------------------------------------------------------------------
     Save Item to Array
    -------------------------------------------------------------------*/


    public function saveItem()
    {
        try {
            $this->validate($this->itemRule());
            $this->dataItem();
            $this->total += $this->amount;
            $this->clearItem();
        } catch (Exception $e) {
            //error message
            $this->dispatchBrowserEvent('swal_mode', [
                'text' => 'Something went wrong. Please try again later.',
                'type' => 'warning',
                'w' => 400,
                'timer' => 3000,
            ]);
        }
    }


    public function dataItem()
    {
        $this->ItemArray[] = array(
            'item' => $this->item,
            'name' => $this->name,
            'acc_code' => $this->acc_code,
            'oum' => $this->oum,
            'unit_cost' => floatval($this->unit_cost),
            'order_qty' => floatval($this->order_qty),
            'deliver_qty' => floatval($this->deliver_qty),
            'amount' => floatval($this->amount),
        );
    }

    public function updateAmount()
    {
        $this->amount = $this->deliver_qty * $this->unit_cost;
    }


    /*-------------------------------------------------------------------
     Validation
    -------------------------------------------------------------------*/

    public function rrRules()
    {
        return [
            'supplier_code' => 'required',
            'delivery_date' => 'required',
            'invoice' => 'required',
            'invoice_date' => 'required',
            'ponum' => 'required',
            'dept_code' => 'required',
            'receivedby' => 'required',
            'receipt' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }


    public function itemRule()
    {
        return [
            'deliver_qty' => 'required',
            'acc_code' => 'required',
            'oum' => 'required',
            'unit_cost' => 'required',
            'order_qty' => 'required',
            'amount' => 'required',
            'item' => 'required',
            'name' => 'required'
        ];
    }


    /*-------------------------------------------------------------------
     Clear Fields
    -------------------------------------------------------------------*/

    public function clearTop()
    {
        $this->supplier_code = null;
        $this->delivery_date = null;
        $this->invoice = null;
        $this->invoice_date = null;
        $this->ponum = null;
        $this->dept_code = null;
        $this->receivedby = null;
        $this->receipt = null;

        $this->previewreceipt = null;
        $this->updateRRnumPic = null;
        $this->iteration = null;

        $this->ItemArray =  array();
        $this->preparedby = null;

        $this->ItemPreview = null;
    }

    public function clearItem()
    {
        $this->item = null;
        $this->acc_code = null;
        $this->oum = null;
        $this->unit_cost = null;
        $this->order_qty = null;
        $this->deliver_qty = null;
        $this->amount = null;
        $this->name = null;

        $this->itemid = null;
        $this->showbuttonupdate = null;
        $this->oldamount = null;
        $this->resetValidation($this->itemRule());
    }


    /*-------------------------------------------------------------------
     RENDER
    -------------------------------------------------------------------*/

    public function render()
    {
        $supp = Supplier::all();

        $department = User::select('dept_code')->whereRoleIs('Custodian')
            ->groupBy('dept_code')->get();

        $acc = Account::orderBy('description', 'asc')->get();

        $custodian = User::whereRoleIs('Custodian')->where('dept_code', 'like', '%' . $this->dept_code . '%')->get();

        return view('livewire.warehouse.rr-form', [
            'supp' => $supp,
            'department' => $department,
            'items' => $this->ItemArray,
            'custodian' => $custodian,
            'accounts' => $acc,
        ]);
    }
}
