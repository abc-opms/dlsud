<?php

namespace App\Http\Livewire\Custodian;

use App\Models\QrItems;
use App\Models\qrtagging;
use App\Models\SerialPropertyCode;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use phpDocumentor\Reflection\Types\This;

class QrStatus extends Component
{
    public $reason, $name, $date, $dept, $ItemArray = array(), $tatus, $search;
    public $rqr_number, $sum;



    public function mount($id)
    {
        if ($id == "logs") {
            //
        } else {
            try {
                $c = qrtagging::where('reqby', Auth::user()->school_id)
                    ->where('rqr_number', $id)->first();
                if (!empty($c->rqr_number)) {
                    $this->showdata($c->id);
                } else {
                    return abort(404);
                }
            } catch (Exception $e) {
                return abort(404);
            }
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
            $this->rqr_number = $id;
            $data = qrtagging::where('id', $id)->first();

            $this->dispatchBrowserEvent('sample', [
                'rowindex' => $this->rqr_number
            ]);
            $this->rqr_number = $data->rqr_number;
            $this->reason = $data->reason;
            $this->date = $data->req_date;
            $this->dept = $data->subdept_code;

            $n = User::where('school_id', $data->reqby)->first();
            $this->name = $n->first_name . ' ' . $n->last_name;

            $pr = QrItems::where('rqr_number', $data->rqr_number)->get();

            if (!empty($pr)) {
                foreach ($pr as $p) {
                    $this->ItemArray[] = SerialPropertyCode::where('property_code', $p->property_number)->first();
                }
            }

            $this->dispatchBrowserEvent('changeURL', [
                'entURL' =>  $data->rqr_number
            ]);

            //
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
        $this->rqr_number = null;
        $this->ItemArray = array();
        $this->reason = null;
        $this->dept = null;
        $this->date = null;
    }


    public function updatedSearch()
    {
        $this->ItemArray = $this->ItemArray;
    }



    public function render()
    {
        if (!empty($this->rqr_number)) {
            $this->dispatchBrowserEvent('sample', [
                'rowindex' => $this->rqr_number
            ]);
        }

        return view('livewire.custodian.qr-status', [
            'rqr_cus' => qrtagging::where('reqby', Auth::user()->school_id)
                ->where('rqr_number', 'like', '%' . $this->search . '%')
                ->latest()->get(),
        ]);
    }
}
