<?php

namespace App\Http\Livewire;

use App\User;
use Livewire\Component;
use Livewire\WithPagination;

class UserIndex extends Component
{
    use WithPagination;

    public $search;

    protected $updatesQueryString = ['search'];

    public function render()
    {
        // $users = $this->search === null ? User::orderBy('level')->paginate(15) : User::where('username', 'like', '%'.$this->search.'%')->paginate(15);
        return view('livewire.user-index', [
            'users' => $this->search === null ? User::orderBy('level')->paginate(15) : User::where('username', 'like', '%'.$this->search.'%')->paginate(15)
        ]);
    }
}
