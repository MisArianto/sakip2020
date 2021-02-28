<?php

namespace App\Http\Livewire;

use App\Models\Kegiatan;
use App\Models\GetApiController;
use Livewire\Component;
use Livewire\WithPagination;

class KegiatanIndex extends Component
{
    use WithPagination;

    public $search;

    protected $updatesQueryString = ['search'];

    public function render()
    {
        $kegiatans = $this->search === null ? Kegiatan::paginate(15) : Kegiatan::where('kegiatan_nama', 'like', '%'.$this->search.'%')->paginate(15);

        $api = GetApiController::get_api('kegiatan', '$2y$10$RIHIF8XQLBK4kK6VNnCTueEnb8mTdnadpIFQ9fjO3nsa5xLa2fRlK');

        return view('livewire.kegiatan-index', [
            'kegiatans' => $kegiatans,
            'api' => $api
        ]);
    }
}
