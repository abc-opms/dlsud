<?php

namespace App\Http\Livewire\Records;

use App\Models\Account;
use App\Models\Rritems as ModelsRritems;
use Livewire\Component;
use Livewire\WithPagination;
use Exception;

class AccCode extends Component
{
    use WithPagination;

    public $search, $filterby = "acc_code";
    public $entries = 15;
    public $acc_code, $description, $reference, $class_code, $class_d;


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
            $this->dispatchBrowserEvent('showAcc');

            $this->dispatchBrowserEvent('val', [
                'rowindex' => intval($i),
            ]);
        }
    }


    public function showData($id)
    {
        try {
            $d = Account::where('id', $id)->first();
            if (!empty($d)) {
                $this->acc_code =  $d->acc_code;
                $this->description = $d->description;
                $this->reference = $d->reference;
                $this->class_code = $d->class_code;
                $this->class_d = $d->class_description;
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
        $this->dispatchBrowserEvent('hideAcc');
    }



    public function clearForm()
    {
        $this->acc_code = null;
        $this->description = null;
        $this->reference = null;
        $this->class_code = null;
        $this->class_d = null;
    }


    public function render()
    {
        $acc = Account::where($this->filterby, 'like', '%' . $this->search . '%')->paginate($this->entries);

        return view('livewire.records.acc-code', [
            'acc' => $acc
        ]);
    }
}
