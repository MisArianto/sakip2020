<?php

namespace App\Http\Controllers\User;

use DB;
use Auth;
use Alert;
use App\Models\Organisasi;
use App\Models\lhe;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LheController extends Controller
{
    public function index()
    {
        return view('app.user.lhe.index');
    }

    public function fetch(Request $request)
    {
        return $this->fetch_emit($request->organisasi_no, $request->tahun);
    }


    public function fetch_emit($organisasi_no, $tahun)
    {

        $lhes = Lhe::leftJoin('organisasi as o', 'o.organisasi_no', 'lhe.organisasi_no')
                        ->select(
                            'lhe.*',
                            'o.organisasi_nama'
                        )
                        ->where('lhe.organisasi_no', $organisasi_no)
                        ->where('lhe.tahun', $tahun)
                        ->latest()
                        ->get();

        $output = '';
        foreach ($lhes as $value) {
           $output .= '
                <tr>
                    <td align="center">
                        <button class="btn btn-info btn-sm" id="handleEditLhe" data-id="'.$value->id.'" data-nilai="'.$value->nilai.'">
                            <i class="fa fa-edit"></i>
                        </button>  
                    </td>
                    <td>'.$value->organisasi_nama.'</td>
                    <td>';
                        if (substr($value->nilai, 0,2)>=90){
                            $output .= 'AA';
                        }else if (substr($value->nilai, 0,2)>=80 and substr($value->nilai, 0,2)<90) {
                            $output .= 'A';
                        }else if (substr($value->nilai, 0,2)>=70 and substr($value->nilai, 0,2)<80) {
                            $output .= 'BB';
                        }else if (substr($value->nilai, 0,2)>=60 and substr($value->nilai, 0,2)<70) {
                            $output .= 'B';
                        }else if (substr($value->nilai, 0,2)>=50 and substr($value->nilai, 0,2)<60) {
                            $output .= 'CC';
                        }else if (substr($value->nilai, 0,2)>=40 and substr($value->nilai, 0,2)<50) {
                            $output .= 'C';
                        }else if (substr($value->nilai, 0,2)>=00 and substr($value->nilai, 0,2)<40) {
                            $output .= 'D';
                        }

                    $output .= '</td>
                    <td>'.$value->nilai.'</td>
                    <td>'.$value->tahun.'</td>
                    <td>';
                        if (substr($value->nilai, 0,2)>=90){
                            $output .= 'Sangat Memuaskan';
                        }else if (substr($value->nilai, 0,2)>=80 and substr($value->nilai, 0,2)<90) {
                            $output .= 'Memuaskan';
                        }else if (substr($value->nilai, 0,2)>=70 and substr($value->nilai, 0,2)<80) {
                            $output .= 'Sangat Baik';
                        }else if (substr($value->nilai, 0,2)>=60 and substr($value->nilai, 0,2)<70) {
                            $output .= 'Baik';
                        }else if (substr($value->nilai, 0,2)>=50 and substr($value->nilai, 0,2)<60) {
                            $output .= 'Cukup';
                        }else if (substr($value->nilai, 0,2)>=40 and substr($value->nilai, 0,2)<50) {
                            $output .= 'Kurang';
                        }else if (substr($value->nilai, 0,2)>=00 and substr($value->nilai, 0,2)<40) {
                            $output .= 'Sangat Kurang';
                        }

                    $output .= '</td>
                </tr>
           ';
        }

        return $output;

    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nilai' => 'required',
        ]);

        $lhe = Lhe::findOrFail($id);

        $lhe->update([
            'nilai' => $request->nilai
        ]);

        return $this->fetch_emit(Auth::user()->organisasi_no, $request->tahun_emit);

    }


}
