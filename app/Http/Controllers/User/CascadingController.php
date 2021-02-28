<?php

namespace App\Http\Controllers\User;

use Auth;
use Storage;
use App\Models\Organisasi;
use App\Models\Cascading;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CascadingController extends Controller
{
    
    public function index()
    {
        return view('app.user.cascading.index');
    }

    public function fetch(Request $request)
    {
        return $this->fetch_emit($request->organisasi_no, $request->tahun);
    }


    public function fetch_emit($organisasi_no, $tahun)
    {

        $cascadings = Cascading::where('organisasi_no', $organisasi_no)
                        ->where('tahun', $tahun)
                        ->latest()
                        ->get();

        // $output = '';

        // foreach($cascadings as $data){
        //     $output .= '<tr>
        //         <td>'.$data->nama_file.'</td>
        //         <td>'.$data->tahun.'</td>
        //         <td>'.$data->keterangan.'</td>
        //         <td>
        //             <div class="btn-group">
        //                 <button class="btn btn-danger btn-sm" id="handleDelete" data-id="'.$data->id.'">
        //                     <i class="fa fa-trash"></i>
        //                 </button>
        //                 <a href="{{ url("user/cascading/download/'.$data->id.'") }}" class="btn btn-info btn-sm">
        //                     <i class="fa fa-download"></i>
        //                 </a>
        //             </div>  
        //         </td>
        //     </tr>';
        //     }

        // return $output;

        return response()->json([
            'cascadings' => $cascadings
        ]);

    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'tahun' => 'required',
            'file' => 'required',
            'keterangan' => 'required'
        ]);


        // if ($request->has('file')) {

        //     $name = time().'.'.explode('/', explode(':', substr($request->file, 0, strpos($request->file, ';')))[1])[1];

        //     \Image::make($request->file)->save(public_path('file/cascading/').$name);
        // }

        $file = $request->file('file');
        $name_organisasi = Organisasi::where('organisasi_no', Auth::user()->organisasi_no)->where('organisasi_jenis', 'ORG')->first()->organisasi_nama;
        $nama_file = $request->tahun.'-'.$name_organisasi.'-'.time().'.'.$file->getClientOriginalExtension();
        Storage::putFileAs('public/cascading_rpjmd', $request->file('file'), $nama_file);

        Cascading::create([
            'tahun' => $request->tahun,
            'nama_file' => $nama_file,
            'keterangan' => $request->keterangan,
            'organisasi_no' => Auth::user()->organisasi_no
        ]);

        // return $this->fetch_emit(Auth::user()->organisasi_no, $request->tahun_emit);
        return redirect('user/cascading')->with('success', 'Upload File Berhasil');
    }

    
    public function destroy(Request $request, $id)
    {
        $model = Cascading::findOrFail($id);
        Storage::disk('local')->delete('public/cascading_rpjmd/'. $model->nama_file);
        $model->delete();
        // $file = public_path('file/cascading/').$model->file;
        // if(file_exists($file))
        // {
        //     @unlink($file);
        // }

        return $this->fetch_emit(Auth::user()->organisasi_no, $request->tahun_emit);
    }

     public function download($id)
    {
        $model = Cascading::findOrFail($id);
        return Storage::disk('local')->download('public/cascading_rpjmd/'.$model->nama_file);
    }
}
