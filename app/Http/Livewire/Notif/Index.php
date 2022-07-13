<?php

namespace App\Http\Livewire\Notif;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $unread_count, $content = array();

    protected $listeners = ['postAdded' => 'update'];

    public function mount()
    {
        $this->unread_count = Auth::user()->unreadNotifications->count();
        $this->content = Auth::user()->unreadNotifications->paginate(3);
    }


    public function update()
    {
        $this->unread_count = Auth::user()->unreadNotifications->count() + 1;
        $this->content = Auth::user()->unreadNotifications->paginate(3);
    }


    public function render()
    {
        return view('livewire.notif.index');
    }
}
