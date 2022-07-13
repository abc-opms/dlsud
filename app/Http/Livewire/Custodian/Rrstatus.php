<?php

namespace App\Http\Livewire\Custodian;

use Livewire\Component;
use Livewire\WithPagination;
use Exception;
use App\Models\Receivingreports;
use App\Models\RoleUser;
use App\Models\Rritems;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Rrstatus extends Component
{
    public $delivery_date, $invoice, $invoice_date, $ponum, $dept_code, $total,
        $receivedby, $receipt, $checkedby, $ItemArray, $preparedby, $prepared_date, $rr_number;
    public $signrr, $search, $valID, $fea_number, $sum;



    /*------------------------------------------------------------
    ONLOAD FUNCTION
    ------------------------------------------------------------*/

    public function mount($id)
    {
        if ($id == "logs") {
            //
        } else {
            try {
                $role = (RoleUser::where('user_id', Auth::user()->id)->first())->role_id;
                if ($role == 3) {
                    $this->onloadCustodian($id);
                } else {
                    $this->onload($id);
                }
            } catch (Exception $e) {
                return abort(404);
            }
        }
    }


    /**
     * onload
     *
     * @return void
     */
    public function onload($id)
    {
        try {
            $c = Receivingreports::where('rr_number', $id)->first();
            if (!empty($c->rr_number)) {
                $this->showdata($c->id);
            } else {
                return abort(404);
            }
        } catch (Exception $e) {
            return abort(404);
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
            $c = Receivingreports::where('receivedby', Auth::user()->school_id)->where('rr_number', $id)->first();
            if (!empty($c->rr_number)) {
                $this->showdata($c->id);
            } else {
                return abort(404);
            }
        } catch (Exception $e) {
            return abort(404);
        }
    }

    /*------------------------------------------------------------
    On page close/ x form page
    ------------------------------------------------------------*/


    public function clear()
    {
        $this->clearvars();
        $this->dispatchBrowserEvent('changeURL', [
            'entURL' =>  'logs',
        ]);
    }

    /*------------------------------------------------------------
    Show values
    ------------------------------------------------------------*/


    public function showdata($id)
    {
        try {
            $this->clearvars();
            $this->supplier_code = $id;
            $data = Receivingreports::where('id', $id)->first();

            $this->dispatchBrowserEvent('sample', [
                'rowindex' => $data->rr_number
            ]);
            $this->sum = $data->total;
            $this->rr_number = $data->rr_number;
            $this->supplier_code = $data->supplier_code;
            $this->ponum = $data->ponum;
            $this->delivery_date = $data->delivery_date;
            $this->invoice = $data->invoice;
            $this->invoice_date =  $data->invoice_date;
            $this->total = $data->total;
            $this->receipt = $data->receipt_photo_path;
            $this->dept_code = $data->dept_code;
            $this->fea_number = $data->fea_number;

            if (!empty($data->receivedby)) {
                $rby = User::where('school_id', $data->receivedby)->first();
                $this->receivedby = $rby->first_name . ' ' . $rby->last_name;
                if (!empty($data->received_date))
                    $this->receivedby .= ' / ' . $data->received_date;
            }


            if (!empty($data->preparedby)) {
                $pby = User::where('school_id', $data->preparedby)->first();
                $this->preparedby = $pby->first_name . ' ' . $pby->last_name . ' / ' .  $data->prepared_date;
            }

            if (!empty($data->checkedby)) {
                $pby = User::where('school_id', $data->checkedby)->first();
                $this->checkedby = $pby->first_name . ' ' . $pby->last_name . ' / ' . $data->checked_date;
            }



            $this->dispatchBrowserEvent('changeURL', [
                'entURL' =>  $data->rr_number
            ]);

            $this->ItemArray = Rritems::where('rr_number', $data->rr_number)->get();
        } catch (Exception $e) {
            $this->clear();
            $this->dispatchBrowserEvent('swal_mode', [
                'text' => 'Something went wrong, please try again later.',
                'type' => 'error',
                'w' => 400,
                'timer' => 3000,
            ]);
        }
    }

    /*------------------------------------------------------------
    Close values
    ------------------------------------------------------------*/

    public function close()
    {
        $this->clearvars();
    }


    /*------------------------------------------------------------
    CLEAR VALS
    ------------------------------------------------------------*/

    public function clearvars()
    {
        $this->supplier_code = null;
        $this->delivery_date = null;
        $this->invoice = null;
        $this->invoice_date = null;
        $this->ponum = null;
        $this->dept_code = null;
        $this->receivedby = null;
        $this->receipt = null;

        $this->ItemArray =  array();
        $this->preparedby = null;
        $this->prepared_date = null;
        $this->rr_number = null;
        $this->valID = null;
        $this->checkedby = null;
    }


    /*------------------------------------------------------------
    //Render
    ------------------------------------------------------------*/

    public function render()
    {
        $rr = Receivingreports::where('rr_number', 'like', '%' . $this->search . '%')->latest()->get();
        $rrc = Receivingreports::where('receivedby', Auth::user()->school_id)->where('rr_number', 'like', '%' . $this->search . '%')->latest()->get();
        return view('livewire.custodian.rrstatus', [
            'rr' => $rr,
            'rrc' => $rrc
        ]);
    }
}
