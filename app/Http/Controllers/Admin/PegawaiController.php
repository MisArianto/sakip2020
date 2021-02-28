<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Models\Pegawai;
use App\Models\Organisasi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PegawaiController extends Controller
{

    public function index()
    {
        $organisasis = Organisasi::where('organisasi_jenis', 'ORG')->get();
        return view('app.admin.pegawai.index', compact('organisasis'));
    }

    public function fetch($organisasi_no)
    {
        if($organisasi_no == '2.01.06.01.')
        {
            $pegawais = Pegawai::where('organisasi_nama', 'like', '%' . 'PERINDUSTRIAN' . '%')
                        ->select(
                                'pegawai.nama',
                                'pegawai.nip',
                                'pegawai.jabatan',
                                'pegawai.pangkat'
                            )
                        ->get();

        }elseif($organisasi_no == '3.01.03.02.')
        {
            $pegawais = Pegawai::where('organisasi_nama', 'like', '%' . 'PAJAK' . '%')
                        ->select(
                                'pegawai.nama',
                                'pegawai.nip',
                                'pegawai.jabatan',
                                'pegawai.pangkat'
                            )
                        ->get();

        }elseif($organisasi_no == '1.02.07.01.')
        {
            $pegawais = Pegawai::where('organisasi_nama', 'like', '%' . 'DESA' . '%')
                        ->select(
                                'pegawai.nama',
                                'pegawai.nip',
                                'pegawai.jabatan',
                                'pegawai.pangkat'
                            )
                        ->get();

        }elseif($organisasi_no == '2.01.02.01.')
        {
                $pegawais = Pegawai::where('organisasi_nama', 'like', '%' . 'OLAHRAGA' . '%')
                            ->select(
                                'pegawai.nama',
                                'pegawai.nip',
                                'pegawai.jabatan',
                                'pegawai.pangkat'
                            )
                            ->get();

        }elseif($organisasi_no == '6.01.01.01.')
        {
                $pegawais = Pegawai::where('organisasi_nama', 'like', '%'.'KECAMATAN TEBING TINGGI'.'%')
                            ->select(
                                'pegawai.nama',
                                'pegawai.nip',
                                'pegawai.jabatan',
                                'pegawai.pangkat'
                            )
                            ->get();

        }elseif($organisasi_no == '6.01.01.08.')
        {
                $pegawais = Pegawai::where('organisasi_nama', 'like', 'KECAMATAN TASIK PUTRI PUYU')
                            ->select(
                                'pegawai.nama',
                                'pegawai.nip',
                                'pegawai.jabatan',
                                'pegawai.pangkat'
                            )
                            ->get();

        }else{
            $pegawais = Pegawai::leftJoin('organisasi as o', 'o.organisasi_nama', 'pegawai.organisasi_nama')
                    ->select(
                        'pegawai.nama',
                        'pegawai.nip',
                        'pegawai.jabatan',
                        'pegawai.pangkat'
                    )
                    ->where('o.organisasi_no', $organisasi_no)
                    ->where('o.organisasi_jenis', 'ORG')
                    ->get();
        }


        return response()->json([
            'pegawais' => $pegawais
        ]);
    }

}
