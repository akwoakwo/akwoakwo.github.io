<?php

namespace App\Http\Controllers;

use App\Models\DetailFacilities;
use App\Models\Facilities;
use App\Models\Feature;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FiturFasilitasController extends Controller
{
    public function viewfeature()
    {
        $room = Room::all();
        $fasilitas = Facilities::all();
        $fitur = Feature::all();
        return view('admin.fitur_fasilitas', compact(['room','fasilitas','fitur']));
        // return Room::with('facilities')->get();
        // return Facilities::with('room')->get();
    }
    
    public function newfeature(Request $request)
    {
        $request->validate([
            'nama' => 'required', 
            'room_id' => 'required', 
        ]);

        $feature = Feature::create(array_merge($request->except('token', 'submit')));
        if ($feature->save()){
            return redirect('/fasilitasD')->with('succes', 'Fitur Baru Telah Ditambahkan');
        }
    }
    
    public function destroyfeature($id)
    {
        $fiture = DB::delete('delete from features where room_id = ?',[$id]);
        if ($fiture){
            return redirect('/fasilitasD')->with('succes', 'Fitur Terkait Berhasil Dihapus');
        }
    }
    
    
    public function viewfacilities()
    {
        $fasilitas = Facilities::all();
        return view('customer.fasilitas', compact(['fasilitas']));
    }
    
    public function newfacility(Request $request)
    {
        $request->validate([
            'nama' => 'required', 
            'ket' => 'required', 
            'logo' => 'required', 
        ]);

        $data = Facilities::create(array_merge($request->except('token', 'submit')));
        if($request->hasFile(('logo'))){
            $request->file('logo')->move('images/facilities/', $request->file('logo')->getClientOriginalName());
            $data->logo = $request->file('logo')->getClientOriginalName();
            $data->save();
        }
        if($data->save()){
            return redirect('/fasilitasD')->with('succes', 'Fasilitas Baru Berhasil Ditambahkan');
        }
    }
    
    public function destroyfacilityicon($id)
    {
        $fasilitas = Facilities::find($id);
        if ($fasilitas->delete()){
            return redirect('/fasilitasD')->with('succes', 'Fasilitas Terkait Berhasil Dihapus');
        }
    }
    
    public function destroyfacility($id)
    {
        $fasilitas = DB::delete('delete from facilities_rooms where room_id = ?',[$id]);
        if ($fasilitas){
            return redirect('/fasilitasD')->with('succes', 'Fasilitas Terkait Berhasil Dihapus');
        }
    }

    public function detailfacility(Request $request)
    {
        $request->validate([
            // 'facility_id[]' => 'required', 
            'room_id' => 'required', 
        ]);

        $data = $request->all();
        $facility_id = $data['nama'];
        $room_id = $data['room_id'];

        foreach ($facility_id as $fs){
            DB::table('facilities_rooms')->insert(['nama'=>$fs, 'room_id'=>$room_id]);
        }
        return redirect('/fasilitasD')->with('succes', 'Fasilitas Berhasil Ditambahkan Pada Kamar');
    }
}
