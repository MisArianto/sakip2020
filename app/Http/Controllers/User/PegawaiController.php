<?php

namespace App\Http\Controllers\User;

use PDF;
use Auth;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PegawaiController extends Controller
{

    public function index()
    {
        return view('app.user.pegawai.index');
    }

    public function fetch()
    {
        // if(Auth::user()->organisasi_no == '2.01.06.01.')
        // {
        //     $pegawais = Pegawai::where('organisasi_nama', 'like', '%' . 'PERINDUSTRIAN' . '%')
        //                 ->select(
        //                         'pegawai.nama',
        //                         'pegawai.nip',
        //                         'pegawai.jabatan',
        //                         'pegawai.pangkat'
        //                     )
        //                 ->get();

        // }elseif(Auth::user()->organisasi_no == '3.01.03.02.')
        // {
        //     $pegawais = Pegawai::where('organisasi_nama', 'like', '%' . 'PAJAK' . '%')
        //                 ->select(
        //                         'pegawai.nama',
        //                         'pegawai.nip',
        //                         'pegawai.jabatan',
        //                         'pegawai.pangkat'
        //                     )
        //                 ->get();

        // }elseif(Auth::user()->organisasi_no == '1.02.07.01.')
        // {
        //     $pegawais = Pegawai::where('organisasi_nama', 'like', '%' . 'DESA' . '%')
        //                 ->select(
        //                         'pegawai.nama',
        //                         'pegawai.nip',
        //                         'pegawai.jabatan',
        //                         'pegawai.pangkat'
        //                     )
        //                 ->get();

        // }elseif(Auth::user()->organisasi_no == '2.01.02.01.')
        // {
        //         $pegawais = Pegawai::where('organisasi_nama', 'like', '%' . 'OLAHRAGA' . '%')
        //                     ->select(
        //                         'pegawai.nama',
        //                         'pegawai.nip',
        //                         'pegawai.jabatan',
        //                         'pegawai.pangkat'
        //                     )
        //                     ->get();

        // }elseif(Auth::user()->organisasi_no == '6.01.01.01.')
        // {
        //         $pegawais = Pegawai::where('organisasi_nama', 'like', '%'.'KECAMATAN TEBING TINGGI'.'%')
        //                     ->select(
        //                         'pegawai.nama',
        //                         'pegawai.nip',
        //                         'pegawai.jabatan',
        //                         'pegawai.pangkat'
        //                     )
        //                     ->get();

        // }elseif(Auth::user()->organisasi_no == '6.01.01.08.')
        // {
        //         $pegawais = Pegawai::where('organisasi_nama', 'like', 'KECAMATAN TASIK PUTRI PUYU')
        //                     ->select(
        //                         'pegawai.nama',
        //                         'pegawai.nip',
        //                         'pegawai.jabatan',
        //                         'pegawai.pangkat'
        //                     )
        //                     ->get();

        // }else{
        //     $pegawais = Pegawai::leftJoin('organisasi as o', 'o.organisasi_nama', 'pegawai.organisasi_nama')
        //             ->select(
        //                 'pegawai.nama',
        //                 'pegawai.nip',
        //                 'pegawai.jabatan',
        //                 'pegawai.pangkat'
        //             )
        //             ->where('o.organisasi_no', Auth::user()->organisasi_no)
        //             ->where('o.organisasi_jenis', 'ORG')
        //             ->get();
        // }

        $pegawais = Pegawai::select(
                        'id',
                        'nama',
                        'nip',
                        'jabatan',
                        'pangkat'
                    )
                    ->where('organisasi_no', Auth::user()->organisasi_no)
                    ->get();


        return response()->json([
            'pegawais' => $pegawais
        ]);
    }

    public function search($nip)
    {
        $pegawais = Pegawai::where('nip', $nip)->get();

        $output = '';

        foreach ($pegawais as $value) {
        $output = '
            <tr>
                <td>'.$value->nip.'</td>
                <td>'.$value->nama.'</td>
                <td>'.$value->jabatan.'</td>
                <td>
                    <div class="btn-group">
                        <button class="btn btn-success btn-sm" id="handleSimpan" data-id="'.$value->id.'">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </td>
            </tr>
        ';
        }

        return response()->json([
            'output' => $output
        ],200);
    }


    public function simpan($id)
    {

        $pegawai = Pegawai::findOrFail($id);

        // jika organisasi_no di pegawai null maka update organisasi_no menjadi organisasi_no dinas tersebut
        if($pegawai->organisasi_no == '')
        {
            $pegawai->update([
                'organisasi_no' => Auth::user()->organisasi_no
            ]);

        }else{

            // jika tidak null maka tambah dengan data nama yang sama dengan organisasi_no yang terbeda
            Pegawai::create([
                'id_api' => $pegawai->id_api,
                'nip' => $pegawai->nip,
                'golongan' => $pegawai->golongan,
                'pangkat' => $pegawai->pangkat,
                'nama' => $pegawai->nama,
                'jabatan' => $pegawai->jabatan,
                'organisasi_nama' => $pegawai->organisasi_nama,
                'organisasi_no' => Auth::user()->organisasi_no
            ]);

        }

    }

    public function cetak_pk_pdf($id)
    {
        $model = Pegawai::findOrFail($id);

        return view('app.user.pegawai.cetak_pk_pdf', compact('model'));


        // $pdf = PDF::loadView('app.user.cetak.cetak_pk_pdf', $model);
        // return $pdf->download('Perjanjian Kinerja '.get_name_opd(Auth::user()->organisasi_no).'.pdf');

    }


    public function delete($id)
    {
    	$pegawai = Pegawai::findOrFail($id);
    	$pegawai->update([
            'organisasi_no' => ''
        ]);
    }

}
