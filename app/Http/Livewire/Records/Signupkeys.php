<?php

namespace App\Http\Livewire\Records;

use App\Mail\SignupkeyEmailNotification;
use App\Models\Department;
use App\Models\Signupkey;
use App\Models\SubDepartment;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;


class Signupkeys extends Component
{
    use WithPagination;
    public $filter, $filtercaption, $row;

    public $school_id, $email, $role, $dept_code, $subdept_code, $skey;
    public $updateID, $supplierModal, $rowindex;
    public $search, $filterby = 'dept_code', $entries = 15;



    /*-------------------------------------------------------------
    ///////UPDATE
    ----------------------------------------------------------------*/

    public function updateSkey()
    {
        if ($this->validate()) {
            //
            Signupkey::where('id', $this->updateID)->update($this->saveupdateData());
            $this->closeModal();
        }
    }



    /**
     * Assigning data to attributes
     *
     * @return void
     */
    public function saveupdateData()
    {
        return [
            'school_id' => $this->school_id,
            'role' => $this->role,
            'dept_code' => $this->dept_code,
            'subdept_code' => $this->subdept_code,
            'email' => $this->email,
            'skey' => $this->skey,
        ];
    }


    /*-------------------------------------------------------------
    ///////SHOW
    ----------------------------------------------------------------*/


    public function show($id)
    {
        $this->clearForm();

        try {
            $this->updateID = $id;

            $this->dispatchBrowserEvent('showSkey');

            $d = Signupkey::where('id', $id)->first();

            $this->school_id = $d->school_id;
            $this->email = $d->email;
            $this->role = $d->role;
            $this->dept_code = $d->dept_code;
            $this->subdept_code = $d->subdept_code;
            $this->skey = $d->skey;
        } catch (Exception $e) {
            //
        }
    }

    /*-------------------------------------------------------------
    ///////SAVE DATA
    ----------------------------------------------------------------*/


    public function saveSkey()
    {
        if ($this->validate()) {
            if (Signupkey::create($this->saveData())) {
                $this->sendEmail();
                $this->closeModal();
            }
        }
    }

    /**
     * Assigning data to attributes
     *
     * @return void
     */
    public function saveData()
    {
        $this->skey = substr($this->role, 0, 1) . Str::random(9);
        return [
            'school_id' => $this->school_id,
            'role' => $this->role,
            'dept_code' => $this->dept_code,
            'subdept_code' => $this->subdept_code,
            'skey' => $this->skey,
            'email' => $this->email,
            'status' => 'Pending',
        ];
    }



    public function sendEmail()
    {
        $skey = $this->skey;
        $email = $this->email;
        $role = $this->role;

        //Finance
        Mail::to($this->email)->queue(new SignupkeyEmailNotification($skey, $email, $role));
    }

    /*-------------------------------------------------------------
    ///////RUles
    ----------------------------------------------------------------*/

    public function rules()
    {
        return [
            'school_id' => ['required', Rule::unique('signupkeys', 'school_id')->ignore($this->updateID)],
            'email' => ['required', 'email', Rule::unique('signupkeys', 'email')->ignore($this->updateID)],
            'role' => 'required',
            'dept_code' => 'required',
            'subdept_code' => 'required',
        ];
    }

    /*---------------------------------------------------------
    ///////Create new OPEN MODal
    ----------------------------------------------------------------*/
    /**
     * Clear the form and
     * show the modal form
     *
     * @return void
     */
    public function createnew()
    {
        $this->clearForm();
        $this->dispatchBrowserEvent('showSkey');
    }


    public function closeModal()
    {
        $this->clearForm();
        $this->dispatchBrowserEvent('hideSkey');
    }

    /*-------------------------------------------------------------
    ///////CLEAR FORM
    ----------------------------------------------------------------*/

    public function clearForm()
    {
        $this->school_id = null;
        $this->email = null;
        $this->skey = null;
        $this->dept_code = null;
        $this->subdept_code = null;
        $this->role = null;
        $this->updateID = null;
        $this->resetValidation();
    }

    /*-------------------------------------------------------------
    ///////RENDER
    ----------------------------------------------------------------*/
    public function render()
    {
        $signupkeys = Signupkey::where($this->filterby, 'like', '%' . $this->search . '%')->latest()->paginate($this->entries);

        $sub = SubDepartment::where('dept_code', 'like', '%' . $this->dept_code . '%')->orderBy('description')->get();

        $deptval = Department::orderBy('description')->get();
        return view('livewire.records.signupkeys', [
            'signupkeys' => $signupkeys,
            'deptval' => $deptval,
            'subdeptval' => $sub
        ]);
    }
}
