<?php

namespace App\Http\Livewire\Finance;

use App\Mail\FormEmailNotification;
use App\Models\ItemDisposal;
use App\Models\RoleUser;
use App\Models\SubDepartment;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Illuminate\Support\Facades\Notification;
use App\Notifications\OpmsNotification;


class ItemdSign extends Component
{

    public $ItemArray = array(), $postedby,  $search;
    public $rdf_number;
    public $to, $from, $date, $dept, $reason, $checkedby, $action, $useremail, $approvedby;


    /*-----------------------------------------------------------
    sign 
    -----------------------------------------------------------*/

    public function esign()
    {
        $this->approvedby = Auth::user()->first_name . '' . Auth::user()->first_name
            . ' / ' . Carbon::now();
        $this->saveS = Carbon::now();
    }

    public function clearesign()
    {
        $this->approvedby = null;
        $this->saveS = null;
    }

    /*-----------------------------------------------------------
    SAVE SIGN
    -----------------------------------------------------------*/

    public function saveSign()
    {
        if (!empty($this->notedby)) {
            try {
                ItemDisposal::where('rdf_number', $this->rdf_number)->update($this->dataItem());
                $this->sendEmailNotif();
                $this->clear();
                $this->dispatchBrowserEvent('swal_mode', [
                    'text' => 'Saved.',
                    'type' => 'success',
                    'w' => 200,
                    'timer' => 2000,
                ]);
            } catch (Exception $e) {
                $this->dispatchBrowserEvent('swal_mode', [
                    'text' => 'Something went wrong. Please try again later.',
                    'type' => 'error',
                    'w' => 300,
                    'timer' => 3000,
                ]);
            }
        } else {
            $this->dispatchBrowserEvent('swal_mode', [
                'text' => 'Signature is required.',
                'type' => 'warning',
                'w' => 300,
                'timer' => 3000,
            ]);
        }
    }

    public function dataItem()
    {
        return [
            'approvedby' => Auth::user()->school_id,
            'approved_date' => Carbon::now(),
            'read_at' => null
        ];
    }


    public function sendEmailNotif()
    {
        $subject = 'The RDF no. ' . $this->rdf_number . ' has been approved by Finance Department.';
        $form_type = "RDF";
        $form_number = $this->rdf_number;
        $link = "http://127.0.0.1:8000/c/itemdisposal/" . $this->rdf_number;
        $s = "Ongoing";

        Mail::to($this->useremail)->queue(new FormEmailNotification($subject, $form_type, $form_number, $link, $s));


        $emailtop = User::whereRoleIs('Warehouse')->first();
        $linkp = "http://127.0.0.1:8000/itemdisposal/" . $this->rdf_number;


        Mail::to($emailtop->email)->queue(new FormEmailNotification($subject, $form_type, $form_number, $linkp, $s));
    }

    public function notifD()
    {
        $type = "RDF";
        $message =  'The RDF no. ' . $this->rdf_number . ' has been approved by Finance Department.';
        $link = '/c/itemdisposal/' . $this->rdf_number;
        $s = "Ongoing";

        Notification::send($this->notifUser, new OpmsNotification($type, $message, $link, $s));


        $f = User::whereRoleIs('Warehouse')->first();
        $linkf = "/itemdisposal/" . $this->rdf_number;
        Notification::send($f, new OpmsNotification($type, $message, $linkf, $s));
    }


    /*-----------------------------------------------------------
    ON PAGE LOAD
    -----------------------------------------------------------*/

    public function mount($id)
    {
        if ($id == "logs") {
            //
        } else {
            try {
                $c = ItemDisposal::where('rdf_number', $id)->first();
                if (!empty($c->rdf_number)) {
                    if (!empty($c->checked_date)) {
                        if (empty($c->approved_date)) {
                            $this->showdata($c->id);
                        } else {
                            //
                        }
                        //
                    } else {
                        return abort(404);
                    }
                } else {
                    return abort(404);
                }
            } catch (Exception $e) {
                return abort(404);
            }
        }
    }



    public function clear()
    {
        $this->clearVals();
        $this->dispatchBrowserEvent('changeURL', [
            'entURL' =>  'logs',
        ]);
    }


    /*-----------------------------------------------------------
    SHOW DATA
    -----------------------------------------------------------*/

    public $notifUser;

    public function showdata($id)
    {
        $this->clearVals();
        try {

            $d = ItemDisposal::where('id', $id)->first();
            $this->rdf_number = $d->rdf_number;
            $this->date = $d->date;

            $this->reason = $d->reason;

            $this->dept = (SubDepartment::where('subdept_code', $d->subdept_code)->first())->description;
            $this->ItemArray = ItemDisposal::find($id)->item;

            $this->dispatchBrowserEvent('changeURL', [
                'entURL' =>  $d->rdf_number,
            ]);


            //mark as read
            if (empty($d->read_at)) {
                $this->readat($this->rdf_number);
            }


            if (!empty($d->from)) {
                $u = User::where('school_id', $d->from)->first();
                $this->from = $u->first_name . ' ' . $u->last_name;
                $this->useremail = $u->email;
                $this->notifUser = $u;
            }

            if (!empty($d->endorsedto)) {
                $u = User::where('school_id', $d->endorsedto)->first();
                $this->endorsedto = $u->first_name . ' ' . $u->last_name . ' / ' . $d->endorsed_date;
            }

            if (!empty($d->checkedby)) {
                $u = User::where('school_id', $d->checkedby)->first();
                $this->checkedby = $u->first_name . ' ' . $u->last_name . ' / ' . $d->checked_date;
            }

            if (!empty($d->approvedby)) {
                $u = User::where('school_id', $d->approvedby)->first();
                $this->approvedby = $u->first_name . ' ' . $u->last_name . ' / ' . $d->approved_date;
            }


            if (!empty($d->evaluatedby)) {
                $u = User::where('school_id', $d->evaluatedby)->first();
                $this->evaluatedby = $u->first_name . ' ' . $u->last_name . ' / ' . $d->evaluated_date;
            }

            if (!empty($d->notedby)) {
                $u = User::where('school_id', $d->notedby)->first();
                $this->notedby = $u->first_name . ' ' . $u->last_name . ' / ' . $d->noted_date;
            }

            if (!empty($d->postedby)) {
                $u = User::where('school_id', $d->postedby)->first();
                $this->postedby = $u->first_name . ' ' . $u->last_name . ' / ' . $d->posted_date;
            }
        } catch (Exception $e) {
            $this->clearVals();
            $this->dispatchBrowserEvent('swal_mode', [
                'text' => 'Something went wrong! Please try again later.',
                'type' => 'error',
                'w' => 300,
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
            ItemDisposal::where('rdf_number', $val)->update($this->readData());
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

    /*-----------------------------------------------------------
    CLEAR VALUES
    -----------------------------------------------------------*/
    public function clearVals()
    {
        $this->from = null;
        $this->date = null;
        $this->dept = null;
        $this->rdf_number = null;

        $this->ItemArray = null;

        $this->reason = null;
        $this->endorsedto = null;
        $this->checkedby = null;
        $this->approvedby = null;
        $this->evaluatedby = null;
        $this->checkedby = null;
        $this->approvedby = null;
        $this->saveS = null;
    }



    /*-----------------------------------------------------------
    RENDER
     -----------------------------------------------------------*/

    public function render()
    {
        if (!empty($this->rdf_number)) {
            $this->dispatchBrowserEvent('sample', [
                'rowindex' => $this->rdf_number
            ]);
        }

        $rdf = ItemDisposal::whereNotNull('checked_date')->whereNull('approved_date')->where('rdf_number', 'like', '%' . $this->search . '%')->latest()->get();
        return view('livewire.finance.itemd-sign', [
            'rdf' => $rdf,
        ]);
    }
}
