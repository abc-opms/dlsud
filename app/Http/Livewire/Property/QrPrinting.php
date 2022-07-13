<?php

namespace App\Http\Livewire\Property;

use App\Models\QrItems;
use App\Models\qrtagging;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class QrPrinting extends Component
{
    public $filterby = 'rqr_number', $search, $rqr_number, $rowIndex;
    public $here;


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




    /*--------------------------------------------------------------------  
    //ACTION CLICK DOWNLOAD QR
    --------------------------------------------------------------------*/

    public function downloadQR($rqr)
    {
        qrtagging::where('rqr_number', $rqr)->update([
            'generated_date' => Carbon::now(),
            'generatedby' => Auth::user()->school_id,
        ]);

        $this->here = $rqr;

        return redirect('/downloadRequest/' . $rqr);
    }

    /*--------------------------------------------------------------------  
    //search update
    --------------------------------------------------------------------*/

    public function updatedSearch()
    {
        $this->dispatchBrowserEvent('changeURL', [
            'entURL' =>  'logs',
        ]);
    }

    /*--------------------------------------------------------------------  
    //RENDER
    --------------------------------------------------------------------*/


    public function render()
    {
        if (!empty($this->feanum)) {
            $this->dispatchBrowserEvent('qrSample', [
                'rowindex' => $this->rowIndex
            ]);
        }

        $rqr = QrItems::distinct('rqr_numbers')
            ->join('qrtaggings', 'qrtaggings.rqr_number', '=', 'qr_items.rqr_number')
            ->where('qr_items.item_status', 'Approved')
            ->where('qrtaggings.status', 'Done')
            ->where('qrtaggings.rqr_number', 'like', '%' . $this->search . '%')
            ->get('qrtaggings.*');


        return view('livewire.property.qr-printing', [
            'rqr' => $rqr,
        ]);
    }
}
