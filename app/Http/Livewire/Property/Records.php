<?php

namespace App\Http\Livewire\Property;

use Livewire\Component;

class Records extends Component
{
    public $filterCategory, $filter = "1";
    public $key = "Supplier";


    /**
     * On page reload function
     *
     * @param  mixed $id
     * @return void
     */
    public function mount($id)
    {
        $this->filterCategory = $id;
        switch ($id) {
            case "Supplier":
            case "User":
            case "Department":
            case "Sub-Department":
            case "Signupkey":
            case "Rr-Items":
            case "Acc-Code":
                $this->filter = $id;
                break;
            case "logs":
                $this->filter = "";
                break;
            default:
                return abort(404);
                break;
        }
    }



    /**
     * When dropwdown change
     *
     * @return void
     */
    public function updatedfilterCategory()
    {
        $this->filter = $this->filterCategory;

        $this->dispatchBrowserEvent('changeURL', [
            'entURL' => "$this->filterCategory"
        ]);
    }

    public function render()
    {
        return view('livewire.property.records', [
            'filter' => $this->filter,
        ]);
    }
}
