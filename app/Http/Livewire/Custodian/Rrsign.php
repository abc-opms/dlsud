<?php

namespace App\Http\Livewire\Custodian;

use App\Mail\FormEmailNotification;
use App\Models\Receivingreports;
use App\Models\Rritems;
use App\Models\User;
use App\Notifications\OpmsNotification;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;

class Rrsign extends Component
{
    public $delivery_date, $invoice, $invoice_date, $ponum, $dept_code, $total,
        $receivedby, $receipt, $ItemArray, $preparedby, $prepared_date, $rr_number;
    public $signrr, $search, $signd;




    public function mount($id)
    {
        if ($id == "logs") {
            //
        } else {
            try {
                $val = Receivingreports::where('receivedby', Auth::user()->school_id)->whereNull('received_date')->where('rr_number', $id)->first();
                if (!empty($val)) {
                    $this->showdata($val->id);
                } else {
                    return abort(404);
                }
            } catch (Exception $e) {
                return abort(404);
            }
        }
    }

    /*------------------------------------------------------------
    //  close / X page
    ------------------------------------------------------------*/
    public function clear()
    {
        $this->clearTop();
        $this->dispatchBrowserEvent('changeURL', [
            'entURL' =>  'logs',
        ]);
    }


    /*------------------------------------------------------------
    //  DECLINE
    ------------------------------------------------------------*/

    public function decline()
    {
        try {
            Receivingreports::where('rr_number', $this->rr_number)->update($this->dataD());
            $this->dispatchBrowserEvent('hideD');

            $this->sendEmailD();
            $this->notifD();

            $this->dispatchBrowserEvent('swal_mode', [
                'text' => 'You have succesfull Declined the RR no. ' . $this->rr_number,
                'type' => 'success',
                'w' => 400,
                'timer' => 3000,
            ]);
            $this->clear();
            //
        } catch (Exception $e) {
            $this->dispatchBrowserEvent('hideD');
            $this->dispatchBrowserEvent('swal_mode', [
                'text' => 'Something went wrong, please try again later.',
                'type' => 'error',
                'w' => 400,
                'timer' => 3000,
            ]);
        }
    }
    public function dataD()
    {
        return [
            'status' => 'Declined'
        ];
    }


    public function sendEmailD()
    {
        $emailto = $this->pby;
        $subject = 'The RR no.' . $this->rr_number . " has been declined by the Custodian";
        $form_type = "Receiving report";
        $form_number = $this->rr_number;
        $link = "http://127.0.0.1:8000/receivingreport/" . $this->rr_number;
        $s = "Declined";

        Mail::to($emailto->email)->queue(new FormEmailNotification($subject, $form_type, $form_number, $link, $s));
    }

    public function notifD()
    {
        $s = "Declined";
        $type = 'Receiving Report';
        $message = 'RR no.' . $this->rr_number . 'had been declined by the custodian.';
        $link = "/receivingreport/" . $this->rr_number;
        $user = $this->pby;

        Notification::send($user, new OpmsNotification($type, $message, $link, $s));
    }



    /*------------------------------------------------------------
    //  CLEAR VALS
    ------------------------------------------------------------*/

    public function sign()
    {
        try {

            Receivingreports::where('rr_number', $this->rr_number)->update($this->saveData());
            $this->sendEmail();
            $this->notif();

            $this->dispatchBrowserEvent('hideSignRR');
            $this->dispatchBrowserEvent('swal_mode', [
                'text' => 'You have succesfull sign this RR no.' . $this->rr_number,
                'type' => 'success',
                'w' => 400,
                'timer' => 3000,
            ]);
            $this->clear();
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
            'status' => "Ongoing",
            'received_date' => $this->prepared_date,
            'read_at' => null,
        ];
    }



    public function sendEmail()
    {
        $emailto = $this->pby;
        $subject = 'The RR no.' . $this->rr_number . " has been received by Custodian";
        $form_type = "Receiving report";
        $form_number = $this->rr_number;
        $link = "http://127.0.0.1:8000/receivingreport/sign/" . $this->rr_number;
        $s = "Ongoing";

        Mail::to($emailto->email)->queue(new FormEmailNotification($subject, $form_type, $form_number, $link, $s));
    }

    public function notif()
    {
        $s = "Ongoing";
        $type = 'Receiving Report';
        $message = 'RR no.' . $this->rr_number . 'had been received and signed by the custodian.';
        $link = '/receivingreport/sign/' . $this->rr_number;
        $user = $this->pby;

        Notification::send($user, new OpmsNotification($type, $message, $link, $s));
    }


    /*------------------------------------------------------------
    //  Show values
    ------------------------------------------------------------*/

    public $pby, $pby_sid;
    public function showdata($id)
    {
        try {
            $this->supplier_code = $id;
            $data = Receivingreports::where('id', $id)->first();

            $this->dispatchBrowserEvent('sample', [
                'rowindex' => $data->rr_number
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
                $rby = User::where('school_id', $data->receivedby)->first();
                $this->receivedby = $rby->first_name . ' ' . $rby->last_name;
            }

            if (!empty($data->preparedby)) {
                $this->pby = User::where('school_id', $data->preparedby)->first();
                $this->preparedby = $this->pby->first_name . ' ' . $this->pby->last_name;
            }

            $this->prepared_date = $data->prepared_date;

            $this->dispatchBrowserEvent('changeURL', [
                'entURL' =>   $data->rr_number
            ]);

            $this->ItemArray = Rritems::where('rr_number', $data->rr_number)->get();
        } catch (Exception $e) {
            //error message
            $this->dispatchBrowserEvent('swal_mode', [
                'text' => 'Something went wrong, please try again later.',
                'type' => 'error',
                'w' => 400,
                'timer' => 3000,
            ]);
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
        $this->signrr = null;
        $this->signd = null;
    }


    /*------------------------------------------------------------
    //  Render
    ------------------------------------------------------------*/

    public function render()
    {

        $rr = Receivingreports::where('status', 'Active')->where('rr_number', 'like', '%' . $this->search . '%')
            ->whereNull('received_date')
            ->where('receivedby', Auth::user()->school_id)->get();

        return view('livewire.custodian.rrsign', [
            'rr' => $rr
        ]);
    }
}
