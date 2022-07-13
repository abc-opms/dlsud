<?php

namespace App\Http\Livewire\Property;

use App\Models\Signupkey;
use Livewire\Component;

class QrFea extends Component
{
    public $qrval;





    public function render()
    {
        $user = Signupkey::all();
        return view('livewire.property.qr-fea', [
            'user' => $user
        ]);
    }
}
