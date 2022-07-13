<?php

namespace App\Http\Livewire\Property;

use Livewire\Component;
use App\Models\Fea;
use App\Models\Receivingreports;
use App\Models\Rritems;
use App\Models\SerialPropertyCode;
use App\Models\SubDepartment;
use App\Models\Supplier;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;

class Feastatus extends Component
{

    public $feanum, $items, $prop, $search, $department, $subdept_name, $subdept_code;


    public function mount($id)
    {
        if ($id == "logs") {
            //
        } else {
            try {
                $inv = Fea::where('fea_number', $id)->first();
                if (!empty($inv)) {
                    $this->openForm($id);
                } else {
                    return abort(404);
                }
            } catch (Exception $e) {
                return abort(404);
            }
        }
    }

    /*-------------------------------------------------------------------
    Open & Close form
     -------------------------------------------------------------------*/

    public function openForm($val)
    {
        $this->feanum = $val;
        $this->showData($val);
    }

    public function closeForm()
    {
        $this->feanum = null;
        $this->clearVals();
        $this->dispatchBrowserEvent('changeURL', [
            'entURL' =>  'logs',
        ]);
    }


    /*-------------------------------------------------------------------
    Show Data
     -------------------------------------------------------------------*/
    public function showData($val)
    {
        $this->clearVals();
        try {
            $fea = Fea::where('fea_number', $val)->first();

            //checkedby
            if (!empty($fea->checked_date)) {
                $user = User::where('school_id', $fea->checkedby)->first();
                $this->checkedby =  $user->first_name . " " . $user->last_name . ' / ' . $fea->checked_date;
            }

            //notedby
            if (!empty($fea->noted_date)) {
                $user = User::where('school_id', $fea->notedby)->first();
                $this->notedby = $user->first_name . " " . $user->last_name . ' / ' . $fea->noted_date;
            }

            //recordedby
            if (!empty($fea->recorded_date)) {
                $user = User::where('school_id', $fea->recordedby)->first();
                $this->recordedby = $user->first_name . " " . $user->last_name . ' / ' . $fea->recorded_date;
            }

            //recivedby
            if (!empty($fea->received_date)) {
                $user = User::where('school_id', $fea->receivedby)->first();
                $this->receivedby = $user->first_name . " " . $user->last_name . ' / ' . $fea->received_date;
            }

            //rnotedby
            if (!empty($fea->rnoted_date)) {
                $user = User::where('school_id', $fea->rnotedby)->first();
                $this->rnotedby = $user->first_name . " " . $user->last_name . ' / ' . $fea->rnoted_date;
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

    /*-------------------------------------------------------------------
    Clear Sig
     -------------------------------------------------------------------*/

    public function clearVals()
    {
        $this->receivedby = null;
        $this->checkedby = null;
        $this->recordedby = null;
        $this->notedby = null;
        $this->rnotedby = null;
    }


    /*-------------------------------------------------------------------
    Render
     -------------------------------------------------------------------*/
    public function render()
    {
        if (!empty($this->feanum)) {
            $this->dispatchBrowserEvent('sample', [
                'rowindex' => $this->feanum
            ]);
        }

        $fea = Fea::latest()->where('fea_number', 'like', '%' . $this->search . '%')->get();
        $feacustodian = Fea::where('receivedby', Auth::user()->school_id)->where('fea_number', 'like', '%' . $this->search . '%')->latest()->get();
        return view('livewire.property.feastatus', [
            'feas' => $fea,
            'feacustodian' => $feacustodian,
        ]);
    }
}
