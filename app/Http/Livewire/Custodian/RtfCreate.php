<?php

namespace App\Http\Livewire\Custodian;

use App\Mail\FormEmailNotification;
use Livewire\Component;
use App\Models\Fea;
use App\Models\FurnitureItem;
use App\Models\Inventory;
use App\Models\Receivingreports;
use App\Models\Rritems;
use App\Models\SerialPropertyCode;
use App\Models\SubDepartment;
use App\Models\TransferFurniture;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use phpDocumentor\Reflection\Types\This;
use App\Notifications\OpmsNotification;
use Illuminate\Support\Facades\Notification;

class RtfCreate extends Component
{
    public $prty, $srl, $item, $oum, $fea, $acq_date, $showbuttonupdate;
    public $itemArray = array(), $itemid, $receivedby, $custodian, $subdept_code;
    public $reason, $rtf_number, $rd, $eval_by, $email, $name, $cust;


    /*-----------------------------------------------------------
    SIGN
    -----------------------------------------------------------*/

    //SIGN
    public function esign()
    {
        $this->preparedby = Auth::user()->first_name . ' '
            . Auth::user()->last_name . ' / ' . Carbon::now();
    }

    public function clearesign()
    {
        $this->preparedby = null;
    }

    /*-----------------------------------------------------------
    save rdf main function
    -----------------------------------------------------------*/

    public function saveRTF()
    {
        $this->validate();
        if (count($this->itemArray) >= 1) {
            if (!empty($this->preparedby)) {
                $this->savaInv();
            } else {
                $this->dispatchBrowserEvent('swal_mode', [
                    'text' => 'Signature is required.',
                    'type' => 'warning',
                    'w' => 400,
                    'timer' => 2000,
                ]);
            }
        } else {
            $this->dispatchBrowserEvent('swal_mode', [
                'text' => 'Please add at least one item.',
                'type' => 'warning',
                'w' => 300,
                'timer' => 2000,
            ]);
        }
    }



    /*-----------------------------------------------------------
    save actual item to database
    -----------------------------------------------------------*/

    public function savaInv()
    {
        try {
            $this->createID(); //create rdf id

            if (!empty($this->custodian)) {
                $u = User::where('school_id', $this->custodian)->first();
                $this->rd =  $u->subdept_code;
                $this->email = $u->email;
                $this->cust = $u;
            }
            $d = TransferFurniture::create($this->dataItem()); //save to database
            $this->d_id = $d->id;


            $rnum = '/c/rtf/' . $this->rtf_number;

            $this->sendEmailNotif();
            $this->notif();
            //save inventory item list
            $this->saveItems();
            $this->clearTop();


            return redirect($rnum);


            $this->dispatchBrowserEvent('swal_mode', [
                'text' => 'Saved',
                'type' => 'success',
                'w' => 200,
                'timer' => 2000,
            ]);
        } catch (Exception $e) { // when Item create failed.

            if (!empty($d)) {
                //delete item  when failed to save in inv table
                TransferFurniture::where('rtf_number', $this->rtf_number)->delete();
            }


            //display error message
            $this->dispatchBrowserEvent('swal_mode', [
                'text' => 'AASomething went wrong. Please try again later.',
                'type' => 'warning',
                'w' => 400,
                'timer' => 3000,
            ]);
        }
    }

    // for RDF table data
    public function dataItem()
    {
        return [
            'rtf_number' => $this->rtf_number,
            'from' => Auth::user()->school_id,
            'date' => Carbon::now(),
            'subdept_code' => Auth::user()->subdept_code,
            'reason' => $this->reason,
            'status' => "Pending",
            'receiving_dept' => $this->rd,
            'custodian' => $this->custodian,
            'eval_by' => $this->eval_by,

        ];
    }

    /*-----------------------------------------------------------
    NOTIFICATION
    -----------------------------------------------------------*/


    public function sendEmailNotif()
    {
        $subject = 'A new RTF has been created.';
        $form_type = "RTF";
        $form_number = $this->rtf_number;
        $s = "Active";
        $emailtop = User::whereRoleIs('Property')->first();
        $linkp = "http://127.0.0.1:8000/rtf/" . $this->rtf_number;


        Mail::to($emailtop->email)->queue(new FormEmailNotification($subject, $form_type, $form_number, $linkp, $s));

        $link = "http://127.0.0.1:8000/c/rtf/sign/" . $this->rtf_number;
        $subjectp = 'You have new RTF form to received.';
        Mail::to($this->email)->queue(new FormEmailNotification($subjectp, $form_type, $form_number, $link, $s));
    }


    public function notif()
    {
        $s = "Active";
        $type = "RTF";
        $message = 'A new RTF has been created.';
        $link = "rtf/" . $this->rtf_number;
        $user = User::whereRoleIs('Property')->first();

        Notification::send($user, new OpmsNotification($type, $message, $link, $s));

        $linkp = "/rtf/received/" . $this->rtf_number;
        $subjectp = 'You have new RTF form to received.';

        Notification::send($this->cust, new OpmsNotification($type,  $subjectp, $linkp, $s));
    }


    /*-----------------------------------------------------------
    save inventory item to database
    -----------------------------------------------------------*/

    public function saveItems()
    {
        foreach ($this->itemArray as $i) {
            FurnitureItem::create(
                [
                    'transfer_furniture_id' => $this->d_id,
                    'qty' => 1,
                    'unit' => $i['oum'],
                    'name' => $i['name'],
                    'item_description' => $i['item_description'],
                    'serial_number' => $i['serial_number'],
                    'fea_number' => $i['fea_number'],
                    'acq_date' => $i['acq_date'],
                    'property_number' =>  $i['property_number'],
                    'eval_by' => $i['eval_by'],
                    'status' => 'Active'
                ]
            );
        }
    }

    /*-----------------------------------------------------------
    CREATE ID
    -----------------------------------------------------------*/
    public function createID()
    {
        $num = TransferFurniture::count();

        if ($num == 0 || $num == null) {
            $id = 1;
        } else {
            $id = $num + 1;
        }

        $count = strlen($id);

        if ($count == "1")
            $val = "000";
        if ($count == "2")
            $val = "00";
        if ($count == "3")
            $val = "0";

        $val .= $id;
        $this->rtf_number = $val;
    }




    /*-----------------------------------------------------------
    Clear
    -----------------------------------------------------------*/

    public function closeRTF()
    {
        $this->clearTop();

        return redirect('/c/rtf/sign/logs');
    }
    /*-----------------------------------------------------------
    DELETE THE OTHER ITEM FIELDS WHEN SEARCH
    -----------------------------------------------------------*/

    public function updatedPrty()
    {
        $this->showbuttonupdate = null;
        $this->item = null;
        $this->srl = null;
        $this->oum = null;
        $this->fea = null;
        $this->acq_date = null;
        $this->itemid = null;
        $this->name = null;
    }

    /*-----------------------------------------------------------
    FIND SHOW DATA
    -----------------------------------------------------------*/

    public function find()
    {
        $this->validate($rules = ['prty' => 'required']);
        $this->show($this->prty);
    }


    public function show($id)
    {
        $this->clearItems();
        try {
            $this->prty = $id;
            $val = SerialPropertyCode::where('property_code', $id)
                ->where('new_custodian', Auth::user()->school_id)
                ->where('item_status',  '!=', 'Disposed')
                ->first();

            $this->srl = $val->serial_number;
            $this->fea = $val->fea_number;
            $this->item =  $val->item_description;
            $this->name = $val->name;
            $this->oum = $val->oum;
            $this->acq_date = $val->acq_date;


            if ($val->acc_code == '307080' || $val->acc_code == '310280') {
                $this->eval_by  = 'ICTC';
            } else {
                $this->eval_by  = 'BFMO';
            }


            //
        } catch (Exception $e) {
            $this->dispatchBrowserEvent('swal_mode', [
                'text' => 'Invalid Property Number',
                'type' => 'error',
                'w' => 300,
                'timer' => 2000,
            ]);
        }
    }

    /*-----------------------------------------------------------
   SHOW DATA WHEN CLICK AT THE SIDE 
    -----------------------------------------------------------*/

    public function showData($id)
    {
        $this->clearItems();
        try {
            $this->sdata = 'show';
            $this->itemid = $id;
            $this->showbuttonupdate = "true";

            $this->prty =  $this->itemArray[$id]['property_number'];
            $this->srl = $this->itemArray[$id]['serial_number'];
            $this->fea = $this->itemArray[$id]['fea_number'];
            $this->acq_date = $this->itemArray[$id]['acq_date'];
            $this->item = $this->itemArray[$id]['item_description'];
            $this->oum = $this->itemArray[$id]['oum'];
            $this->name = $this->itemArray[$id]['name'];

            $this->dispatchBrowserEvent('selectItem', [
                'rowindex' => $id
            ]);
            //
        } catch (Exception $e) {
            $this->dispatchBrowserEvent('swal_mode', [
                'text' => 'Something went wrong, please try again later.',
                'type' => 'error',
                'w' => 300,
                'timer' => 2000,
            ]);
        }
    }




    /*-----------------------------------------------------------
    SAVE ITEMS TO ARRAY
    -----------------------------------------------------------*/

    public function saveItem()
    {
        try {
            for ($i = count($this->itemArray) - 1; $i >= 0; $i--) {
                if ($this->itemArray[$i]['property_number'] == $this->prty) {
                    $val = $this->itemArray[$i]['property_number'];
                }
            }

            if (!empty($val)) {
                $this->dispatchBrowserEvent('swal_mode', [
                    'text' => 'This property number is already exist.',
                    'type' => 'warning',
                    'w' => 400,
                    'timer' => 2000,
                ]);
            } else {
                $this->save();
            }
        } catch (Exception $e) {
            $this->dispatchBrowserEvent('swal_mode', [
                'text' => 'Please add item before saving',
                'type' => 'error',
                'w' => 400,
                'timer' => 3000,
            ]);
        }
    }

    public function save()
    {
        $this->validate($rules = ['prty' => 'required']);
        if (!empty($this->item)) {
            $this->itemArray[] = array(
                'property_number' => $this->prty,
                'item_description' => $this->item,
                'serial_number' => $this->srl,
                'oum' => $this->oum,
                'fea_number' => $this->fea,
                'acq_date' => $this->acq_date,
                'name' => $this->name,
                'eval_by' => $this->eval_by,
            );

            $this->clearItems();
        } else {
            $this->dispatchBrowserEvent('swal_mode', [
                'text' => 'Find the property number before saving.',
                'type' => 'warning',
                'w' => 400,
                'timer' => 3000,
            ]);
        }
    }

    /*-----------------------------------------------------------
    DELETE ITEMS TO ARRAY
    -----------------------------------------------------------*/
    public function deleteItem($id)
    {
        unset($this->itemArray[$id]);
        $this->clearItems();
        $this->copyArray();
    }

    public function copyArray()
    {
        $array2 = array();

        foreach ($this->itemArray as $i) {
            $array2[] = array(
                'property_number' =>  $i['property_number'],
                'serial_number' => $i['serial_number'],
                'fea_number' => $i['fea_number'],
                'acq_date' => $i['acq_date'],
                'item_description' => $i['item_description'],
                'oum' => $i['oum'],
                'name' => $i['name'],
                'eval_by' => $i['eval_by']
            );
        }
        $this->itemArray = array();

        foreach ($array2 as $i) {
            $this->itemArray[] = array(
                'property_number' =>  $i['property_number'],
                'serial_number' => $i['serial_number'],
                'fea_number' => $i['fea_number'],
                'acq_date' => $i['acq_date'],
                'item_description' => $i['item_description'],
                'oum' => $i['oum'],
                'name' => $i['name'],
                'eval_by' => $i['eval_by']
            );
        }
        $array2 = array();
    }



    /*-----------------------------------------------------------
    RULES
    -----------------------------------------------------------*/

    public function rules()
    {
        return [
            'reason' => 'required',
            'custodian' => 'required',
        ];
    }



    /*-----------------------------------------------------------
    CLEAR
    -----------------------------------------------------------*/

    public function clearTop()
    {
        $this->reason = null;
        $this->date = null;
        $this->custodian = null;
        $this->itemArray = null;
        $this->clearItems();
    }


    public function clearItems()
    {
        $this->showbuttonupdate = null;
        $this->prty = null;
        $this->item = null;
        $this->srl = null;
        $this->oum = null;
        $this->fea = null;
        $this->acq_date = null;
        $this->itemid = null;
        $this->name = null;
        $this->eval_by;
    }


    /*-----------------------------------------------------------
    RENDER
    -----------------------------------------------------------*/

    public function render()
    {
        $custodian = User::whereRoleIs('Custodian')
            ->where('school_id', '!=', Auth::user()->school_id)
            ->get();
        return view('livewire.custodian.rtf-create', [
            'vals' => $this->itemArray,
            'cus' => $custodian,
        ]);
    }
}
