<?php

namespace App\Http\Livewire\Property;

use App\Models\qrtagging;
use Exception;
use Livewire\Component;

class QrLogs extends Component
{
    public $ItemArray = array(), $search, $filterby = 'qrtaggings.rqr_number';

    /*--------------------------------------------------------------------  
    //ON LOAD PAGE
    --------------------------------------------------------------------*/
    public function mount($id)
    {
        if ($id == 'logs') {
            //
        } else {
            try {
                $val = qrtagging::where('rqr_number', $id)->first();
                if (!empty($val)) {
                    $this->search = $val->rqr_number;
                } else {
                    return abort(404);
                }
            } catch (Exception $e) {
                return abort(404);
            }
        }
    }

    public function updatedSearch()
    {
        $this->dispatchBrowserEvent('changeURL', [
            'entURL' =>  'logs',
        ]);
    }

    public function render()
    {
        $rqr = qrtagging::join('qr_items', 'qr_items.qrtagging_id', '=', 'qrtaggings.id')
            ->where($this->filterby, 'like', '%' . $this->search . '%')
            ->get(['qrtaggings.*', 'qr_items.*']);

        // return dd($rqr);
        return view('livewire.property.qr-logs', [
            'rqr' => $rqr,
        ]);
    }
}
