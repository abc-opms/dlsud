<?php

namespace App\Http\Livewire\Custodian;

use App\Mail\FormEmailNotification;
use App\Models\Department;
use Livewire\Component;
use App\Models\Fea;
use App\Models\Receivingreports;
use App\Models\Rritems;
use App\Models\SerialPropertyCode;
use App\Models\SubDepartment;
use App\Models\Supplier;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Notifications\OpmsNotification;
use Illuminate\Support\Facades\Notification;

class Featrans extends Component
{

    public $feanum, $items, $prop, $search, $department, $subdept_name, $subdept_code;


    public function mount($id)
    {
        if ($id == "logs") {
            //
        } else {
            $inv = Fea::where('receivedby', Auth::user()->school_id)->whereNull('received_date')->where('fea_number', $id)->first();
            if (!empty($inv)) {
                $this->openForm($id);
            } else {
                return abort(404);
            }
        }
    }

    /*----------------------------------------------------------------
    Sign
    ----------------------------------------------------------------*/

    public function esign()
    {
        $date = Carbon::now()->format('m/d/y');
        $v = Auth::user()->first_name . " " . Auth::user()->last_name . ' / ' . $date;
        $this->rnotedby = $v;
        $this->receivedby = $v;
    }

    public function clearesign()
    {
        $this->rnotedby = null;
        $this->receivedby = null;
    }


    /*----------------------------------------------------------------
    SAve signature
    ----------------------------------------------------------------*/

    public function saveSign()
    {
        if (!empty($this->receivedby)) {
            try {
                Fea::where('fea_number', $this->feanum)->update($this->saveData());
                $this->sendEmailNotif();
                $this->notif();

                $this->dispatchBrowserEvent('swal_mode', [
                    'text' => 'You have successfully sign the FEA' . $this->feanum,
                    'type' => 'success',
                    'w' => 400,
                    'timer' => 4000,
                ]);

                $this->dispatchBrowserEvent('changeURL', [
                    'entURL' => 'logs'
                ]);

                $this->closeForm();
            } catch (Exception  $e) {
                $this->dispatchBrowserEvent('swal_mode', [
                    'text' => 'Something went wrong. Please try again later.',
                    'type' => 'error',
                    'w' => 400,
                    'timer' => 4000,
                ]);
            }
        } else {
            $this->dispatchBrowserEvent('swal_mode', [
                'text' => 'Signature is required',
                'type' => 'warning',
                'w' => 300,
                'timer' => 3000,
            ]);
        }
    }

    public function saveData()
    {
        return [
            'receivedby' => Auth::user()->school_id,
            'received_date' => Carbon::now(),
            'rnotedby' => Auth::user()->school_id,
            'rnoted_date' => Carbon::now(),
            'status' => "Ongoing",
            'read_at' => null,
        ];
    }

    public function sendEmailNotif()
    {
        $emailto = User::whereRoleIs('Property')->first();


        $subjectp = 'FEA' . $this->feanum . ' has been received by Custodian';
        $form_typep = "FEA";
        $form_numberp = $this->feanum;
        $linkp = "http://127.0.0.1:8000/fea/sign/" . $this->feanum;
        $sp = "Ongoing";

        Mail::to($emailto->email)->queue(new FormEmailNotification($subjectp, $form_typep, $form_numberp, $linkp, $sp));
    }


    public function notif()
    {
        $type = 'FEA';
        $message =  'FEA' . $this->feanum . ' has been received by Custodian';
        $link = '/fea/sign/' . $this->feanum;
        $user = User::whereRoleIs('Property')->first();
        $s = "Ongoing";

        Notification::send($user, new OpmsNotification($type, $message, $link, $s));
    }




    /*----------------------------------------------------------------
    open form & Show data
    ----------------------------------------------------------------*/

    public function openForm($val)
    {
        $this->feanum = $val;
        $this->showData($val);
    }

    public function showData($val)
    {
        try {
            $fea = Fea::where('fea_number', $val)->first();

            //mark as read
            if (empty($fea->read_at)) {
                $this->readat();
            }

            //checkedby
            if (!empty($fea->checked_date)) {
                $user = User::where('school_id', $fea->checkedby)->first();
                $this->checkedby =  $user->first_name . " " . $user->last_name . ' / ' . $fea->checked_date;
            }

            //notedby
            if (!empty($fea->noted_date)) {
                $user = User::where('school_id', $fea->notedby)->first();
                $this->receivedby = $user->first_name . " " . $user->last_name . ' / ' . $fea->noted_date;
            }

            //recordedby
            if (!empty($fea->recorded_date)) {
                $user = User::where('school_id', $fea->recordedby)->first();
                $this->receivedby = $user->first_name . " " . $user->last_name . ' / ' . $fea->recorded_date;
            }

            //recivedby
            if (!empty($fea->received_date)) {
                $user = User::where('school_id', $fea->receivedby)->first();
                $this->receivedby = $user->first_name . " " . $user->last_name . ' / ' . $fea->received_date;
            }

            //rnotedby
            if (!empty($fea->rnoted_date)) {
                $user = User::where('school_id', $fea->rnotedby)->first();
                $this->receivedby = $user->first_name . " " . $user->last_name . ' / ' . $fea->rnoted_date;
            }

            $this->dispatchBrowserEvent('changeURL', [
                'entURL' => $val
            ]);

            $data = Receivingreports::where('rr_number', $fea->rr_number)->first();
            $this->fea = $data->fea_number;
            $this->invoice = $data->invoice;
            $this->ponum = $data->ponum . " / " . $fea->rr_number;
            $this->delivery_date = $data->delivery_date;
            $this->invoice_date = $data->invoice_date;
            $this->totalAmount = "₱" . number_format($data->total, 2);
            $this->department = $data->dept_code;

            $sd = SubDepartment::where('subdept_code', $fea->subdept_code)->first();
            $this->subdept_name = $sd->description;
            $this->subdept_code = $fea->subdept_code;

            $this->items = Rritems::where('rr_number', $fea->rr_number)->get();
            $this->prop = SerialPropertyCode::where('rr_number', $fea->rr_number)->get();

            $sup = Supplier::where('supplier_code', $data->supplier_code)->first();
            $this->address = $sup->address;
            $this->name = $sup->name;
            $this->telnum = $sup->telnum . " / " . $sup->faxnum;
        } catch (Exception $e) {
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

    public function readat()
    {
        try {
            Fea::where('fea_number', $this->feanum)->update($this->readData());
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
    /*----------------------------------------------------------------
    Close form
    ----------------------------------------------------------------*/

    public function closeForm()
    {
        $this->feanum = null;
        $this->clearesign();
        $this->dispatchBrowserEvent('changeURL', [
            'entURL' =>  'logs',
        ]);
    }

    /*----------------------------------------------------------------
    Render
    */

    public function render()
    {
        if (!empty($this->feanum)) {
            $this->dispatchBrowserEvent('sample', [
                'rowindex' => $this->feanum
            ]);
        }

        $feacustodian = Fea::whereNull('received_date')->where('fea_number', 'like', '%' . $this->search . '%')->where('receivedby', Auth::user()->school_id)->latest()->get();

        return view('livewire.custodian.featrans', [
            'feacustodian' => $feacustodian,
        ]);
    }
}
