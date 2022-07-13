<?php

namespace App\Http\Livewire\Records;

use App\Models\Department;
use App\Models\Rritems as ModelsRritems;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Exception;


class Rritems extends Component
{
    use WithPagination;

    public $search, $filterby = "rr_number";
    public $entries = 15;
    public $acc_code, $qty, $item_d, $oum, $unit_cost, $amount, $rrnum, $acq_date;


    /*-------------------------------------------------------------
    ///////SHOW MODAL
    ----------------------------------------------------------------*/

    /**
     * Table row click action
     *
     * @param  mixed $id
     * @param  mixed $i
     * @return void
     */
    public function show($id, $i)
    {
        if (!empty($id)) {
            $this->rowindex = $i;
            $this->showData($id);
            $this->dispatchBrowserEvent('showRrItem');

            $this->dispatchBrowserEvent('val', [
                'rowindex' => intval($i),
            ]);
        }
    }


    public function showData($id)
    {
        try {
            $d = ModelsRritems::where('id', $id)->first();
            if (!empty($d)) {
                $this->acc_code = $d->acc_code;
                $this->qty = $d->deliver_qty;
                $this->item_d = $d->item_description;
                $this->oum = $d->oum;
                $this->unit_cost = '₱' . $d->unit_cost;
                $this->amount = '₱' . $d->amount;
                $this->rrnum = $d->rr_number;
                $this->acq_date = $d->acq_date;
            }
        } catch (Exception $e) {
            //code
        }
    }



    /**
     * Close Modal
     *
     * @return void
     */
    public function closeModal()
    {
        $this->clearForm();
        $this->dispatchBrowserEvent('hideRrItem');
    }



    public function clearForm()
    {
        $this->acc_code = null;
        $this->qty = null;
        $this->item_d = null;
        $this->oum = null;
        $this->unit_cost = null;
        $this->amount = null;
        $this->rrnum = null;
        $this->acq_date = null;
    }


    public function render()
    {
        $rri = ModelsRritems::where($this->filterby, 'like', '%' . $this->search . '%')->paginate($this->entries);

        $rrcus = "";

        return view('livewire.records.rritems', [
            'rritems' => $rri,
            'rrcus' => $rrcus
        ]);
    }
}
