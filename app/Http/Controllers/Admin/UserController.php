<?php

namespace App\Http\Controllers\Admin;

use DB;
use Hash;
use Auth;
use App\User;
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
        return view('app.admin.master.user.index');
    }

    public function fetch()
    {
        $users = User::leftJoin('organisasi as o','o.organisasi_no', 'users.organisasi_no')
                        ->select(
                            'users.*',
                            'o.organisasi_nama'
                        )
                        ->latest()
                        ->get();
        
        return response()->json([
            'users' => $users
        ]);
    }

    public function fetch_organisasi()
    {
        $opds = Organisasi::where('organisasi_jenis', 'ORG')->get();
        
        return response()->json([
            'opds' => $opds
        ]);
    }
    
    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required',
            'username' => 'required|unique:users,username',
            'level' => 'required'
        ]);

        $user = new User;
        $user->nama = $request->nama;
        $user->username = $request->username;
        $user->password = $request->password ? Hash::make($request->password) : Hash::make("123456");
        $user->level = $request->level;
        $user->organisasi_no = $request->level == 2 ? $request->opd : null;
        $user->save();

    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nama' => 'required',
            'username' => 'required|unique:users,username,'.$id,
            'level' => 'required'
        ]);

        $user = User::findOrFail($id);
        $user->nama = $request->nama;
        $user->username = $request->username;
        $user->password = $request->password == '' ? $user->password : Hash::make($request->password);
        $user->level = $request->level;
        $user->organisasi_no = $request->level == 2 ? $request->opd : null;
        $user->save();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
    }

    

}
