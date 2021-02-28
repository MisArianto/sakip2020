<?php

namespace App\Http\Controllers;

use DB;
use PDF;
use Hash;
use Auth;
use Alert;
use App\User;
use Validator;
use DataTables;
use Vinkla\Hashids\Facades\Hashids;
use App\Models\Organisasi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('level')->get();
        // return $users;
        return view('app.master.user.index', compact('users'))->with('no',1);
    }

    public function indexUser()
    {
        return view('app.master.user.indexUser');
    }

    // public function dataUser()
    // {
        
    //     $model = User::query();

    //     return DataTables::of($model)
    //     ->addColumn('action', function ($model) {
    //         return view('app.master._action', [
    //             'model'=>$model,
    //             'url_edit'=>route('user.edit',$model->id),
    //             'url_destroy'=>url('user.destroy',$model->id)
    //         ]);
            
    //     })
    //     ->addIndexColumn()
    //     ->rawColumns(['action'])
    //     ->make(true);


    //     // return DataTables::of(User::query())->make(true);
    // }
    // return '<a href="user/edit'.$user->id.'" class="btn btn-primary" ><i class="lnr lnr-pencil"></i>Edit</a> <form action="user/hapus/'.$user->id.'" method="POST"> '.csrf_field().' 
            // <button type="submit" class="btn btn-danger"><i class="lnr lnr-trash"></i> Hapus</button></form>';

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $model = new User();

        $opd = Organisasi::where('organisasi_jenis','=','ORG')->orderBy('organisasi_no')->get();

        return view('app.master.user.create', compact('opd'));
        // return view('app.master.user.form', compact('model','opd'));
    }

    public function cetakPdf()
    {

        $users = User::where('level',2)->get();
        return $users;
 
        $pdf = PDF::loadview('report.user',['users'=>$users])->with('no',1);
        return $pdf->download('laporan-users.pdf');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required',
            'username' => 'required',
            'password' => 'required|min:6',
            'level' => 'required',
        ]);

        $user = new User;
        $user->nama = $request->nama;
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->level = $request->level;
        $user->organisasi_no = $request->opd;
        $user->save();

        Alert::success('Data Berhasil Ditambahkan.', 'Berhasil!')->persistent('Close');

        return redirect('master/user');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user=User::where('id',Hashids::decode($id))->first();
        $opds = Organisasi::where('organisasi_jenis','=','ORG')->get();
       return view('app.master.user.edit',compact('user', 'opds'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nama' => 'required',
            'username' => 'required|unique:users,username,'.$id,
            // 'password' => 'min:6',
            'level' => 'required'
        ]);

        $user = User::findOrFail($id);


        if ($request->password == null || $request->password == '') {
            $pass = $user->password;
        }else{
            $pass = Hash::make($request->password);
        }

        // $model->update($request->all());

        $user->nama = $request->nama;
        $user->username = $request->username;
        $user->password = $pass;
        $user->level = $request->level;
        $user->organisasi_no = $request->opd;
        $user->save();

        // $request->session()->flash('success', 'Data Berhasil update');
        Alert::success('Data Berhasil Diupdate.', 'Berhasil!')->persistent('Close');

        if(Auth::user()->level == 1)
        {
            return redirect('master/user');
        }else{
            return redirect('user/profile');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::where('id', Hashids::decode($id))->first();
        $user->delete();

        Alert::success('Data Berhasil Dihapus.', 'Berhasil!')->persistent('Close');
        return back();
    }

    

}
