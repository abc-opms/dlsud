<?php

namespace App\Http\Livewire\Property;

use App\Models\Inventory;
use App\Models\InventoryItems;
use App\Models\User;
use Carbon\Carbon;
use Carbon\Traits\Date;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\App;

class InvLogs extends Component
{
    public $inv_number, $inv_year;
    public $search, $filterby = "subdept_code";
    public $show, $t;


    public function mount()
    {
        $this->inv_year = Carbon::now()->year;
    }

    public function download($item, $total)
    {
        $filename = "inventory-" . $this->inv_year;
        switch ($this->filterby) {
            case "subdept_code":
            case "inv_number":
                if (!empty($this->search)) {
                    $in = Inventory::where('inv_number', $item[0]['inv_number'])->first();
                    $inum = $in->inv_number;
                    $filename .= "-subdept-" . $in->subdept_code;
                } else {
                    $in = array();
                    $inum = "";
                }
                break;
            default:
                $in = array();
                break;
        }



        $nby = "";
        $rby = "";
        $cby = "";

        if (!empty($in->notedby)) {
            $nby = User::where('school_id', $in->notedby)->first();
        }

        if (!empty($in->countedby)) {
            $cby = User::where('school_id', $in->countedby)->first();
        }
        if (!empty($in->receivedby)) {
            $rby = User::where('school_id', $in->receivedby)->first();
        }


        $val = [
            'total' => number_format(floatval($this->t), 2, '.', ','),
            'inv_main' => $item,
            'inv_number' => $inum,
            'rby'  => $rby,
            'nby' => $nby,
            'cby' => $cby
        ];




        $pdfContent = PDF::loadView('pdf-form.inventory', $val)->output();
        return response()->streamDownload(
            fn () => print($pdfContent),
            $filename . ".pdf"
        );
    }


    public function render()
    {
        $this->t = InventoryItems::whereYear('created_at', $this->inv_year)
            ->where($this->filterby, 'like', '%' . $this->search . '%')
            ->sum('amount');

        return view('livewire.property.inv-logs', [
            'inv_main' => InventoryItems::whereYear('created_at', $this->inv_year)
                ->where($this->filterby, 'like', '%' . $this->search . '%')
                ->latest()->get(),

            'total' => number_format(floatval($this->t), 2, '.', ','),
            'year' => InventoryItems::selectRaw('YEAR(created_at) as year')
                ->distinct()->orderby('created_at', 'desc')->get(),
        ]);
    }
}
