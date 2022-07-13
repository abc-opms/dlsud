<?php

namespace App\Http\Livewire\Custodian;


use App\Models\ItemDisposal;
use App\Models\RoleUser;
use App\Models\SubDepartment;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ItemdStatus extends Component
{
    public $ItemArray = array(), $postedby,  $search;
    public $rdf_number;
    public $to, $from, $date, $dept, $reason, $checkedby;


    public function mount($id)
    {
        if ($id == "logs") {
            //
        } else {
            $role = (RoleUser::where('user_id', Auth::user()->id)->first())->role_id;
            if ($role == 3) {
                $this->onloadCustodian($id);
            } else {
                $this->onload($id);
            }
        }
    }


    /**
     * onload
     *
     * @return void
     */
    public function onload($id)
    {
        try {
            $c = ItemDisposal::where('rdf_number', $id)->first();
            if (!empty($c->rdf_number)) {
                $this->showdata($c->id);
            } else {
                return abort(404);
            }
        } catch (Exception $e) {
            return abort(404);
        }
    }


    /**
     * onloadCustodian
     *
     * @return void
     */
    public function onloadCustodian($id)
    {
        try {
            $c = ItemDisposal::where('from', Auth::user()->school_id)->where('rdf_number', $id)->first();
            if (!empty($c->rdf_number)) {
                $this->showdata($c->id);
            } else {
                return abort(404);
            }
        } catch (Exception $e) {
            return abort(404);
        }
    }


    public function clear()
    {
        $this->clearVals();
        $this->dispatchBrowserEvent('changeURL', [
            'entURL' =>  'logs',
        ]);
    }



    /*-----------------------------------------------------------
    SHOW DATA
    -----------------------------------------------------------*/


    public function showdata($id)
    {
        $this->clearVals();
        try {

            $d = ItemDisposal::where('id', $id)->first();
            $this->rdf_number = $d->rdf_number;
            $this->date = $d->date;

            $this->reason = $d->reason;

            $this->dept = (SubDepartment::where('subdept_code', $d->subdept_code)->first())->description;
            $this->ItemArray = ItemDisposal::find($id)->item;

            $this->dispatchBrowserEvent('changeURL', [
                'entURL' =>  $d->rdf_number,
            ]);

            if (!empty($d->from)) {
                $u = User::where('school_id', $d->from)->first();
                $this->from = $u->first_name . ' ' . $u->last_name;
            }

            if (!empty($d->endorsedto)) {
                $u = User::where('school_id', $d->endorsedto)->first();
                $this->endorsedto = $u->first_name . ' ' . $u->last_name . ' / ' . $d->endorsed_date;
            }

            if (!empty($d->checkedby)) {
                $u = User::where('school_id', $d->checkedby)->first();
                $this->checkedby = $u->first_name . ' ' . $u->last_name . ' / ' . $d->checked_date;
            }

            if (!empty($d->approvedby)) {
                $u = User::where('school_id', $d->approvedby)->first();
                $this->approvedby = $u->first_name . ' ' . $u->last_name . ' / ' . $d->approved_date;
            }


            if (!empty($d->evaluatedby)) {
                $u = User::where('school_id', $d->evaluatedby)->first();
                $this->evaluatedby = $u->first_name . ' ' . $u->last_name . ' / ' . $d->evaluated_date;
            }

            if (!empty($d->notedby)) {
                $u = User::where('school_id', $d->notedby)->first();
                $this->notedby = $u->first_name . ' ' . $u->last_name . ' / ' . $d->noted_date;
            }

            if (!empty($d->postedby)) {
                $u = User::where('school_id', $d->postedby)->first();
                $this->postedby = $u->first_name . ' ' . $u->last_name;
                $this->posted_date = $d->posted_date;
            }
        } catch (Exception $e) {
            //
        }
    }

    /*-----------------------------------------------------------
    CLEAR VALUES
    -----------------------------------------------------------*/
    public function clearVals()
    {
        $this->from = null;
        $this->date = null;
        $this->dept = null;
        $this->rdf_number = null;

        $this->ItemArray = null;
    }



    /*-----------------------------------------------------------
    RENDER
    -----------------------------------------------------------*/

    public function render()
    {
        if (!empty($this->rdf_number)) {
            $this->dispatchBrowserEvent('sample', [
                'rowindex' => $this->rdf_number
            ]);
        }

        $rdf = ItemDisposal::where('rdf_number', 'like', '%' . $this->search . '%')->latest()->get();
        $rdf_cus = ItemDisposal::where('from', Auth::user()->school_id)->where('rdf_number', 'like', '%' . $this->search . '%')->latest()->get();
        return view('livewire.custodian.itemd-status', [
            'rdf' => $rdf,
            'rdf_cus' => $rdf_cus,
        ]);
    }
}
