<?php

namespace App\Http\Livewire\Property;

use App\Models\Department;
use App\Models\Inventory;
use App\Models\InventoryItems;
use App\Models\SerialPropertyCode;
use App\Models\SubDepartment;
use Exception;
use Livewire\Component;
use Livewire\WithPagination;
use Nette\Schema\Expect;

class InvCreate extends Component
{
    use WithPagination;
    public $view, $deptlist = array(), $d_values;
    public  $inv_number;



    public function clear()
    {
        $this->clearVars();
        return redirect('/inventories/monitor/logs');
    }

    public function clearVars()
    {
        $this->d_values = null;
        $this->deptlist = array();
        $this->inv_number = null;
    }


    /* -------------------------------------------------------------
    ADD TO LIST
    -------------------------------------------------------------*/
    public function add()
    {
        if (!empty($this->d_values)) {
            $val = explode(",", $this->d_values);
            $isExist = 0;
            foreach ($this->deptlist as $i) {
                if ($i['subdept_code'] == $val[0]) {
                    $isExist += 1;
                }
            }

            if ($isExist == 0) {
                $this->deptlist[] = array(
                    'subdept_code' => $val[0],
                    'description' => $val[1],
                    'dept_code' => $val[2],
                );
            } else {
                $this->dispatchBrowserEvent('swal_mode', [
                    'text' => 'This is already in the list',
                    'type' => 'warning',
                    'w' => 300,
                    'timer' => 2000,
                ]);
            }
        } else {
            $this->dispatchBrowserEvent('swal_mode', [
                'text' => 'No department selected.',
                'type' => 'warning',
                'w' => 300,
                'timer' => 2000,
            ]);
        }
    }

    /* -------------------------------------------------------------
    DELETE TO LIST
    -------------------------------------------------------------*/
    public function delete($id)
    {
        $this->ds = $id;
        unset($this->deptlist[$id]);
        $this->copy();
    }

    public function copy()
    {
        $array2 = array();

        foreach ($this->deptlist as $i) {
            $array2[] = array(
                'subdept_code' => $i['subdet_code'],
                'description' => $i['description'],
                'dept_code' => $i['dept_code']
            );
        }
        $this->deptlist = array();

        foreach ($array2 as $i) {
            $this->deptlist[] = array(
                'subdept_code' => $i['subdet_code'],
                'description' => $i['description'],
                'dept_code' => $i['dept_code']
            );
        }

        $array2 = array();
    }

    /* -------------------------------------------------------------
    GENERATE INV NUMBER 
    -------------------------------------------------------------*/

    public function checkIfExist()
    {
    }



    /* -------------------------------------------------------------
    GENERATE INV NUMBER 
    -------------------------------------------------------------*/
    public function createinvid()
    {
        $num = InventoryItems::count();

        if ($num == 0 || $num == null) {
            $rrid = 1;
        } else {
            $rrid = $num + 1;
        }

        $count = strlen($rrid);

        if ($count == "1")
            $val = "000";
        if ($count == "2")
            $val = "00";
        if ($count == "3")
            $val = "0";

        $val .= $rrid;
        $this->inv_number = "$val";
    }

    /* -------------------------------------------------------------
    save 
    -------------------------------------------------------------*/

    public function createINV()
    {
        try {
            if (!empty($this->deptlist)) {
                $this->createinvid();
                foreach ($this->deptlist as $d) {
                    $inv = Inventory::create($this->dataINV($d['subdept_code'], $d['dept_code']));
                    $this->invItems($d['subdept_code'], $inv->id);
                    SerialPropertyCode::where('dept_code', $d['dept_code'])
                        ->update($this->updateSerialTable($inv->id));


                    $this->redirectDone();
                    //
                }
            }
        } catch (Exception $e) {
            try {
                Inventory::where('id', $inv->id)->delete();
                InventoryItems::where('inv_number', $this->inv_number)->delete();
            } catch (Exception $e) {
                //
            }

            $this->dispatchBrowserEvent('swal_mode', [
                'text' => 'Something went wrong, please try again later.',
                'type' => 'error',
                'w' => 300,
                'timer' => 2000,
            ]);
        }
    }


    public function dataINV($subd, $dept)
    {
        return [
            'inv_number' => $this->inv_number,
            'subdept_code' => $subd,
            'dept_code' => $dept,
            'number_of_items' => SerialPropertyCode::where('subdept_code', $subd)->count(),
            'status' => 'Active',
        ];
    }


    public function updateSerialTable($id)
    {
        return [
            'item_status' => 'Outdated',
            'inv_number' => $this->inv_number,
            'inv_status' => 'Active'
        ];
    }

    public function invItems($code, $id)
    {
        $serial = SerialPropertyCode::where('subdept_code', $code)
            ->where('item_status', 'Present')
            ->get();
        foreach ($serial as $s) {
            InventoryItems::create([
                'inventory_id' => $id,
                'inv_number' => $this->inv_number,
                'location' => '',
                'name' => $s->name,
                'property_number' => $s->property_code,
                'item_description' => $s->item_description,
                'serial_number'  => $s->serial_number,
                'fea_number' => $s->fea_number,
                'acq_date' => $s->acq_date,
                'qty' => '1',
                'amount' => $s->amount,
                'old_custodian' => $s->old_custodian,
                'new_custodian' => $s->new_custodian,
                'subdept_code' => $s->subdept_code,
                'dept_code' => $s->dept_code,
                'status' => 'Active',
            ]);
        }
    }


    public function redirectDone()
    {
        $this->clearVars();
        $this->dispatchBrowserEvent('swal_mode', [
            'text' => 'Saved',
            'type' => 'success',
            'w' => 300,
            'timer' => 2000,
        ]);
        return redirect('/inventories/monitor/logs');
    }


    public function userSignKey()
    {
        //
    }



    /* -------------------------------------------------------------
    RENDER
    -------------------------------------------------------------*/

    public function render()
    {
        $dept = SubDepartment::distinct('subdept_code')
            ->join('serial_property_codes', 'serial_property_codes.subdept_code', '=', 'sub_departments.subdept_code')
            ->where('serial_property_codes.inv_status', '!=', 'Active')
            ->get('sub_departments.*');



        //return dd($dept);
        return view('livewire.property.inv-create', [
            'dept' => $dept,
        ]);
    }
}
