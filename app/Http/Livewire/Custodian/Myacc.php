<?php

namespace App\Http\Livewire\Custodian;

use App\Models\SerialPropertyCode;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Myacc extends Component
{
    use WithPagination;
    public $entries = 15, $search, $filterby = 'property_code';



    public function render()
    {
        $items = SerialPropertyCode::where($this->filterby, 'like', '%' . $this->search . '%')->where('new_custodian', Auth::user()->school_id)->paginate($this->entries);
        return view('livewire.custodian.myacc', [
            'items' => $items
        ]);
    }
}
