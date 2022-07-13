<?php

namespace App\Http\Livewire\Custodian;

use App\Mail\FormEmailNotification;
use App\Models\DisposalItem;
use App\Models\Fea;
use App\Models\Inventory;
use App\Models\InventoryItems;
use App\Models\ItemDisposal;
use App\Models\QrItems;
use App\Models\qrtagging;
use App\Models\Receivingreports;
use App\Models\Rritems;
use App\Models\SerialPropertyCode;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use App\Notifications\OpmsNotification;
use Illuminate\Support\Facades\Notification;
use phpDocumentor\Reflection\Types\This;
use PhpParser\Node\Expr\Empty_;

class QrCreate extends Component
{
    public $prty, $srl, $item, $oum, $fea, $acq_date, $showbuttonupdate;
    public $itemArray = array(), $itemid;
    public $property_array = array();
    public $reason, $date, $preparedby, $rqr_number, $d_id, $sdata, $finalizeData;



    /*-----------------------------------------------------------
    CLEAR
    -----------------------------------------------------------*/
    public function clear()
    {
        $this->clearTop();
        $this->clearItems();

        return redirect('/c/qrretagging/logs');
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
            $val = SerialPropertyCode::where('property_code', $id)->first();
            if (!empty($val)) {
                $this->srl = $val->serial_number;
                $this->fea = $val->fea_number;
                $this->item = $val->name . ' ' . $val->item_description;
                $this->oum = $val->oum;
                $this->acq_date = $val->acq_date;
            } else {
                $this->dispatchBrowserEvent('swal_mode', [
                    'text' => 'Invalid Property Number',
                    'type' => 'error',
                    'w' => 300,
                    'timer' => 2000,
                ]);
            }
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
    DELETE ITEM VALUES WHEN PROPERTY NUMBER CHANGES
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
                'oum' => $i['oum']
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
                'oum' => $i['oum']
            );
        }
        $array2 = array();
    }



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

    public function preview()
    {
        $this->validate();
        if (count($this->itemArray) != 0) {
            if (!empty($this->preparedby)) {

                $this->finalizeData = "show";
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
                'w' => 400,
                'timer' => 3000,
            ]);
        }
    }

    public function previewClose()
    {
        $this->finalizeData = null;
    }


    /*-----------------------------------------------------------
        RULES
    -----------------------------------------------------------*/
    public function rules()
    {
        return [
            'reason' => 'required',
        ];
    }

    /*-----------------------------------------------------------
    save RQR TO DATABASE
    -----------------------------------------------------------*/

    public function saveRQR()
    {
        if ($this->validate()) {
            try {
                $this->createID();
                $qrmain = qrtagging::create($this->dataMain());

                foreach ($this->itemArray as $itemval) {
                    QrItems::create($this->dataItem($itemval, $qrmain->id)); //save to database
                }

                $this->sendEmailNotif();
                $this->notif();

                $this->dispatchBrowserEvent('showSuccessView');
            } catch (Exception $e) {

                //delete if not save

                if (!empty($qrmain)) {
                    qrtagging::where('id', $qrmain->id)->delete();
                }
                //display error message
                $this->dispatchBrowserEvent('swal_mode', [
                    'text' => 'Something went wrong. Please try again later.',
                    'type' => 'warning',
                    'w' => 400,
                    'timer' => 3000,
                ]);
            }
        }
    }

    // for RDF table data
    public function dataMain()
    {
        return [
            'rqr_number' => $this->rqr_number,
            'reason' => $this->reason,
            'reqby'  => Auth::user()->school_id,
            'req_date' => Carbon::now(),
            'subdept_code' => Auth::user()->subdept_code,
            'status' => 'Active'
        ];
    }


    public function dataItem($item, $qrmain)
    {
        return [
            'qrtagging_id' => $qrmain,
            'rqr_number' => $this->rqr_number,
            'reason' => $this->reason,
            'property_number' => $item['property_number'],
            'serial_number' => $item['serial_number'],
            'item' => $item['item_description'],
            'acq_date' => $item['acq_date'],
            'fea_number' => $item['fea_number'],
            'oum' => $item['oum'],
            'status' => 'Active'
        ];
    }


    /*-----------------------------------------------------------
    SEND NOTIFICATIONS
    -----------------------------------------------------------*/

    public function sendEmailNotif()
    {
        $emailto = User::whereRoleIs('Property')->first();
        $subjectp = 'A new request for Qr retagging has been submitted.';
        $form_typep = "QR tagging";
        $form_numberp = $this->rqr_number;
        $linkp = "http://127.0.0.1:8000/generate/qrretagging/" . $this->rqr_number;
        $sp = "Active";

        Mail::to($emailto->email)->queue(new FormEmailNotification($subjectp, $form_typep, $form_numberp, $linkp, $sp));
    }


    public function notif()
    {
        $type = 'QR tagging';
        $message =  'A new request for Qr retagging has been submitted.';
        $link = '/generate/qrretagging/' . $this->rqr_number;
        $user = User::whereRoleIs('Property')->first();
        $s = "Active";

        Notification::send($user, new OpmsNotification($type, $message, $link, $s));
    }

    /*-----------------------------------------------------------
    CREATE ID
    -----------------------------------------------------------*/
    public function createID()
    {
        $num = qrtagging::count();

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
        $this->rqr_number = $val;
    }

    /*-----------------------------------------------------------
    CREATE AGAIN
    -----------------------------------------------------------*/

    public function createAgain()
    {
        $this->clearTop();
        $this->clearItems();
        $this->dispatchBrowserEvent('hideSuccessView');
    }



    /*-----------------------------------------------------------
    REVIEW
    -----------------------------------------------------------*/

    public function reviewstatus()
    {
        $this->reason = null;
        $this->date = null;
        $this->preparedby = null;
        $this->itemArray = array();
        $this->finalizeData = null;
        $this->clearItems();
        return redirect('/c/qrretagging/' . $this->rqr_number);
    }


    /*-----------------------------------------------------------
    CLEAR
    -----------------------------------------------------------*/

    public function clearTop()
    {
        $this->reason = null;
        $this->date = null;
        $this->preparedby = null;
        $this->itemArray = array();
        $this->finalizeData = null;
        $this->rqr_number = null;
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
        $this->sdata = null;
    }


    /*-----------------------------------------------------------
    RENDER
    -----------------------------------------------------------*/
    public function render()
    {
        return view('livewire.custodian.qr-create', [
            'vals' => $this->itemArray,
        ]);
    }
}
