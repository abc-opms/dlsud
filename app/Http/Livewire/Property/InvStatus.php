<?php

namespace App\Http\Livewire\Property;

use App\Models\Department;
use App\Models\Inventory;
use App\Models\InventoryItems;
use App\Models\SerialPropertyCode;
use App\Models\SubDepartment;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class InvStatus extends Component
{
    public $preview, $ItemsInv = array(), $search;
    public  $status, $dept, $slist;
    public $codeD, $inv_number, $scode;

    public function mount($id)
    {
        if ($id == 'logs') {
            //
        } else {
            try {
                $inv = Inventory::where('subdept_code', $id)->first();
                if (!empty($inv)) {
                    $this->viewList($inv->subdept_code);
                } else {
                    return abort(404);
                }
            } catch (Exception $e) {
                return abort(404);
            }
        }
    }

    public function viewList($subdept)
    {
        try {
            $this->clearVals();
            $this->preview = 'show';
            $this->ItemsInv = InventoryItems::where('subdept_code', $subdept)
                ->orderby('status')->get();

            $this->scode = $subdept;
            $this->inv_number = $this->ItemsInv[0]['inv_number'];
            $this->dispatchBrowserEvent('changeURL', [
                'entURL' =>  $subdept,
            ]);
        } catch (Exception $e) {
            $this->dispatchBrowserEvent('swal_mode', [
                'text' => 'Something went wrong, please try again later.',
                'type' => 'error',
                'w' => 400,
                'timer' => 3000,
            ]);
        }
    }

    public function updatedStatus()
    {
        $this->ItemsInv = InventoryItems::where('status', 'like', '%' . $this->status . '%')
            ->where('subdept_code', $this->scode)
            ->where('inv_number', $this->inv_number)
            ->orderby('status')->get();
    }

    public function clearVals()
    {
        $this->preview = null;
        $this->dcode = null;
        $this->ItemsInv = null;
        $this->scode = null;
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
        if (!empty($this->scode)) {
            $this->dispatchBrowserEvent('sample', [
                'rowindex' => $this->scode
            ]);
        }


        $invList = Inventory::where('status', '!=', 'Done')
            ->whereNull('countedby')
            ->where('subdept_code', 'like', '%' . $this->search . '%')
            ->get();

        return view('livewire.property.inv-status', [
            'invlist' => $invList,
        ]);
    }
}
