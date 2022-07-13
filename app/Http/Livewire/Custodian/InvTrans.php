<?php

namespace App\Http\Livewire\Custodian;

use App\Models\Inventory;
use App\Models\InventoryItems;
use Carbon\Carbon;
use Carbon\Traits\Date;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class InvTrans extends Component
{
    use WithPagination;
    public $inv_number, $inv_year;
    public $search, $filterby = "property_number";


    public function mount()
    {
        $this->inv_year = Carbon::now()->year;
    }



    public function render()
    {
        $main = InventoryItems::whereYear('created_at', $this->inv_year)
            ->where('subdept_code', Auth::user()->subdept_code)
            ->where($this->filterby, 'like', '%' . $this->search . '%')
            ->latest()->paginate(15);

        $year = InventoryItems::selectRaw('YEAR(created_at) as year')
            ->where('subdept_code', Auth::user()->subdept_code)
            ->distinct()->orderby('created_at', 'desc')->get();



        return view('livewire.custodian.inv-trans', [
            'inv_main' => $main,
            'year' =>  $year
        ]);
    }
}
