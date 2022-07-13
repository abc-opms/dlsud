<?php

namespace App\Http\Livewire\Custodian;

use App\Models\FurnitureItem;
use App\Models\RoleUser;
use App\Models\SubDepartment;
use App\Models\TransferFurniture;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class RtfReceived extends Component
{
    public $search, $rtf_number, $date, $ItemArray = array(),  $reason;
    public $checkedby, $approvedby, $postedby, $posted_date, $custodian, $receiving_dept, $dept_head;


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
            $c = TransferFurniture::where('rtf_number', $id)->first();
            if (!empty($c->rtf_number)) {
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
            $c = TransferFurniture::where('custodian', Auth::user()->school_id)->where('rtf_number', $id)->first();
            if (!empty($c->rtf_number)) {
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

            $d = TransferFurniture::where('id', $id)->first();
            $this->rtf_number = $d->rtf_number;
            $this->date = $d->date;
            $this->reason = $d->reason;

            $this->dept = (SubDepartment::where('subdept_code', $d->subdept_code)->first())->description;
            $this->ItemArray = TransferFurniture::find($id)->item;

            $this->dispatchBrowserEvent('changeURL', [
                'entURL' =>  $d->rtf_number,
            ]);


            if (!empty($d->approvedby)) {
                $u = User::where('school_id', $d->approvedby)->first();
                $this->aby = $u->first_name . ' ' . $u->last_name . ' / ' . $d->checked_date;
            }

            if (!empty($d->from)) {
                $u = User::where('school_id', $d->from)->first();
                $this->from = $u->first_name . ' ' . $u->last_name;
            }

            if (!empty($d->dept_head)) {
                $u = User::where('school_id', $d->dept_head)->first();
                $this->dept_head = $u->first_name . ' ' . $u->last_name;
            }

            if (!empty($d->custodian)) {
                $u = User::where('school_id', $d->custodian)->first();
                $this->custodian = $u->first_name . ' ' . $u->last_name;
            }

            if (!empty($d->checkedby)) {
                $u = User::where('school_id', $d->checkedby)->first();
                $this->checkedby = $u->first_name . ' ' . $u->last_name . ' / ' . $d->checked_date;
            }


            if (!empty($d->postedby)) {
                $u = User::where('school_id', $d->postedby)->first();
                $this->postedby = $u->first_name . ' ' . $u->last_name;
                $this->posted_date = $d->posted_date;
            }

            if (!empty($d->receiving_dept)) {
                $s = SubDepartment::where('subdept_code', $d->receiving_dept)->first();
                $this->receiving_dept = $s->description;
            }
        } catch (Exception $e) {
            $this->clearVals();
            $this->dispatchBrowserEvent('swal_mode', [
                'text' => 'Something went wrong. Please try again later.',
                'type' => 'error',
                'w' => 300,
                'timer' => 2000,
            ]);
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
        $this->rtf_number = null;
        $this->reason = null;
        $this->ItemArray = null;
        $this->rd = null;
        $this->dept_head = null;
        $this->custodian = null;
        $this->checkedby = null;
        $this->approvedby = null;
        $this->postedby = null;
        $this->posted_date = null;
    }



    /*-----------------------------------------------------------
    ON PAGE LOAD
    -----------------------------------------------------------*/

    public function render()
    {
        if (!empty($this->rtf_number)) {
            $this->dispatchBrowserEvent('sample', [
                'rowindex' => $this->rtf_number
            ]);
        }

        $rtf = array();
        $rtf_cus = TransferFurniture::where('custodian', Auth::user()->school_id)
            ->where('rtf_number', 'like', '%' . $this->search . '%')
            ->latest()->get();
        return view('livewire.custodian.rtf-status', [
            'rtf' => $rtf,
            'rtf_cus' => $rtf_cus,
        ]);
    }
}
