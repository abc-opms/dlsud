<?php

namespace App\Http\Livewire\Profile;

use App\Models\Department;
use App\Models\SubDepartment;
use Exception;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Overview extends Component
{
    public function render()
    {
        $user =  Auth::user();
        try {
            $dept = (Department::where('dept_code', $user->dept_code)->first())->description;
            $subdept = (SubDepartment::where('subdept_code', $user->subdept_code)->first())->description;
        } catch (Exception $e) {
            $dept = "";
            $subdept = "";
        }
        return view('livewire.profile.overview', [
            'user' => $user,
            'dept' => $dept,
            'subdept' => $subdept
        ]);
    }
}
