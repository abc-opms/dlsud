<?php

namespace App\Http\Livewire\Records;

use App\Models\Supplier as mSupplier;
use Exception;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Supplier extends Component
{
    use WithPagination;
    public $filter, $filtercaption, $row;

    public $name, $address, $telnum, $telnum2, $faxnum, $faxnum2, $scategory, $supplier_code;
    public $updateID, $supplierModal, $rowindex;
    public $search, $filterby = 'name';




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
        $this->dispatchBrowserEvent('showSupplier');
    }


    /**
     * Save new data
     *
     * @return void
     */
    public function saveSupplier()
    {
        $this->generateSupplierCode();
        $this->validate();
        try {
            mSupplier::create($this->saveData());
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
     * GENERATE NEW SUPPLIER ID
     *
     * @return void
     */
    public function generateSupplierCode()
    {
        $val = date("Y");

        $num = mSupplier::count();

        if ($num == 0 || $num == null) {
            $ssid = 1;
        } else {
            $ssid = $num + 1;
        }

        $count = strlen($ssid);

        if ($count == "1")
            $val .= "000";
        if ($count == "2")
            $val .= "00";
        if ($count == "3")
            $val .= "0";

        $val .= $ssid;
        $this->supplier_code = "$val";
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
            'supplier_code' => $this->supplier_code,
            'name' => $this->name,
            'address' => $this->address,
            'telnum' => $this->telnum,
            'faxnum' => $this->faxnum,
            'telnum_al' => $this->telnum2,
            'faxnum_al' => $this->faxnum2,
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
            'name' => 'required',
            'address' => 'required',
            'telnum' => 'required',
            'faxnum' => 'required',
            'telnum2' => '',
            'faxnum2' => '',
        ];
    }


    /*-------------------------------------------------------------
    ///////UPDATE SUPPLIER
    ----------------------------------------------------------------*/

    public function updateSupplier()
    {
        $this->validate();
        try {
            mSupplier::where('id', $this->updateID)->update($this->saveData());
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
            $this->dispatchBrowserEvent('showSupplier');

            $this->dispatchBrowserEvent('val', [
                'rowindex' => intval($i),
            ]);
        }
    }


    public function showData($id)
    {
        try {
            $data = mSupplier::where('id', $id)->first();
            if (!empty($data)) {
                $this->name = $data->name;
                $this->address =  $data->address;
                $this->telnum =  $data->telnum;
                $this->faxnum =  $data->faxnum;
                $this->telnum2 =  $data->telnum_al;
                $this->faxnum2 =  $data->faxnum_al;
                $this->updateID = $id;
                $this->supplier_code = $data->supplier_code;
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
        $this->dispatchBrowserEvent('hideSupplier');
    }


    /*-------------------------------------------------------------
    ///////Clear
    ----------------------------------------------------------------*/

    public function clearForm()
    {
        $this->name = null;
        $this->address = null;
        $this->telnum =  null;
        $this->faxnum = null;
        $this->telnum2 =  null;
        $this->faxnum2 = null;
        $this->updateID = null;
        $this->supplier_code = null;
        $this->updateID = null;
    }


    /*-------------------------------------------------------------
    ///////Render
    ----------------------------------------------------------------*/

    public function render()
    {
        $sup = mSupplier::where($this->filterby, 'like', '%' . $this->search . '%')->latest()->paginate(10);
        return view('livewire.records.supplier', [
            'suppliers' => $sup,
        ]);
    }


    //End
}
