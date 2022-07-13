<?php

namespace App\Http\Livewire\Profile;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithFileUploads;

class Changesig extends Component
{
    use WithFileUploads;
    public $esig, $val, $new, $tem;


    public function save()
    {
        try {
            $this->validate();

            User::where('id', Auth::user()->id)->update([
                'signature_path' => $this->val->hashName()
            ]);

            $this->val->store('public/esigs');
            $this->cancel();

            $this->dispatchBrowserEvent('swal_mode', [
                'text' => 'Saved.',
                'type' => 'success',
                'w' => 200,
                'timer' => 2000,
            ]);
            return redirect('/user/profile');
            //
        } catch (Exception $e) {
            $this->dispatchBrowserEvent('swal_mode', [
                'text' => 'Something went wrong. Please try again later.',
                'type' => 'warning',
                'w' => 400,
                'timer' => 4000,
            ]);
        }
    }


    public function rules()
    {
        return [
            'val' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048'
        ];
    }

    public function cancel()
    {
        $this->esig = null;
        $this->val = null;
    }



    public function changes()
    {
        $this->esig = "yes";
    }


    public function render()
    {
        return view('livewire.profile.changesig');
    }
}
