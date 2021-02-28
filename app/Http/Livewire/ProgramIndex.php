<?php

namespace App\Http\Livewire;

use App\Models\Program;
use App\Models\GetApiController;
use Livewire\Component;
use Livewire\WithPagination;

class ProgramIndex extends Component
{
    use WithPagination;

    public $search;

    protected $updatesQueryString = ['search'];

    public function render()
    {
        $programs = $this->search === null ? Program::paginate(15) : Program::where('program_nama', 'like', '%'.$this->search.'%')->paginate(15);

        $api = GetApiController::get_api('program', '$2y$10$RIHIF8XQLBK4kK6VNnCTueEnb8mTdnadpIFQ9fjO3nsa5xLa2fRlK');

        return view('livewire.program-index', [
            'programs' => $programs,
            'api' => $api
        ]);
    }
}
