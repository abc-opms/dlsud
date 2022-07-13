<?php

namespace App\Http\Livewire\Property;

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
    public $checked_date, $approved_date, $fromEmail;
    public $hsign, $cusD, $fromU, $showMySign;



    public function mount($id)
    {
        if ($id == "logs") {
            //
        } else {
            $this->onload($id);
        }
    }

    /**
     * onloadCustodian
     *
     * @return void
     */
    public function onload($id)
    {
        try {
            $c = TransferFurniture::where('rtf_number', $id)->first();

            if (!empty($c->rtf_number)) {

                if ($c->checked_date == null) {
                    $this->showdata($c->id);
                } else {
                    //
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
    Decline transcation
    -----------------------------------------------------------*/


    public function decline()
    {
        try {
            TransferFurniture::where('rtf_number', $this->rtf_number)->update($this->updateD());

            $this->sendEmailD();
            $this->notifD();
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
        } catch (Exception $e) {
            $this->dispatchBrowserEvent('swal_mode', [
                'text' => 'Something went wrong. Please try again later.',
                'type' => 'error',
                'w' => 300,
                'timer' => 2000,
            ]);
        }
    }


    public function updateD()
    {
        return [
            'checked_date' => Carbon::now(),
            'status' => 'Declined',
            'read_at' => null,
        ];
    }

    public function sendEmailD()
    {
        $subject = 'Property Section has declined the RTF no. ' . $this->rtf_number;
        $form_type = "RTF";
        $form_number = $this->rtf_number;
        $s = "Declined";
        $emailtop = User::whereRoleIs('Finance')->first();


        //Custodian
        $link = "http://127.0.0.1:8000/rtf/received/" . $this->rtf_number;
        Mail::to($this->email)->queue(new FormEmailNotification($subject, $form_type, $form_number, $link, $s));

        //from
        $linkf = "http://127.0.0.1:8000/c/rtf/" . $this->rtf_number;
        Mail::to($this->fromEmail)->queue(new FormEmailNotification($subject, $form_type, $form_number, $linkf, $s));
    }


    public function notifD()
    {
        try {
            $s = "Declined";
            $type = "RTF";
            $message =  'Property Section has declined the RTF no. ' . $this->rtf_number;


            $linkc = '/rtf/received/' . $this->rtf_number;
            Notification::send($this->cusD, new OpmsNotification($type, $message, $linkc, $s));


            $linku = '/c/rtf/' . $this->rtf_number;
            Notification::send($this->fromU, new OpmsNotification($type, $message, $linku, $s));

            //
        } catch (Exception $e) {
            //
        }
    }

    /*-----------------------------------------------------------
    SHOW DATA
    -----------------------------------------------------------*/
    public function esign()
    {
        $this->checkedby = Auth::user()->first_name . ' ' . Auth::user()->last_name
            .  ' / ' . Carbon::now();
    }

    public function clearesign()
    {
        $this->checkedby = null;
    }



    public function saveSign()
    {
        try {
            TransferFurniture::where('rtf_number', $this->rtf_number)
                ->update($this->updateData());

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
        } catch (Exception $e) {
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
            'checkedby' => Auth::user()->school_id,
            'checked_date' => Carbon::now(),
            'status' => 'Ongoing',
            'read_at' => null,
        ];
    }

    public $finance;

    public function sendEmailNotif()
    {
        try {
            $subject = 'The RTF no. ' . $this->rtf_number . ' has been checked by Property Section';
            $form_type = "RTF";
            $form_number = $this->rtf_number;
            $s = "Ongoing";
            $emailtop = User::whereRoleIs('Finance')->first();
            $linkp = "http://127.0.0.1:8000/f/rtf/sign/" . $this->rtf_number;


            //FINANCEC
            Mail::to($emailtop->email)->queue(new FormEmailNotification($subject, $form_type, $form_number, $linkp, $s));

            //Custodian
            $link = "http://127.0.0.1:8000/c/rtf/sign/" . $this->rtf_number;
            Mail::to($this->email)->queue(new FormEmailNotification($subject, $form_type, $form_number, $link, $s));

            //from
            $linkf = "http://127.0.0.1:8000/c/rtf/" . $this->rtf_number;
            Mail::to($this->fromEmail)->queue(new FormEmailNotification($subject, $form_type, $form_number, $linkf, $s));
        } catch (Exception $e) {
            //
        }
    }

    public function notif()
    {
        try {
            $s = "Ongoing";
            $type = "RTF";
            $message =  'The RTF no. ' . $this->rtf_number . ' has been checked by Property Section';


            $linkc = '/c/rtf/sign/' . $this->rtf_number;
            Notification::send($this->cusD, new OpmsNotification($type, $message, $linkc, $s));


            $linku = '/c/rtf/' . $this->rtf_number;
            Notification::send($this->fromU, new OpmsNotification($type, $message, $linku, $s));


            //finance
            $linkf = '/f/rtf/sign/' . $this->rtf_number;
            $finance = User::whereRoleIs('Finance')->first();
            Notification::send($finance, new OpmsNotification($type, $message, $linkf, $s));

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

            $this->checked_date = $d->checed_date;

            $this->dispatchBrowserEvent('changeURL', [
                'entURL' =>  $d->rtf_number,
            ]);



            for ($i = 0; $i < count($this->ItemArray); $i++) {
                if ($this->ItemArray[$i]['evaluatedby'] == null || empty($this->ItemArray[$i]['evaluatedby'])) {
                    $this->hsign = 'not available';
                }
            }


            if (!empty($d->from)) {
                $u = User::where('school_id', $d->from)->first();
                $this->from = $u->first_name . ' ' . $u->last_name;
                $this->fromEmail = $u->email;
                $this->fromU = $u;
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
                $this->cusD = $u;
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
        $this->showMySign = null;
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

        $rtf_cus = TransferFurniture::distinct('transfer_furniture.rtf_number')
            ->where('transfer_furniture.status', 'Ongoing')
            ->join(
                'furniture_items',
                'furniture_items.transfer_furniture_id',
                '=',
                'transfer_furniture.id'
            )
            ->whereNotNull('furniture_items.evaluatedby')
            ->whereNull('checked_date')
            ->where('rtf_number', 'like', '%' . $this->search . '%')
            ->latest()->get('transfer_furniture.*');


        return view('livewire.property.rtf-sign', [
            'rtf_cus' => $rtf_cus,
        ]);
    }
}
