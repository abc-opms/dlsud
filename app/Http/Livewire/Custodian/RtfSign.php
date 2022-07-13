<?php

namespace App\Http\Livewire\Custodian;

use App\Mail\FormEmailNotification;
use App\Models\FurnitureItem;
use App\Models\RoleUser;
use App\Models\SubDepartment;
use App\Models\TransferFurniture;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use App\Notifications\OpmsNotification;
use Illuminate\Support\Facades\Notification;

class RtfSign extends Component
{
    public $search, $rtf_number, $date, $ItemArray = array(),  $reason;
    public $checkedby, $approvedby, $postedby, $posted_date, $custodian, $receiving_dept, $dept_head;
    public $hsign;

    public function mount($id)
    {
        if ($id == "logs") {
            //
        } else {
            $this->onloadCustodian($id);
        }
    }

    /**
     * onloadCustodian
     *
     * @return void
     */
    public function onloadCustodian($id)
    {
        try {
            $c = TransferFurniture::where('custodian', Auth::user()->school_id)->whereNull('dept_head')->where('rtf_number', $id)->first();
            if (!empty($c->rtf_number)) {
                if (!empty($c->checked_date)) {
                    if (empty($c->dept_head)) {
                        $this->showdata($c->id);
                    } else {
                        //
                    }
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
    public function esign()
    {
        $this->dept_head = Auth::user()->first_name . ' ' . Auth::user()->last_name
            .  ' / ' . Carbon::now();
    }

    public function clearesign()
    {
        $this->dept_head = null;
    }



    public function saveSign()
    {
        if (!empty($this->dept_head)) {
            TransferFurniture::where('rtf_number', $this->rtf_number)->update($this->updateData());

            $this->sendEmailNotif();
            $this->notif();
            $this->clearVals();
            $this->dispatchBrowserEvent('changeURL', [
                'entURL' =>  'logs',
            ]);

            $this->dispatchBrowserEvent('swal_mode', [
                'text' => 'Saved',
                'type' => 'success',
                'w' => 200,
                'timer' => 2000,
            ]);
        } else {
            $this->dispatchBrowserEvent('swal_mode', [
                'text' => 'Something went wrong. Please try again later.',
                'type' => 'error',
                'w' => 300,
                'timer' => 2000,
            ]);
        }
    }


    public function updateData()
    {
        return [
            'dept_head' => Auth::user()->school_id,
            'status' => 'Ongoing',
            'read_at' => null,
        ];
    }



    public function sendEmailNotif()
    {
        $subject = 'The RTF no. ' . $this->rtf_number . ' been received by the Custodian';
        $form_type = "RTF";
        $form_number = $this->rtf_number;
        $s = "Ongoing";
        $emailtop = User::whereRoleIs('Property')->first();
        $linkp = "http://127.0.0.1:8000/rtf/" . $this->rtf_number;


        Mail::to($emailtop->email)->queue(new FormEmailNotification($subject, $form_type, $form_number, $linkp, $s));
    }


    public function notif()
    {
        $s = "Ongoing";
        $type = "RTF";
        $message = 'The RTF no. ' . $this->rtf_number . ' been received by the Custodian';
        $link = '/rtf/' . $this->rtf_number;
        $user = User::whereRoleIs('Property')->first();

        Notification::send($user, new OpmsNotification($type, $message, $link, $s));
    }




    /*-----------------------------------------------------------
    SHOW DATA
    -----------------------------------------------------------*/


    public function showdata($id)
    {
        $this->clearVals();
        try {

            $d = TransferFurniture::where('id', $id)->first();
            $this->rtf_number = $d->rtf_number;
            $this->date = $d->date;
            $this->reason = $d->reason;

            $this->dept = (SubDepartment::where('subdept_code', $d->subdept_code)->first())->description;
            $this->ItemArray = TransferFurniture::find($id)->item;


            $this->dispatchBrowserEvent('changeURL', [
                'entURL' =>  $d->rtf_number,
            ]);

            if (!empty($d->from)) {
                $u = User::where('school_id', $d->from)->first();
                $this->from = $u->first_name . ' ' . $u->last_name;
            }

            if (!empty($d->dept_head)) {
                $uz = User::where('school_id', $d->dept_head)->first();
                $this->dept_head = $uz->first_name . ' ' . $uz->last_name;
            }

            if (!empty($d->receiving_dept)) {
                $this->receiving_dept = (SubDepartment::where('subdept_code', $d->receiving_dept)->first())->description;
            }


            if (!empty($d->custodian)) {
                $ux = User::where('school_id', $d->custodian)->first();
                $this->custodian = $ux->first_name . ' ' . $ux->last_name;
            }


            if (!empty($d->checkedby)) {
                $us = User::where('school_id', $d->checkedby)->first();
                $this->checkedby = $us->first_name . ' ' . $us->last_name;
            }

            //mark as read
            if (empty($d->read_at)) {
                $this->readat();
            }
        } catch (Exception $e) {
            $this->clearVals();
            $this->dispatchBrowserEvent('swal_mode', [
                'text' => 'Something went wrong. Please try again later.',
                'type' => 'error',
                'w' => 300,
                'timer' => 2000,
            ]);
        }
    }


    /*-----------------------------------------------------------
   Read at
    -----------------------------------------------------------*/

    public function readat()
    {
        try {
            TransferFurniture::where('rtf_number', $this->rtf_number)->update($this->readData());
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
        $this->rtf_number = null;
        $this->reason = null;
        $this->ItemArray = null;
        $this->rd = null;
        $this->dept_head = null;
        $this->custodian = null;
        $this->checkedby = null;
        $this->approvedby = null;
        $this->postedby = null;
        $this->posted_date = null;
        $this->hsign = null;
    }



    /*-----------------------------------------------------------
    ON PAGE LOAD
    -----------------------------------------------------------*/

    public function render()
    {
        if (!empty($this->rtf_number)) {
            $this->dispatchBrowserEvent('sample', [
                'rowindex' => $this->rtf_number
            ]);
        }


        $rtf_cus = TransferFurniture::where('custodian', Auth::user()->school_id)
            ->whereNotNull('checked_date')
            ->whereNull('dept_head')
            ->where('status', 'Ongoing')
            ->where('rtf_number', 'like', '%' . $this->search . '%')
            ->latest()->get();



        return view('livewire.custodian.rtf-sign', [
            'rtf_cus' => $rtf_cus,

        ]);
    }
}
