<?php

namespace App\Http\Livewire\Property;

use App\Models\DisposalItem;
use App\Models\Fea;
use App\Models\Inventory;
use App\Models\ItemDisposal;
use App\Models\SerialPropertyCode;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use phpDocumentor\Reflection\DocBlock\Serializer;
use Symfony\Component\Console\Input\Input;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportsCreate extends Component
{
    public $formType, $from_date, $to_date, $filterBy = 'subdept_code', $search, $dateVal, $openForm;
    public $feaVals, $MainTotal, $temp_val;
    public $show, $dates, $average, $total_items;

    public function updatedFormType()
    {
        $this->clearVals();
        $this->openForm = null;
        $this->dateVal = null;
        $this->search = null;
        $this->clear();
    }

    /*----------------------------------------------------
    main
    -------------------------------------------------------*/
    public function search()
    {
        if (!empty($this->formType)) {
            $this->validate([
                'from_date' => 'required',
                'to_date' => 'required'
            ]);
            switch ($this->formType) {
                case 'fea':
                    $this->FEAsearchRange();
                    break;
                case 'rdf':
                    $this->RDFsearchRange();
                    break;
            }
        }
    }



    public function allS()
    {
        if (!empty($this->formType)) {
            $this->openForm = "Show";
            $this->clearVals();

            switch ($this->formType) {
                case 'fea':
                    $this->FEAsearchAll();
                    break;
                case 'rdf':
                    $this->RDFsearchAll();
                    break;
            }
        }
    }



    public function updatedSearch()
    {
        if (!empty($this->search)) {
            switch ($this->formType) {
                case 'fea':
                    $this->FEAfilter();
                    break;
                case 'rdf':
                    $this->RDFfilter();

                    break;
            }
        } else {
            $this->MainTotal = $this->tempTotal;
            $this->feaVals = $this->temp_val;
        }
    }


    public $tempTotal;
    public function copyVals()
    {
        $this->temp_val = array();
        $this->tempTotal = $this->MainTotal;

        foreach ($this->feaVals as $f) {
            $this->temp_val[] = $f;
        }
    }


    /*----------------------------------------------------
    RDF
    -------------------------------------------------------*/


    public function RDFsearchRange()
    {
        $this->clearVals();
        $this->openForm = "Show";
        $ff = ItemDisposal::whereBetween('posted_date', [$this->from_date, $this->to_date])
            ->orderBy('item_disposals.posted_date', 'asc')->get();

        $adur = 0;
        foreach ($ff as $f) {
            $from = new DateTime($f->date);
            $to = new DateTime($f->posted_date);
            $numI = DisposalItem::where('item_disposal_id', $f->id)->count();
            $this->feaVals[] = array(
                'rdf_number' => $f->rdf_number,
                'numItem' => $numI,
                'subdept' => $f->subdept_code,
                'date_created' => date('d-m-Y', strtotime($f->date)),
                'date_recorded' => date('d-m-Y', strtotime($f->posted_date)),
                'duration' => date_diff($from, $to)->days,
            );
            $this->total_items += $numI;
            $adur += date_diff($from, $to)->days;
        }
        $this->copyVals();
        $this->average = $adur;
        $this->dates = date_format($from, "Y/m/d") . ' to ' . date_format($to, "Y/m/d");
    }


    public function RDFsearchAll()
    {

        $ff = ItemDisposal::orderBy('posted_date', 'asc')->get();
        $adur = 0;
        foreach ($ff as $f) {
            $from = new DateTime($f->date);
            $to = new DateTime($f->posted_date);
            $numI = DisposalItem::where('item_disposal_id', $f->id)->count();
            $this->feaVals[] = array(
                'rdf_number' => $f->rdf_number,
                'numItem' => $numI,
                'subdept' => $f->subdept_code,
                'date_created' => date('d-m-Y', strtotime($f->date)),
                'date_recorded' => date('d-m-Y', strtotime($f->posted_date)),
                'duration' => date_diff($from, $to)->days,
            );
            $this->total_items += $numI;
            $adur += date_diff($from, $to)->days;
        }
        $this->copyVals();
        $this->average = $adur;
        $this->dates = date_format($from, "Y/m/d") . ' to ' . date_format($to, "Y/m/d");
    }


    public function RDFfilter()
    {
        if (!empty($this->from_date)) {
            $ff = ItemDisposal::whereBetween('posted_date', [$this->from_date, $this->to_date])
                ->where($this->filterByRdf, 'like', '%' . $this->searchRdf . '%')
                ->orderBy('item_disposals.posted_date', 'asc')->get();
        } else {
            $ff = ItemDisposal::where($this->filterByRdf, 'like', '%' . $this->searchRdf . '%')
                ->orderBy('item_disposals.posted_date', 'asc')->get();
        }

        $adur = 0;
        foreach ($ff as $f) {
            $from = new DateTime($f->date);
            $to = new DateTime($f->posted_date);
            $numI = DisposalItem::where('item_disposal_id', $f->id)->count();
            $this->feaVals[] = array(
                'rdf_number' => $f->rdf_number,
                'numItem' => $numI,
                'subdept' => $f->subdept_code,
                'date_created' => date('d-m-Y', strtotime($f->date)),
                'date_recorded' => date('d-m-Y', strtotime($f->posted_date)),
                'duration' => date_diff($from, $to)->days,
            );
            $this->total_items += $numI;
            $adur += date_diff($from, $to)->days;
        }
        $this->copyVals();
        $this->average = $adur;
        // $this->dates = date_format($from, "Y/m/d") . ' to ' . date_format($to, "Y/m/d");
    }

    public function RDFpdf()
    {
        $val = [
            'items' => $this->feaVals,
            'total_num' => count($this->feaVals),
            'average' => $this->average / (count($this->feaVals)),
            'dates' => $this->dates,
            'totalItem' => $this->total_items,
        ];

        $pdfContent = PDF::loadView('pdf-form.report-rdf', $val)->output();
        return response()->streamDownload(
            fn () => print($pdfContent),
            "fea.pdf"
        );
    }

    /*----------------------------------------------------
    FEA
    -------------------------------------------------------*/

    public function FEAsearchRange()
    {
        $this->clearVals();
        $this->openForm = "Show";
        $ff = Fea::whereBetween('recorded_date', [$this->from_date, $this->to_date])
            ->orderBy('feas.recorded_date', 'asc')->get();

        $ttl = 0;
        $adur = 0;

        foreach ($ff as $f) {
            $this->total_items = 0;
            $from = new DateTime($f->checked_date);
            $to = new DateTime($f->recorded_date);
            $numI = SerialPropertyCode::where('fea_number', $f->fea_number)->count();
            $this->feaVals[] = array(
                'fea_number' => $f->fea_number,
                'numItem' => $numI,
                'subdept' => $f->subdept_code,
                'total_amount' =>  number_format(floatval($f->total_amount), 2, '.', ','),
                'date_created' => date('d-m-Y', strtotime($f->checked_date)),
                'date_recorded' => date('d-m-Y', strtotime($f->recorded_date)),
                'duration' => date_diff($from, $to)->days,
            );
            $ttl += floatval($f->total_amount);
            $this->total_items += $numI;
            $adur += date_diff($from, $to)->days;
        }
        $this->MainTotal = number_format(floatval($ttl), 2, '.', ',');
        $this->copyVals();
        $this->average = $adur;
        $this->dates = date_format($from, "Y/m/d") . ' to ' . date_format($to, "Y/m/d");
    }


    public function FEAsearchAll()
    {
        $ff = Fea::orderBy('recorded_date', 'asc')->get();
        $ttl = 0;
        $adur = 0;

        foreach ($ff as $f) {
            $this->total_items = 0;
            $from = new DateTime($f->checked_date);
            $to = new DateTime($f->recorded_date);
            $numI = SerialPropertyCode::where('fea_number', $f->fea_number)->count();

            $this->feaVals[] = array(
                'fea_number' => $f->fea_number,
                'numItem' => $numI,
                'subdept' => $f->subdept_code,
                'total_amount' =>  number_format(floatval($f->total_amount), 2, '.', ','),
                'date_created' => date('d-m-Y', strtotime($f->checked_date)),
                'date_recorded' => date('d-m-Y', strtotime($f->recorded_date)),
                'duration' => date_diff($from, $to)->days,
            );
            $ttl += floatval($f->total_amount);
            $this->total_items += $numI;
            $adur += date_diff($from, $to)->days;
        }

        $this->MainTotal = number_format(floatval($ttl), 2, '.', ',');
        $this->copyVals();
        $this->average = $adur;
        $this->dates = date_format($from, "Y/m/d") . ' to ' . date_format($to, "Y/m/d");
    }


    public function FEAfilter()
    {
        $ff = array();
        if (!empty($this->from_date)) {
            $ff = Fea::whereBetween('recorded_date', [$this->from_date, $this->to_date])
                ->where($this->filterBy, 'like', '%' . $this->search . '%')
                ->orderBy('feas.recorded_date', 'asc')->get();
        } else {
            $ff = Fea::where($this->filterBy, 'like', '%' . $this->search . '%')
                ->orderBy('feas.recorded_date', 'asc')->get();
        }

        $ttl = 0;
        $adur = 0;
        if (count($ff) != 0) {
            $this->total_items = 0;
            $this->feaVals = array();
            foreach ($ff as $f) {

                $from = new DateTime($f->checked_date);
                $to = new DateTime($f->recorded_date);
                $d = date_diff($from, $to)->days;
                $numI = SerialPropertyCode::where('fea_number', $f->fea_number)->count();
                $this->feaVals[] = array(
                    'fea_number' => $f->fea_number,
                    'numItem' => SerialPropertyCode::where('fea_number', $f->fea_number)->count(),
                    'subdept' => $f->subdept_code,
                    'total_amount' => $f->total_amount,
                    'date_created' => date('d-m-Y', strtotime($f->checked_date)),
                    'date_recorded' => date('d-m-Y', strtotime($f->recorded_date)),
                    'duration' => $d,
                );
                $ttl += floatval($f->total_amount);
                $this->total_items += $numI;
                $adur += date_diff($from, $to)->days;
            }
            $this->MainTotal = number_format(floatval($ttl), 2, '.', ',');
            $this->average = $adur;
            $this->dates = date_format($from, "Y/m/d") . ' to ' . date_format($to, "Y/m/d");
        } else {
            $this->dispatchBrowserEvent('swal_mode', [
                'text' => 'No ' . $this->search . ' has found in ' . $this->filterBy,
                'type' => 'error',
                'w' => 400,
                'timer' => 3000,
            ]);
        }
    }


    public function FEApdf()
    {
        $val = [
            'type' => 'FEA',
            'items' => $this->feaVals,
            'total_num' => count($this->feaVals),
            'average' => $this->average / (count($this->feaVals)),
            'dates' => $this->dates,
            'totalItem' => $this->total_items,
        ];

        $pdfContent = PDF::loadView('pdf-form.report-fea', $val)->output();
        return response()->streamDownload(
            fn () => print($pdfContent),
            "fea.pdf"
        );
    }



    /*----------------------------------------------------
    CLEAR
    -------------------------------------------------------*/

    public function clearVals()
    {
        $this->MainTotal = null;
        $this->feaVals = array();
    }


    public function clear()
    {
        $this->total_items = 0;
        $this->from_date = null;
        $this->to_date = null;
        $this->filterBy = 'subdept_code';
        $this->search = null;
        $this->filterByRdf = 'subdept_code';
        $this->searchRdf = null;
        $this->openForm = null;
    }

    public function clearAll()
    {
        $this->formType = null;
        $this->clearVals();
        $this->clear();
    }
    /*----------------------------------------------------
    render
    -------------------------------------------------------*/
    public function render()
    {
        //  $start = (int)((Inventory::select(DB::raw('YEAR(created_at) as yearStart'))->orderBy('created_at', 'asc')
        // ->first())->yearStart);

        $last = (int)((Fea::select(DB::raw('YEAR(created_at) as yearEnd'))->orderBy('created_at', 'desc')
            ->first())->yearEnd);



        return view('livewire.property.reports-create', [
            'yearRange' => range(date($last), 2000),
        ]);
    }
}
