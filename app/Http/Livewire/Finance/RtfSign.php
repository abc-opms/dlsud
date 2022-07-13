<?php

namespace App\Http\Livewire\Finance;

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
    public $checkedby, $approvedby, $postedby, $posted_date, $custodian, $receiving_dept, $dept_head, $email;
    public $fromEmail, $cusU, $cusR;


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
            $c = TransferFurniture::where('rtf_number', $id)->first();
            if (!empty($c->rtf_number)) {

                if (!empty($c->checkedby)) {
                    if (empty($c->approved_date))
                        $this->showdata($c->id);
                    else {
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


    /*-----------------------------------------------------------
    SHOW DATA
    -----------------------------------------------------------*/
    public function esign()
    {
        $this->approvedby = Auth::user()->first_name . ' ' . Auth::user()->last_name
            .  ' / ' . Carbon::now();
    }

    public function clearesign()
    {
        $this->approvedby = null;
    }



    public function saveSign()
    {
        if (!empty($this->approvedby)) {
            TransferFurniture::where('rtf_number', $this->rtf_number)->update($this->updateData());

            $this->sendEmailNotif();
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
            'approvedby' => Auth::user()->school_id,
            'approved_date' => Carbon::now(),
            'status' => 'Ongoing',
            'read_at' => null,
        ];
    }



    public function sendEmailNotif()
    {
        $subject = 'The RTF no. ' . $this->rtf_number . ' has been approved by Finance Department.';
        $form_type = "RTF";
        $form_number = $this->rtf_number;
        $s = "Ongoing";
        $emailtop = User::whereRoleIs('Property')->first();
        $linkp = "http://127.0.0.1:8000/rtf/" . $this->rtf_number;
        $link = "http://127.0.0.1:8000/c/rtf/" . $this->rtf_number;
        $linkf = "http://127.0.0.1:8000/rtf/received/" . $this->rtf_number;


        Mail::to($emailtop->email)->queue(new FormEmailNotification($subject, $form_type, $form_number, $linkp, $s));

        Mail::to($this->email)->queue(new FormEmailNotification($subject, $form_type, $form_number, $linkf, $s));


        Mail::to($this->fromEmail)->queue(new FormEmailNotification($subject, $form_type, $form_number, $link, $s));
    }



    public function notif()
    {
        try {
            $s = "Ongoing";
            $type = "RTF";
            $message =  'The RTF no. ' . $this->rtf_number . ' has been approved by Finance Department.';
            $linkp = "http://127.0.0.1:8000/rtf/" . $this->rtf_number;
            $link = "http://127.0.0.1:8000/c/rtf/" . $this->rtf_number;
            $linkf = "http://127.0.0.1:8000/rtf/received/" . $this->rtf_number;


            $propertyS = User::whereRoleIs('Property')->first();

            Notification::send($propertyS, new OpmsNotification($type, $message, $linkp, $s));

            Notification::send($this->cusR, new OpmsNotification($type, $message, $linkf, $s));

            Notification::send($this->cusU, new OpmsNotification($type, $message, $link, $s));

            //
        } catch (Exception $e) {
            //
        }
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
                $this->fromEmail = $u->email;
                $this->cusR = $u;
            }

            if (!empty($d->dept_head)) {
                $u = User::where('school_id', $d->dept_head)->first();
                $this->dept_head = $u->first_name . ' ' . $u->last_name;
            }

            if (!empty($d->receiving_dept)) {
                $this->receiving_dept = (SubDepartment::where('subdept_code', $d->receiving_dept)->first())->description;
            }


            if (!empty($d->custodian)) {
                $u = User::where('school_id', $d->custodian)->first();
                $this->custodian = $u->first_name . ' ' . $u->last_name;
                $this->email = $u->email;
                $this->cusU = $u;
            }

            if (!empty($d->checkedby)) {
                $u = User::where('school_id', $d->checkedby)->first();
                $this->checkedby = $u->first_name . ' ' . $u->last_name . ' / '
                    . $d->checked_date;
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

        $rtf_cus = TransferFurniture::whereNotNull('checkedby')->whereNull('approved_date')->where('rtf_number', 'like', '%' . $this->search . '%')->latest()->get();
        return view('livewire.finance.rtf-sign', [
            'rtf_cus' => $rtf_cus,
        ]);
    }
}
