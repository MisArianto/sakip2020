<?php

namespace App\Http\Livewire;

use App\Models\Organisasi;
use App\Models\GetApiController;
use Livewire\Component;
use Livewire\WithPagination;

class OrganisasiIndex extends Component
{
    use WithPagination;

    public $search;
    protected $updatesQueryString = ['search'];

    public function render()
    {
        $api = GetApiController::get_api('organisasi', '$2y$10$RIHIF8XQLBK4kK6VNnCTueEnb8mTdnadpIFQ9fjO3nsa5xLa2fRlK');
        $orgs = $this->search === null ? Organisasi::where('organisasi_jenis', 'ORG')->paginate(15) : Organisasi::where('organisasi_jenis', 'ORG')->where('organisasi_nama', 'like', '%'.$this->search.'%')->paginate(15);
        return view('livewire.organisasi-index', [
            'orgs' => $orgs,
            'api' => $api
        ]);
    }
}
