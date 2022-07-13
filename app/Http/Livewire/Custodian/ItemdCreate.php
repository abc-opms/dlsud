<?php

namespace App\Http\Livewire\Custodian;

use App\Models\DisposalItem;
use App\Models\Fea;
use App\Models\Inventory;
use App\Models\InventoryItems;
use App\Models\ItemDisposal;
use App\Models\Receivingreports;
use App\Models\Rritems;
use App\Models\SerialPropertyCode;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use phpDocumentor\Reflection\Types\This;
use Illuminate\Support\Facades\Mail;
use App\Notifications\OpmsNotification;
use Illuminate\Support\Facades\Notification;
use App\Mail\FormEmailNotification;
use App\Models\User;

class ItemdCreate extends Component
{
    public $prty, $srl, $item, $oum, $fea, $acq_date, $showbuttonupdate;
    public $itemArray = array(), $itemid;
    public $property_array = array();
    public $reason, $date, $preparedby, $rdf_number, $d_id, $name, $sdata;
    public $eval_by, $evalSelect, $acc_code;

    /*-----------------------------------------------------------
    CLEAR
    -----------------------------------------------------------*/
    public function clear()
    {
        $this->clearTop();
        $this->clearItems();

        return redirect('/c/itemdisposal/logs');
    }

    public function saveEval()
    {
        $this->evalSelect = $this->eval_by;
    }

    public function changeEval()
    {
        $this->clearItems();
        $this->itemArray = array();
        $this->evalSelect = null;
        $this->eval_by = '';
        $this->dispatchBrowserEvent('hidemodalChangeEval');
    }

    /*-----------------------------------------------------------
    FIND SHOW DATA
    -----------------------------------------------------------*/

    public function find()
    {
        if (!empty($this->eval_by)) {
            $this->validate($rules = ['prty' => 'required']);
            $this->show($this->prty);
        } else {
            $this->dispatchBrowserEvent('swal_mode', [
                'text' => 'Please select Evaluated by at the top before adding items.',
                'type' => 'error',
                'w' => 300,
                'timer' => 2000,
            ]);
        }
    }


    public function show($id)
    {
        $this->clearItems();
        try {
            $this->prty = $id;
            $val = SerialPropertyCode::where('property_code', $id)
                ->where('item_status',  '!=', 'Disposed')
                ->first();
            if (!empty($val)) {

                if ($val->acc_code == '307080' || $val->acc_code == '310280') {
                    $eby = 'ICTC';
                } else {
                    $eby = 'BFMO';
                }

                if ($this->eval_by == $eby) {
                    $this->srl = $val->serial_number;
                    $this->fea = $val->fea_number;
                    $this->item =  $val->item_description;
                    $this->name = $val->name;
                    $this->oum = $val->oum;
                    $this->acq_date = $val->acq_date;
                    $this->acc_code = $val->acc_code;
                } else {
                    $this->dispatchBrowserEvent('swal_mode', [
                        'text' => 'You cannot add items that are not handled by ' . $this->eval_by,
                        'type' => 'warning',
                        'w' => 400,
                        'timer' => 3000,
                    ]);
                }
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



    public function updateEval_by()
    {
        if (!empty($this->itemArray)) {
            $this->dispatchBrowserEvent('showmodalChangeEval');
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
        $this->name = null;
        $this->acc_code = null;
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
                'text' => 'Something went wrong, please try again later.',
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
                'acc_code' => $this->acc_code,
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
                'acc_code' => $i['acc_code']
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
                'acc_code' => $i['acc_code']
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
        ];
    }



    /*-----------------------------------------------------------
    CLEAR
    -----------------------------------------------------------*/

    public function clearTop()
    {
        $this->reason = null;
        $this->date = null;
        $this->preparedby = null;
        $this->eval_by = null;
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
        $this->sdata = null;
        $this->acc_code = null;
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

    public function saveRDF()
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
                    'timer' => 3000,
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

    /*-----------------------------------------------------------
    NOTIFICATION
    -----------------------------------------------------------*/

    public function sendEmailNotif()
    {
        $emailto = User::whereRoleIs($this->eval_by)->first();


        $subjectp = 'You have new RDF to check.';
        $form_typep = "RDF";
        $form_numberp = $this->rdf_number;
        $linkp = "http://127.0.0.1:8000/b/itemdisposal/" . $this->rdf_number;
        $sp = "Active";

        Mail::to($emailto->email)->queue(new FormEmailNotification($subjectp, $form_typep, $form_numberp, $linkp, $sp));
    }


    public function notif()
    {
        $type = 'RDF';
        $message =  'You have new RDF to check.';
        $link = '/b/itemdisposal/' . $this->rdf_number;
        $user = User::whereRoleIs($this->eval_by)->first();
        $s = "Active";

        Notification::send($user, new OpmsNotification($type, $message, $link, $s));
    }
    /*-----------------------------------------------------------
    save actual item to database
    -----------------------------------------------------------*/

    public function savaInv()
    {
        try {
            $this->createID(); //create rdf id
            $d = ItemDisposal::create($this->dataItem()); //save to database
            $this->d_id = $d->id;

            //notification
            $this->sendEmailNotif();
            $this->notif();

            //save inventory item list
            $this->saveItems();

            $this->dispatchBrowserEvent('swal_mode', [
                'text' => 'Saved',
                'type' => 'success',
                'w' => 200,
                'timer' => 2000,
            ]);

            return redirect('/c/itemdisposal/' . $this->rdf_number);
        } catch (Exception $e) { // when Item disposal create failed.

            //delete item disposal when failed to save in inv table
            ItemDisposal::where('rdf_number', $this->rdf_number)->delete();

            //display error message
            $this->dispatchBrowserEvent('swal_mode', [
                'text' => 'Something went wrong. Please try again later.',
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
            'rdf_number' => $this->rdf_number,
            'from' => Auth::user()->school_id,
            'date' => Carbon::now(),
            'subdept_code' => Auth::user()->subdept_code,
            'reason' => $this->reason,
            'status' => "Pending",
            'eval_by' => $this->eval_by,
        ];
    }

    /*-----------------------------------------------------------
    save inventory item to database
    -----------------------------------------------------------*/

    public function saveItems()
    {
        try {
            foreach ($this->itemArray as $i) {
                DisposalItem::create(
                    [
                        'item_disposal_id' => $this->d_id,
                        'form_number' => 'RDF' . $this->rdf_number,
                        'property_number' =>  $i['property_number'],
                        'serial_number' => $i['serial_number'],
                        'item_description' => $i['item_description'],
                        'name' => $i['name'],
                        'qty' => 1,
                        'unit' => $i['oum'],
                        'fea_number' => $i['fea_number'],
                        'acq_date' => $i['acq_date'],
                        'status' => 'Active',
                        'acc_code' => $i['acc_code']
                    ]
                );
            }
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
    CREATE ID
    -----------------------------------------------------------*/
    public function createID()
    {
        $num = ItemDisposal::count();

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
        $this->rdf_number = $val;
    }



    /*-----------------------------------------------------------
    RENDER
    -----------------------------------------------------------*/

    public function render()
    {
        return view('livewire.custodian.itemd-create', [
            'vals' => $this->itemArray,
        ]);
    }
}
