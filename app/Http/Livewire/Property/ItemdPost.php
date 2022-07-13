<?php

namespace App\Http\Livewire\Property;

use App\Mail\FormEmailNotification;
use App\Models\DisposalItem;
use App\Models\ItemDisposal;
use App\Models\RoleUser;
use App\Models\SerialPropertyCode;
use App\Models\SubDepartment;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use App\Notifications\OpmsNotification;
use Illuminate\Support\Facades\Notification;

class ItemdPost extends Component
{
    public $ItemArray = array(), $postedby,  $search;
    public $rdf_number;
    public $to, $from, $date, $dept, $reason, $checkedby, $action, $useremail, $Fuser;


    /*-----------------------------------------------------------
    ON PAGE LOAD
    -----------------------------------------------------------*/

    public function mount($id)
    {
        if ($id == "logs") {
            //
        } else {
            try {
                $c = ItemDisposal::where('status', '!=', 'Declined')->where('rdf_number', $id)->first();
                if (!empty($c->rdf_number)) {
                    if (!empty($c->endorsed_date)) {
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
    }


    /*-----------------------------------------------------------
    POSTED
    -----------------------------------------------------------*/

    public function posted()
    {
        try {
            ItemDisposal::where('rdf_number', $this->rdf_number)->update($this->postedData());
            $this->disposeItem();
            $this->sendEmailNotif();
            $this->notif();
            $this->clear();
            $this->dispatchBrowserEvent('swal_mode', [
                'text' => 'Posted.',
                'type' => 'success',
                'w' => 300,
                'timer' => 2000,
            ]);
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

    public function postedData()
    {
        return [
            'postedby' => Auth::user()->school_id,
            'posted_date' => Carbon::now(),
            'status' => 'Done'
        ];
    }

    public function disposeItem()
    {
        $val = DisposalItem::where('item_disposal_id', $this->rdf_id)->get();

        try {
            foreach ($val as $v) {
                SerialPropertyCode::where('property_code', $v->property_number)->update($this->disData());
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
    public function disData()
    {
        return [
            'item_status' => 'Disposed',
            'inv_status' => 'NotApplicable'
        ];
    }
    /*-----------------------------------------------------------
    NOTIFICATION
    -----------------------------------------------------------*/

    public function sendEmailNotif()
    {
        $subject = 'The RDF no. ' . $this->rdf_number . ' has been posted.';
        $form_type = "RDF";
        $form_number = $this->rdf_number;
        $link = "http://127.0.0.1:8000/c/itemdisposal/" . $this->rdf_number;
        $s = "Done";

        Mail::to($this->useremail)->queue(new FormEmailNotification($subject, $form_type, $form_number, $link, $s));
    }



    public function notif()
    {
        $type = "RDF";
        $message =  'The RDF no. ' . $this->rdf_number . ' has been posted.';
        $link = '/c/itemdisposal/' . $this->rdf_number;
        $s = "Done";

        Notification::send($this->Fuser, new OpmsNotification($type, $message, $link, $s));
    }



    public $rdf_id;
    /*-----------------------------------------------------------
    SHOW DATA
    -----------------------------------------------------------*/
    public function showdata($id)
    {
        $this->clearVals();
        try {

            $d = ItemDisposal::where('id', $id)->first();
            $this->rdf_number = $d->rdf_number;
            $this->rdf_id = $d->id;
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
                $this->Fuser = $u;
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
        $this->saveS = null;
    }

    public function clear()
    {
        $this->clearVals();
        $this->dispatchBrowserEvent('changeURL', [
            'entURL' =>  'logs',
        ]);
    }


    public function render()
    {
        if (!empty($this->rdf_number)) {
            $this->dispatchBrowserEvent('sample', [
                'rowindex' => $this->rdf_number
            ]);
        }

        $rdf = ItemDisposal::whereNotNull('endorsed_date')
            ->whereNull('posted_date')
            ->where('rdf_number', 'like', '%' . $this->search . '%')->latest()->get();

        return view('livewire.property.itemd-post', [
            'rdf' => $rdf,
        ]);
    }
}
