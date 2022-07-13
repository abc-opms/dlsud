<?php

namespace App\Http\Livewire\Warehouse;

use App\Mail\FormEmailNotification;
use App\Models\Receivingreports;
use App\Models\Rritems;
use App\Models\Supplier;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use App\Notifications\OpmsNotification;
use Illuminate\Support\Facades\Notification;


class Rrlogs extends Component
{
    public $searchRR, $pp_position;
    public $delivery_date, $invoice, $invoice_date, $ponum, $dept_code, $total,
        $receivedby, $receipt, $ItemArray, $preparedby, $prepared_date, $rr_number, $checkedby;
    public $openTransaction;


    public function mount($id)
    {
        if ($id == "logs") {
            //
        } else {
            try {
                $val = Receivingreports::whereNotNull('received_date')->whereNull('checked_date')->where('rr_number', $id)->first();
                if (!empty($val)) {
                    $this->preview($val->id);
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
        $this->clearTop();
        $this->dispatchBrowserEvent('changeURL', [
            'entURL' =>  'logs',
        ]);
    }

    /*------------------------------------------------------------
    Open form
    ------------------------------------------------------------*/

    public function openform()
    {
        return redirect('/create/receivingreport');
    }

    /*------------------------------------------------------------
    SAVE SIGNATURE
    ------------------------------------------------------------*/

    public function esign()
    {
        $date = Carbon::now()->format('m/d/y');
        $v = Auth::user()->first_name . " " . Auth::user()->last_name . ' / ' . $date;
        $this->checkedby = $v;
    }

    public function clearesign()
    {
        $this->checkedby = null;
    }


    public function sign()
    {
        try {
            if (!empty($this->checkedby)) {
                Receivingreports::where('rr_number', $this->rr_number)->update($this->saveData());
                $this->dispatchBrowserEvent('swal_mode', [
                    'text' => 'You have succesfully sign this ' . $this->rr_number,
                    'type' => 'success',
                    'w' => 400,
                    'timer' => 5000,
                ]);

                $this->sendEmail();
                $this->notif();

                $this->clearTop();
                $this->dispatchBrowserEvent('changeURL', [
                    'entURL' =>   'logs'
                ]);
            } else {
                $this->dispatchBrowserEvent('swal_mode', [
                    'text' => 'Signature is required.',
                    'type' => 'warning',
                    'w' => 300,
                    'timer' => 3000,
                ]);
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

    public function saveData()
    {
        return [
            'status' => "Done",
            'checked_date' => Carbon::now(),
            'checkedby' => Auth::user()->school_id,
            'read_at' => null
        ];
    }

    public function sendEmail()
    {
        try {
            $emailto = $this->rby;
            $subject = 'The RR no.' . $this->rr_number . " has been completed.";
            $form_type = "Receiving report";
            $form_number = $this->rr_number;
            $link = "http://127.0.0.1:8000/c/receivingreport/" . $this->rr_number;
            $s = "Done";

            Mail::to($emailto->email)->queue(new FormEmailNotification($subject, $form_type, $form_number, $link, $s));


            $emailtop = User::whereRoleIs('Property')->first();
            $subjectp = 'New receiving report has been created.';
            $form_typep = "Receiving report";
            $form_numberp = $this->rr_number;
            $linkp = "http://127.0.0.1:8000/create/fea/" . $this->rr_number;
            $sp = "Done";

            Mail::to($emailtop->email)->queue(new FormEmailNotification($subjectp, $form_typep, $form_numberp, $linkp, $sp));
        } catch (Exception $e) {
            //
        }
    }

    public function notif()
    {
        try {
            $type = 'Receiving Report';
            $message =  "The RR no. '.$this->rr_number .' had been completed.";
            $link = '/c/receivingreport/' . $this->rr_number;
            $user = $this->rby;
            $s = "Done";
            Notification::send($user, new OpmsNotification($type, $message, $link, $s));


            $property = User::whereRoleIs('Property')->first();
            $messagep =  "New receiving report has been created.";
            $linkp = '/create/fea/' . $this->rr_number;

            Notification::send($property, new OpmsNotification($type, $messagep, $linkp, $s));
        } catch (Exception $e) {
            //
        }
    }


    /*------------------------------------------------------------
    PREVIEW
    ------------------------------------------------------------*/

    public  $rby;
    public function preview($id)
    {
        try {
            $this->clearTop();
            $this->supplier_code = $id;
            $data = Receivingreports::where('id', $id)->first();

            $this->dispatchBrowserEvent('sample', [
                'rowindex' => $data->rr_number
            ]);

            $this->dispatchBrowserEvent('changeURL', [
                'entURL' =>   $data->rr_number
            ]);

            $this->rr_number = $data->rr_number;
            $this->supplier_code = $data->supplier_code;
            $this->ponum = $data->ponum;
            $this->delivery_date = $data->delivery_date;
            $this->invoice = $data->invoice;
            $this->invoice_date =  $data->invoice_date;
            $this->total = $data->total;
            $this->receipt = $data->receipt_photo_path;
            $this->dept_code = $data->dept_code;


            if (empty($data->read_at)) {
                $this->readat();
            }

            if (!empty($data->receivedby)) {
                $this->rby = User::where('school_id', $data->receivedby)->first();
                $this->receivedby =  $this->rby->first_name . ' ' .  $this->rby->last_name . ' / ' . $data->received_date;
            }

            if (!empty($data->preparedby)) {
                $pby = User::where('school_id', $data->preparedby)->first();
                $this->preparedby = $pby->first_name . ' ' . $pby->last_name;
            }


            $this->prepared_date = $data->prepared_date;



            $this->ItemArray = Rritems::where('rr_number', $data->rr_number)->get();
        } catch (Exception $e) {
            //
        }
    }

    /*------------------------------------------------------------
    //  Mark as read
    ------------------------------------------------------------*/

    public function readat()
    {
        try {
            Receivingreports::where('rr_number', $this->rr_number)->update($this->readData());
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

    /*------------------------------------------------------------
    //  CLEAR VALS
    ------------------------------------------------------------*/

    public function clearTop()
    {
        $this->supplier_code = null;
        $this->delivery_date = null;
        $this->invoice = null;
        $this->invoice_date = null;
        $this->ponum = null;
        $this->dept_code = null;
        $this->receivedby = null;
        $this->receipt = null;

        $this->ItemArray =  null;
        $this->preparedby = null;
        $this->prepared_date = null;
        $this->rr_number = null;
        $this->checkedby = null;
    }

    /*------------------------------------------------------------
    //  Render
    ------------------------------------------------------------*/

    public function render()
    {
        //Maintain highlight on table
        $this->dispatchBrowserEvent('sample', [
            'rowindex' => $this->rr_number
        ]);

        $rrnums = Receivingreports::whereNotNull('received_date')->whereNull('checked_date')->where('rr_number', 'like', '%' . $this->searchRR . '%')->latest()->get();

        return view('livewire.warehouse.rrlogs', [
            'rrnums' => $rrnums,
        ]);
    }
}
