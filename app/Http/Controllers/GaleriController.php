<?php

namespace App\Http\Controllers;

use File;
use Alert;
use App\Models\Galeri;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class GaleriController extends Controller
{

    public function index()
    {
    	$galeris = Galeri::latest()->paginate(16);
    	return view('public.galeri.index', compact('galeris'));
    }

    public function show($slug)
    {
        $model = Galeri::where('slug', $slug)->first();
        return view('public.galeri.show', compact('model'));
    }

    public function admin()
    {
    	$galeris = Galeri::latest()->paginate(16);
    	return view('app.galeri.index', compact('galeris'));
    }

    public function add()
    {
    	return view('app.galeri.add');
    }

    public function store(Request $request)
    {
		$this->validate($request, [
            'judul' => 'required',
            'title' => 'required',
            'photo' => 'required'
        ]);

    	try{

	        if($request->has('photo')){

		        $galeri = new Galeri;
		        $galeri->judul = $request->judul;
		        $galeri->title = $request->title;

	            $resorce = $request->file('photo');
	            $name   = time().'-'.$resorce->getClientOriginalName();
	            $resorce->move(\base_path() ."/public/galeri", $name);

		        $galeri->photo = $name;
		        $galeri->slug = Str::slug($request->judul);
		        $galeri->save();
	        }


	        Alert::success('Data Berhasil Ditambahkan.', 'Berhasil!')->persistent('Close');

	        return redirect('master/galeri/list');

    	}catch(\Exception $e)
    	{
    		Alert::error($e->getMessage(), 'Error')->persistent('Close');
    	}
    }

    public function edit($id)
    {
    	$model = Galeri::findOrFail($id);
    	return view('app.galeri.edit', compact('model'));
    }

    public function update(Request $request, $id)
    {
    	$this->validate($request, [
            'judul' => 'required|unique:galeri,judul,'.$id,
            'title' => 'required',
            'photo' => 'required'
        ]);

    	try{

	        if($request->has('photo')){

		        $galeri = Galeri::findOrFail($id);
		        $galeri->judul = $request->judul;
		        $galeri->title = $request->title;

	            $resorce = $request->file('photo');
	            $name   = time().'-'.$resorce->getClientOriginalName();
	            $resorce->move(\base_path() ."/public/galeri", $name);

		        $image_path = \base_path() ."/public/galeri/".$galeri->photo;

	    		if(File::exists($image_path)) {
				    File::delete($image_path);
				}

		        $galeri->photo = $name;
		        $galeri->slug = Str::slug($request->judul);
		        $galeri->save();

	        }


	        Alert::success('Data Berhasil diupdate.', 'Berhasil!')->persistent('Close');

	        return redirect('master/galeri/list');

    	}catch(\Exception $e)
    	{
    		Alert::error($e->getMessage(), 'Error')->persistent('Close');
    	}
    }

    public function destroy($id)
    {
    	try{

    		$galeri = Galeri::findOrFail($id);

    		$image_path = \base_path() ."/public/galeri/".$galeri->photo;

    		if(File::exists($image_path)) {
			    File::delete($image_path);
			}

    		$galeri->delete();

    		Alert::success('Data Berhasil Ditambahkan.', 'Berhasil!')->persistent('Close');

	        return redirect('master/galeri/list');

    	}catch(\Exeption $e)
    	{
    		Alert::error($e->getMessage(), 'Error')->persistent('Close');
    	}
    }
}
