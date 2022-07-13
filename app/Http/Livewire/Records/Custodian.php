<?php

namespace App\Http\Livewire\Records;

use App\Models\Role;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Exception;

class Custodian extends Component
{
    use WithPagination;
    public $updateID;
    public $first_name, $last_name, $position, $school_id, $dept_code, $email;
    public $search, $filterby = "dept_code";
    public $entries = 15, $role_type = 'Custodian';




    /*-------------------------------------------------------------
    ///////SHOW MODAL
    ----------------------------------------------------------------*/

    /**
     * Table row click action
     *
     * @param  mixed $id
     * @param  mixed $i
     * @return void
     */
    public function show($id, $i)
    {
        if (!empty($id)) {
            $this->updateID = $id;
            $this->rowindex = $i;
            $this->showData($id);
            $this->dispatchBrowserEvent('showCustodian');

            $this->dispatchBrowserEvent('val', [
                'rowindex' => intval($i),
            ]);
        }
    }


    public function showData($id)
    {
        try {
            $data = User::where('id', $id)->first();
            if (!empty($data)) {
                $this->first_name = $data->first_name;
                $this->last_name =  $data->last_name;
                $this->position =  $data->position;
                $this->email =  $data->email;
                $this->school_id =  $data->school_id;
                $this->dept_code =  $data->dept_code;
                $this->updateID = $id;
            }
        } catch (Exception $e) {
            //code
        }
    }



    /**
     * Close Modal
     *
     * @return void
     */
    public function closeModal()
    {
        $this->clearForm();
        $this->dispatchBrowserEvent('hideCustodian');
    }



    public function clearForm()
    {
        $this->first_name = null;
        $this->last_name =  null;
        $this->position =  null;
        $this->email =  null;
        $this->school_id =  null;
        $this->dept_code =  null;;
        $this->updateID = null;
    }






    public function render()
    {
        if ($this->filterby == "role") {
            $user = User::whereRoleIs($this->role_type)->paginate($this->entries);
        } else {
            $user = User::where($this->filterby, 'like', '%' . $this->search . '%')->paginate($this->entries);
        }

        return view('livewire.records.custodian', [
            'user' => $user,
        ]);
    }
}
