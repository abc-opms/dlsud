<?php

namespace App\Http\Livewire;

use App\Events\NotificationEvent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Livewire\Component;

class Sample extends Component
{
    public $here;

    public function try()
    {
        $this->unread_count = Auth::user()->unreadNotifications->count() + 1;
        $this->content = Auth::user()->unreadNotifications;
    }

    public function render()
    {
        return view('livewire.sample');
    }
}
