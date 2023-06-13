<?php

namespace App\Http\Controllers;

use App\Models\GambarBayar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class GambarBayarController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required'
         ]);

        $data = GambarBayar::create(array_merge($request->except('token', 'submit'),[
            'password' => Hash::make($request->password)
        ]));
        if($request->has(('image'))){
            $request->file('image')->move('images/users', $request->file('image')->getClientOriginalName());
            $data->image = $request->file('image')->getClientOriginalName();
            $data->save();
        }
        if($data->save()){
            return redirect('/')->with('succes', 'Berhasil Melakukan Pembayaran');
        }
    }
    
}
