<?php

namespace App\Http\Livewire\Property;

use App\Mail\FormEmailNotification;
use App\Models\FurnitureItem;
use App\Models\RoleUser;
use App\Models\SerialPropertyCode;
use App\Models\SubDepartment;
use App\Models\TransferFurniture;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use phpDocumentor\Reflection\Types\This;

class RtfPost extends Component
{

    public $search, $rtf_number, $date, $ItemArray = array(),  $reason;
    public $checkedby, $approvedby, $postedby, $posted_date, $custodian, $receiving_dept, $dept_head, $email;
    public $checked_date, $approved_date;
    public $fromEmail, $from, $to, $newsubdept;

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
                if (!empty($c->approvedby)) {
                    if (empty($c->posted_date)) {
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
    post
    -----------------------------------------------------------*/
    public function post()
    {
        if (!empty($this->dept_head)) {
            TransferFurniture::where('rtf_number', $this->rtf_number)->update($this->updateData());
            $this->updateCustodian();
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
            'postedby' => Auth::user()->school_id,
            'posted_date' => Carbon::now(),
            'status' => 'Done',
            'read_at' => Carbon::now(),
        ];
    }

    public function updateCustodian()
    {
        for ($i = 0; $i < count($this->ItemArray); $i++) {
            SerialPropertyCode::where('property_code', $this->ItemArray[$i]['property_number'])
                ->update($this->dataItem());
        }
    }
    public function dataItem()
    {
        return [
            'new_custodian' => $this->to,
            'old_custodian' => $this->from,
            'subdept_code' => $this->newsubdept,
        ];
    }


    public function sendEmailNotif()
    {
        $subject = 'The RTF no. ' . $this->rtf_number . ' has been posted';
        $form_type = "RTF";
        $form_number = $this->rtf_number;
        $s = "Done";
        $emailtop = $this->fromEmail;
        $linkp = "http://127.0.0.1:8000/c/rtf/" . $this->rtf_number;

        $link = "http://127.0.0.1:8000/rtf/received/" . $this->rtf_number;
        Mail::to($emailtop)->queue(new FormEmailNotification($subject, $form_type, $form_number, $linkp, $s));

        Mail::to($this->email)->queue(new FormEmailNotification($subject, $form_type, $form_number, $link, $s));
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
            $this->checked_date = $d->checked_date;
            $this->approved_date = $d->approved_date;

            $this->dispatchBrowserEvent('changeURL', [
                'entURL' =>  $d->rtf_number,
            ]);

            if (!empty($d->from)) {
                $u = User::where('school_id', $d->from)->first();
                $this->from = $u->first_name . ' ' . $u->last_name;
                $this->fromEmail = $u->email;
                $this->from = $d->from;
            }

            if (!empty($d->dept_head)) {
                $u = User::where('school_id', $d->dept_head)->first();
                $this->dept_head = $u->first_name . ' ' . $u->last_name;
                $this->email = $u->email;
                $this->newsubdept = $u->subdept_code;
            }

            if (!empty($d->receiving_dept)) {
                $this->receiving_dept = (SubDepartment::where('subdept_code', $d->receiving_dept)->first())->description;
            }


            if (!empty($d->custodian)) {
                $u = User::where('school_id', $d->custodian)->first();
                $this->custodian = $u->first_name . ' ' . $u->last_name;
                $this->to = $d->custodian;
            }


            if (!empty($d->checkedby)) {
                $u = User::where('school_id', $d->checkedby)->first();
                $this->checkedby = $u->first_name . ' ' . $u->last_name . ' / ' . $d->checked_date;
            }

            if (!empty($d->approvedby)) {
                $u = User::where('school_id', $d->approvedby)->first();
                $this->approvedby = $u->first_name . ' ' . $u->last_name . ' / ' . $d->approved_date;
            }

            if (!empty($d->postedby)) {
                $u = User::where('school_id', $d->postedby)->first();
                $this->postedby = $u->first_name . ' ' . $u->last_name;
                $this->posted_date = $d->posted_date;
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
        $this->from = null;
        $this->to = null;
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

        $rtf_cus = TransferFurniture::whereNotNull('approvedby')->whereNull('posted_date')->where('rtf_number', 'like', '%' . $this->search . '%')->latest()->get();
        return view('livewire.property.rtf-sign', [
            'rtf_cus' => $rtf_cus,
        ]);
    }
}
