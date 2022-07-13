<?php

namespace App\Http\Livewire\Records;

use App\Models\Department as ModelsDepartment;
use Livewire\Component;
use Livewire\WithPagination;
use Exception;

class Department extends Component
{
    use WithPagination;
    public $updateID, $dept_code, $description, $fund_code;
    public $filterby = "dept_code", $search, $entries = 40;


    /*-------------------------------------------------------------
    ///////Create new SUpplier
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
        $this->dispatchBrowserEvent('showDepartment');
    }


    /**
     * Save new data
     *
     * @return void
     */
    public function saveSupplier()
    {
        $this->validate();
        try {
            ModelsDepartment::create($this->saveData());
            $this->closeModal();

            //highlight new Added Data
            $this->dispatchBrowserEvent('val', [
                'rowindex' => 0,
            ]);

            //Popup message for saved
            $this->dispatchBrowserEvent('swal_mode', [
                'text' => 'Created Successfully!',
                'type' => 'success',
                'w' => 250,
                'timer' => 2000,
            ]);
        } catch (Exception $e) {

            //Popup message for error
            $this->dispatchBrowserEvent('swal_mode', [
                'text' => 'Something went wrong. Please try again later.',
                'type' => 'error',
                'w' => 400,
                'timer' => 4000,
            ]);
        }
    }






    /**
     * Set each field to
     * each column in database
     *
     * @return void
     */
    public function saveData()
    {
        return [
            'dept_code' => $this->dept_code,
            'description' => $this->description,
            'fund_code' => $this->fund_code,
        ];
    }


    /**
     * Rules / Validation 
     * of forms
     *
     * @return void
     */
    public function rules()
    {
        return [
            'dept_code' => 'required',
            'description' => 'required',
            'fund_code' => 'required',
        ];
    }


    /*-------------------------------------------------------------
    ///////UPDATE SUPPLIER
    ----------------------------------------------------------------*/

    public function updateSupplier()
    {
        $this->validate();
        try {
            ModelsDepartment::where('id', $this->updateID)->update($this->saveData());
            $this->closeModal();

            //highlight new Updated Data
            $this->dispatchBrowserEvent('val', [
                'rowindex' => $this->rowindex,
            ]);

            //Popup message for saved
            $this->dispatchBrowserEvent('swal_mode', [
                'text' => 'Updated Successfully!',
                'type' => 'success',
                'w' => 250,
                'timer' => 2000,
            ]);
        } catch (Exception $e) {

            //Popup message for error
            $this->dispatchBrowserEvent('swal_mode', [
                'text' => 'Something went wrong. Please try again later.',
                'type' => 'error',
                'w' => 400,
                'timer' => 4000,
            ]);
        }
    }




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
            $this->dispatchBrowserEvent('showDepartment');

            $this->dispatchBrowserEvent('val', [
                'rowindex' => intval($i),
            ]);
        }
    }



    public function showData($id)
    {
        try {
            $data = ModelsDepartment::where('id', $id)->first();
            if (!empty($data)) {
                $this->dept_code = $data->dept_code;
                $this->description = $data->description;
                $this->fund_code = $data->fund_code;
                $this->updateID = $data->id;
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
        $this->dispatchBrowserEvent('hideDepartment');
    }


    /*-------------------------------------------------------------
    ///////Clear
    ----------------------------------------------------------------*/

    public function clearForm()
    {
        $this->dept_code = null;
        $this->description = null;
        $this->fund_code = null;
        $this->updateID = null;
    }


    /*-------------------------------------------------------------
    ///////Render
    ----------------------------------------------------------------*/

    public function render()
    {
        if (!empty($this->search)) {
            $dept = ModelsDepartment::where($this->filterby, 'like', '%' . $this->search . '%')->orderby('dept_code')->paginate($this->entries);
        } else {
            $dept = ModelsDepartment::orderby('dept_code')->paginate(30);
        }
        return view('livewire.records.department', [
            'dept' => $dept,
        ]);
    }
}
