<?php

namespace App\Http\Controllers;

use App\Models\Caraousel;
use Illuminate\Http\Request;

class CarouselController extends Controller
{
    
    public function viewcarousel()
    {
        $carousel = Caraousel::all();
        return view('admin.carousel',compact(['carousel']));
    }

    public function newcarousel(Request $request)
    {
        $data = Caraousel::create(array_merge($request->except('token', 'submit')));
        if($request->has(('image'))){
            $request->file('image')->move('images/carousel/', $request->file('image')->getClientOriginalName());
            $data->image = $request->file('image')->getClientOriginalName();
            $data->save();
        }
        if ($data->save()){
            return redirect('/carouselD')->with('succes', 'Gambar Baru Berhasil Ditambahkan');
        }
    }

    public function destroycarousel($id)
    {
        $team = Caraousel::find($id);
        if ($team->delete()){
            return redirect('/carouselD')->with('succes', 'Gambar Terkait Berhasil Dihapus');
        }
    }

}
