<?php

namespace App\Http\Livewire\Records;

use App\Models\SubDepartment as ModelsSubDepartment;
use Livewire\Component;
use Livewire\WithPagination;
use Exception;
use Illuminate\Database\Eloquent\Model;

class SubDepartment extends Component
{
    use WithPagination;
    public $updateID, $dept_code, $description, $subdept_code;
    public $filterby = "subdept_code", $search, $rowindex;
    public  $prevCode, $entries = 40;



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
        $this->dispatchBrowserEvent('showSubDepartment');
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
            ModelsSubDepartment::create($this->saveData());
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
            'subdept_code' => $this->subdept_code,
            'dept_code' => $this->dept_code,
            'description' => $this->description,
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
            'subdept_code' => 'required',
            'dept_code' => 'required',
            'description' => 'required',
        ];
    }


    /*-------------------------------------------------------------
    ///////UPDATE SUPPLIER
    ----------------------------------------------------------------*/

    public function updateSupplier()
    {
        $this->validate();
        try {
            ModelsSubDepartment::where('id', $this->updateID)->update($this->saveData());

            //find new index
            /*    if ($this->prevCode != $this->subdept_code) {
                if (!empty($this->search)) {
                    $subdept = ModelsSubDepartment::where($this->filterby, 'like', '%' . $this->search . '%')->orderby('subdept_code')->paginate(30);
                } else {
                    $subdept = ModelsSubDepartment::orderby('subdept_code')->paginate(30);
                }

                $key = array_search($this->subdept_code, array_column($subdept, 'subdept_code'));
                $this->rowindex = $key;
            }
            */


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
            $this->dispatchBrowserEvent('showSubDepartment');

            $this->dispatchBrowserEvent('val', [
                'rowindex' => intval($i),
            ]);
        }
    }



    public function showData($id)
    {
        try {
            $data = ModelsSubDepartment::where('id', $id)->first();
            if (!empty($data)) {
                $this->subdept_code = $data->subdept_code;
                $this->dept_code = $data->dept_code;
                $this->description = $data->description;
                $this->updateID = $data->id;
                $this->prevCode = $data->subdept_code;
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
        $this->dispatchBrowserEvent('hideSubDepartment');
    }

    /*-------------------------------------------------------------
    ///////Clear
    ----------------------------------------------------------------*/

    public function clearForm()
    {
        $this->subdept_code = null;
        $this->dept_code = null;
        $this->description = null;
        $this->updateID = null;
        $this->rowindex;
    }


    /*-------------------------------------------------------------
    ///////Render
    ----------------------------------------------------------------*/



    public function render()
    {
        $subdept = ModelsSubDepartment::where($this->filterby, 'like', '%' . $this->search . '%')->orderby('subdept_code')->paginate($this->entries);
        return view('livewire.records.sub-department', [
            'subdept' => $subdept,
        ]);
    }
}
