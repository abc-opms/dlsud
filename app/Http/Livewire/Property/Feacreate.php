<?php

namespace App\Http\Livewire\Property;

use App\Mail\FormEmailNotification;
use App\Models\Department;
use App\Models\Fea;
use App\Models\Receivingreports;
use App\Models\Rritems;
use App\Models\SerialPropertyCode;
use App\Models\SubDepartment;
use App\Models\Supplier;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithPagination;
use App\Notifications\OpmsNotification;
use Illuminate\Support\Facades\Notification;

class Feacreate extends Component
{
    use WithPagination;
    public $search, $pp_position;
    public $hideRRnum, $fea_rrnum;
    public $name, $address, $telnum, $faxnum;
    public $snNum, $openTransaction;
    public $serialnum, $propertycode;
    public $qty, $item, $pr, $itemID, $totalAmount;
    public $checkedby, $fea_number, $custodianRBY, $rrnum;
    public $snum, $sID, $department, $dept_name, $subdept;
    public $serialID = array(), $Itemname, $serial, $pcs, $receivedby, $rby, $acq_date;



    public function mount($id)
    {
        if ($id == "logs") {
            //
        } else {
            $inv = Receivingreports::where('status', 'Done')->where('rr_number', $id)->first();
            if (!empty($inv)) {
                $this->createFEA($id);
            } else {
                return abort(404);
            }
        }
    }



    /*-------------------------------------------------------------------
    
     -------------------------------------------------------------------*/

    /**
     * from create FEA button
     * hide the list of RR numbers
     * show the FEA form
     *
     * @return void
     */
    public function createFEA($val)
    {
        $this->clearVals();
        $this->hideRRnum = "true";
        $this->fea_rrnum = $val;
        $this->showValues($val);
        $this->createpropertycode($val);
    }

    public function closecreateFEA()
    {
        $this->hideRRnum = null;
        $this->clearVals();
        $this->dispatchBrowserEvent('changeURL', [
            'entURL' =>  'logs',
        ]);
    }
    /*---------------------------------------------------------------
    Generate Property Codes
    ----------------------------------------------------------------*/

    public function createpropertycode($val)
    {
        $feaItem = Rritems::where('rr_number', $val)->get();
        foreach ($feaItem as $fi) {
            $b = SerialPropertyCode::where('rritems_id', $fi->id)->count();
            if ($b == 0) {
                $this->createpr(
                    $fi->id,
                    $fi->deliver_qty,
                    $fi->rr_number,
                    $fi->name,
                    $fi->item_description,
                    $fi->acq_date,
                    $fi->unit_cost,
                    $fi->oum
                );
            } else {
                //
            }
        }
    }

    public function createpr($id, $qty, $rrn, $name, $itemD, $acq_date, $amount, $oum)
    {
        $prr = "";
        for ($i = 1; $i <= $qty; $i++) {
            $this->generatePR();
            $save = [
                'property_code' => $this->pr,
                'school_id' => Auth::user()->school_id,
                'rritems_id' => $id,
                'rr_number' => $rrn,
                'amount' => $amount,
                'name' => $name,
                'item_description' => $itemD,
                'acq_date' => $acq_date,
                'dept_code' => $this->department,
                'subdept_code' => $this->subdept,
                'item_status' => 'Present',
                'new_custodian' => $this->receivedby,
                'inv_status' => 'New',
                'oum' => $oum,
            ];
            SerialPropertyCode::create($save);
            $prr .= $this->pr;
        }
    }

    public function generatePR()
    {
        $data = SerialPropertyCode::count();

        $count = strlen($data);

        $val = date("Y");
        if ($count == "1")
            $val .= "000";
        if ($count == "2")
            $val .= "00";
        if ($count == "3")
            $val .= "0";

        $this->pr = $val . $data + 1;
    }


    /*---------------------------------------------------------------
    Show DATA VALUES
    ----------------------------------------------------------------*/

    public function showValues($val)
    {
        try {

            $rrval = Receivingreports::where('rr_number', $val)->first();
            $supval = Supplier::where('supplier_code', $rrval->supplier_code)->first();

            $this->rrnum = $val;
            $this->name = $supval->name;
            $this->address = $supval->address;
            $this->telnum = $supval->telnum . " / " . $supval->faxnum;

            $this->delivery_date = $rrval->delivery_date;
            $this->invoice_date = $rrval->invoice_date;
            $this->invoice = $rrval->invoice;
            $this->po_rr = $rrval->ponum . " - " . $rrval->rr_number;
            $this->custodianRBY = $rrval->receivedby;

            //mark as read
            if (empty($rrval->read_at)) {
                $this->readat($val);
            }


            $this->dispatchBrowserEvent('changeURL', [
                'entURL' => $val
            ]);

            $this->receivedby = $rrval->receivedby;

            if (!empty($rrval->receivedby)) {
                $us = User::where('school_id', $rrval->receivedby)->first();
                $this->rby = $us->first_name . ' ' . $us->last_name;
                $this->subdept = $us->subdept_code;
            }

            $this->totalAmount = "₱" . number_format($rrval->total, 2);

            $data = Department::where('dept_code', $rrval->dept_code)->first();

            $this->department = $rrval->dept_code;
            $this->dept_name = $data->description;
        } catch (Exception $e) {
            $this->dispatchBrowserEvent('swal_mode', [
                'text' => 'Something went wrong, please try again later.',
                'type' => 'error',
                'w' => 400,
                'timer' => 3000,
            ]);
        }
    }


    /*-----------------------------------------------------------
   Read at
    -----------------------------------------------------------*/

    public function readat($val)
    {
        try {
            Receivingreports::where('rr_number', $val)->update($this->readData());
        } catch (Exception $e) {
            //
        }
    }
    public function readData()
    {
        return [
            'read_at' => Carbon::now(),
        ];
    }

    /*---------------------------------------------------------------
    ADD Serial Codes
    ----------------------------------------------------------------*/

    public function openSerialModal($id, $name, $pc)
    {
        $this->serialID = SerialPropertyCode::where('rritems_id', $id)->get();
        $this->dispatchBrowserEvent('showAddSerial');
        $this->Itemname = $name;
        $this->pcs = $pc;
    }

    public function saveSerialCode()
    {
        $this->validate($rules = ['serial' => 'required']);
        if (!empty($this->serial)) {
            SerialPropertyCode::where('property_code', $this->pcs)->update(['serial_number' => $this->serial]);
            $this->serial = null;
            $this->cancelAES();
        }
    }

    /*---------------------------------------------------------------
    EDIT Serial Codes
    ----------------------------------------------------------------*/
    public function editSerial($s, $name)
    {
        $this->serial = $s;
        $this->snum = $s;
        $this->Itemname = $name;
        $this->dispatchBrowserEvent('showAddSerial');
    }

    public function updateS()
    {
        SerialPropertyCode::where('serial_number', $this->snum)->update(['serial_number' => $this->serial]);
        $this->cancelAES();
        $this->dispatchBrowserEvent('swal_mode', [
            'text' => 'Successfully updated.',
            'type' => 'success',
            'w' => 300,
            'timer' => 2000,
        ]);
    }

    public function cancelAES()
    {
        $this->serial = null;
        $this->snum = null;
        $this->Itemname = null;
        $this->serialID = null;
        $this->pcs = null;
        $this->dispatchBrowserEvent('hideAddSerial');
    }

    /*---------------------------------------------------------------
    DELETE Serial Codes
    ----------------------------------------------------------------*/
    public function deleteSerial($s, $id)
    {
        $this->snum = $s;
        $this->sID = $id;
        $this->dispatchBrowserEvent('showDeleteSerial');
    }

    public function deleteS()
    {
        SerialPropertyCode::where('id', $this->sID)->update(['serial_number' => '']);
        $this->dispatchBrowserEvent('hideDeleteSerial');
        $this->dispatchBrowserEvent('swal_mode', [
            'text' => 'Deleted.',
            'type' => 'success',
            'w' => 200,
            'timer' => 2000,
        ]);
    }

    public function cancelDS()
    {
        $this->snum = null;
        $this->sID = null;
        $this->dispatchBrowserEvent('hideDeleteSerial');
    }


    /*-----------------------------------------------------------
    ADD AND CLEAR SIGN
    -----------------------------------------------------------*/

    public function esign()
    {
        $date = Carbon::now()->format('m/d/y');
        $this->checkedby = Auth::user()->first_name . " " . Auth::user()->last_name . ' / ' . $date;
    }

    public function clearesign()
    {
        $this->checkedby = null;
    }

    /*-----------------------------------------------------------
    SAVE FEA 
    -----------------------------------------------------------*/

    public function preview()
    {
        if (!empty($this->checkedby)) {
            $this->dispatchBrowserEvent('showPreviewFea');
        } else {
            $this->dispatchBrowserEvent('swal_mode', [
                'text' => 'Your e-sign is required.',
                'type' => 'warning',
                'w' => 400,
                'timer' => 3000,
            ]);
        }
    }


    /*-----------------------------------------------------------
    SAVE FEA 
    -----------------------------------------------------------*/

    public function savefea()
    {
        try {

            $this->generateFEA();
            $fea_id = Fea::create($this->saveDatafea());
            Receivingreports::where('rr_number', $this->fea_rrnum)->update(['fea_number' => $this->fea_number]);
            SerialPropertyCode::where('rr_number', $this->fea_rrnum)->update(['fea_number' => $this->fea_number]);

            $this->sendEmailNotif();
            $this->notif();

            $this->closecreateFEA();

            $this->dispatchBrowserEvent('hidePreviewFea');

            $this->dispatchBrowserEvent('swal_mode', [
                'text' => 'You have successfully created fea no. ' . $this->fea_number,
                'type' => 'success',
                'w' => 400,
                'timer' => 4000,
            ]);
        } catch (Exception $e) {
            if (!empty($fea_id->id)) {
                Fea::where('fea_id', $fea_id->id)->delete();
                Receivingreports::where('rr_number', $this->fea_rrnum)->update(['fea_number' => null]);
            }

            //
            $this->dispatchBrowserEvent('swal_mode', [
                'text' => 'Something went wrong! Please try again later.',
                'type' => 'error',
                'w' => 300,
                'timer' => 3000,
            ]);
        }
    }

    public function sendEmailNotif()
    {
        $emailto = User::where('school_id', $this->receivedby)->first();
        $subject = 'New Fea has been created using ' . $this->rrnum;
        $form_type = "FEA";
        $form_number = $this->fea_number;
        $link = "http://127.0.0.1:8000/c/fea/sign/" . $this->fea_number;
        $s = "Active";

        Mail::to($emailto->email)->queue(new FormEmailNotification($subject, $form_type, $form_number, $link, $s));


        $emailtop = User::whereRoleIs('Warehouse')->first();
        $subjectp = 'The ' . $this->rrnum . ' has already been created a fea form.';
        $form_typep = "FEA";
        $form_numberp = $this->fea_number;
        $linkp = "http://127.0.0.1:8000/receivingreport/" . $this->rrnum;
        $sp = "Active";

        Mail::to($emailtop->email)->queue(new FormEmailNotification($subjectp, $form_typep, $form_numberp, $linkp, $sp));
    }

    public function notif()
    {
        try {
            $s = "Active";
            $type = "FEA";
            $message =  'The ' . $this->rrnum . ' has already been created a fea form.';
            $link = "/receivingreport/" . $this->fea_number;
            $user = User::whereRoleIs('Warehouse')->first();

            Notification::send($user, new OpmsNotification($type, $message, $link, $s));


            $messagec =  'New Fea has been created using ' . $this->rrnum;
            $linkc = "/c/fea/sign/" . $this->fea_number;
            $userc =  User::where('school_id', $this->receivedby)->first();

            Notification::send($userc, new OpmsNotification($type, $messagec, $linkc, $s));
        } catch (Exception $e) {
            //
        }
    }


    public function saveDatafea()
    {
        return [
            'fea_number' => $this->fea_number,
            'rr_number' => $this->fea_rrnum,
            'checkedby' => Auth::user()->school_id,
            'checked_date' => Carbon::now(),
            'receivedby' => $this->receivedby,
            'status' => "Active",
            'subdept_code' => $this->subdept,
            'dept_code' => $this->department,
            'acq_date' => $this->invoice_date,
            'total_amount' => $this->totalAmount,
        ];
    }




    public function generateFEA()
    {
        $data = Fea::count();

        $count = strlen($data);

        if ($count == "1")
            $val = "000";
        if ($count == "2")
            $val = "00";
        if ($count == "3")
            $val = "0";

        $this->fea_number = $val . $data + 1;
    }

    /*-----------------------------------------------------------
    RENDER
    -----------------------------------------------------------*/

    public function clearVals()
    {
        $this->checkeddate = null;
        $this->fea_rrnum = null;
        $this->hideRRnum = null;
        $this->checkedby = null;
        $this->rrnum = null;
    }

    /*-----------------------------------------------------------
    RENDER
    -----------------------------------------------------------*/
    public function render()
    {
        if (!empty($this->rrnum)) {
            $this->dispatchBrowserEvent('sample', [
                'rowindex' => $this->rrnum
            ]);
        }

        $rrnums = Receivingreports::where('status', 'Done')->whereNull('fea_number')->where('rr_number', 'like', '%' . $this->search . '%')->get();
        $feaItem = Rritems::where('rr_number', $this->fea_rrnum)->get();
        $feaval = Fea::whereNull('receivedby')->get();
        $srn = SerialPropertyCode::all();
        return view('livewire.property.feacreate', [
            'rrnums' => $rrnums,
            'items' => $feaItem,
            'prop' => $srn,
            'feas' => $feaval,
        ]);
    }
}
