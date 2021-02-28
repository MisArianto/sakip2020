<?php

namespace App\Http\Livewire;

use App\Models\Satuan;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\GetApiController;

class SatuanIndex extends Component
{
    use WithPagination;

    public $search;

    protected $updatesQueryString = ['search'];

    public function render()
    {
        $satuans = $this->search === null ? Satuan::paginate(15) : Satuan::where('satuan_nama', 'like', '%'.$this->search.'%')->paginate(15);

        $api = GetApiController::get_api('satuan', '$2y$10$RIHIF8XQLBK4kK6VNnCTueEnb8mTdnadpIFQ9fjO3nsa5xLa2fRlK');

        return view('livewire.satuan-index', [
            'satuans' => $satuans,
            'api' => $api
        ]);
    }
}
