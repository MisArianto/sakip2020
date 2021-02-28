<?php

namespace App\Http\Controllers\User;

use Auth;
use Intervention\Image\ImageManagerStatic as Image;
use Storage;
use App\Models\Lkjip;
use App\Models\Organisasi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LkjipController extends Controller
{
    
    public function index()
    {
        return view('app.user.lkjip.index');
    }

    public function fetch(Request $request)
    {
        return $this->fetch_emit($request->organisasi_no, $request->tahun);
    }


    public function fetch_emit($organisasi_no, $tahun)
    {

        $lkjips = Lkjip::where('organisasi_no', $organisasi_no)
                        ->where('tahun', $tahun)
                        ->latest()
                        ->get();

        return response()->json([
            'lkjips' => $lkjips
        ]);

    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'tahun' => 'required',
            'file' => 'required'
        ]);

        $file = $request->file('file');

        // membuat nama file unik
        // $nama_file = rand().$file->getClientOriginalName();
        // $nama_file = rand().$file->getClientOriginalExtension();
        $name_organisasi = Organisasi::where('organisasi_no', Auth::user()->organisasi_no)->where('organisasi_jenis', 'ORG')->first()->organisasi_nama;
        $nama_file = $request->tahun.'-'.$name_organisasi.'-'.time().'.'.$file->getClientOriginalExtension();


        // upload ke folder import_data di dalam folder public
        // $file->move('lkjip',$nama_file);

        Storage::putFileAs('public/lkjip', $request->file('file'), $nama_file);

        Lkjip::create([
            'tahun' => $request->tahun,
            'nama_file' => $nama_file,
            'organisasi_no' => Auth::user()->organisasi_no
        ]);

        return redirect('user/lkjip')->with('success', 'Upload File Berhasil');
        // return $this->fetch_emit(Auth::user()->organisasi_no, $request->tahun_emit);
    }

    
    public function destroy(Request $request, $id)
    {
        $model = Lkjip::findOrFail($id);
        // $file = public_path('file/lkjip/').$model->file;
        // if(file_exists($file))
        // {
        //     @unlink($file);
        // }
        Storage::disk('local')->delete('public/lkjip/'. $model->nama_file);
        $model->delete();

        return $this->fetch_emit(Auth::user()->organisasi_no, $request->tahun);
    }

    public function download($id)
    {
    	$model = Lkjip::findOrFail($id);
    	return Storage::disk('local')->download('public/lkjip/'.$model->nama_file);
    }
}
