<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Booking;
use App\Models\DetailFacilities;
use App\Models\RoomImage;
use App\Models\Feature;
use App\Models\Facilities;
use App\Models\FacilitiesRoom;
use App\Models\Testimonial;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class RoomController extends Controller
{

    public function viewroom()
    {
        $room = Room::all();
        return view('admin.kamar',compact(['room']));
    }

    public function viewdirtyroom()
    {
        return view('admin.kamarkotor',[
            'booking' => Booking::where('kondisi','kotor')->get()
        ]);
    }

    public function newroom(Request $request)
    {
        $data = Room::create($request->except(['token', 'submit']));
        if($request->has(('image'))){
            $request->file('image')->move('images/preview', $request->file('image')->getClientOriginalName());
            $data->image = $request->file('image')->getClientOriginalName();
            $data->save();
        }
        if ($data->save()) {
            return redirect('/kamarD')->with('succes', 'Room Baru Telah Ditambahkan');
        };
    }

    public function editroom($id)
    {
        $room = Room::find($id);
        return view ('admin.kamarEdit', compact(['room']));
    }

    public function updateroom($id, Request $request)
    {
        $room = Room::find($id);
        $room->update($request->except(['token', 'submit']));
        if ($room->save()){
            return redirect('/kamarD')->with('succes', 'Room Berhasil Diupdate');
        }
    }

    public function destroyroom($id)
    {
        $room = Room::find($id);
        if ($room->delete()){
            return redirect('/kamarD')->with('succes', 'Room Terkait Berhasil Dihapus');
        }
    }

    public function viewroomimage($id)
    {
        $room = Room::find($id);
        $roomage = RoomImage::where('room_id',$id)->get();
        return view ('admin.kamarGambar', compact(['room','roomage']));
    }

    public function newroomimage(Request $request)
    {
        $RoomImage = RoomImage::create($request->except(['token', 'submit']));
        if($request->has(('image'))){
            $request->file('image')->move('images/rooms', $request->file('image')->getClientOriginalName());
            $RoomImage->image = $request->file('image')->getClientOriginalName();
            $RoomImage->save();
        }
        if ($RoomImage->save()) {
            return redirect('/kamarD')->with('succes', "Room's Image Berhasil Ditambahkan");
        }
    }

    public function destroyimage($id)
    {
        $room = RoomImage::find($id);
        if ($room->delete()){
            return redirect('/kamarD')->with('succes', "Room's Image Berhasil Dihapus");
        }
    }


    public function viewkamar()
    {
        $room = Room::all();
        return view('customer.kamar',compact(['room']));
        // return DB::table('rooms')->join('features','features.room_id','=','rooms.id')->join('detail_facilities','detail_facilities.room_id','=','rooms.id')->join('facilities','facilities.id','=','detail_facilities.facility_id')->groupBy('rooms.jenis_kamar')->get();
    }

    public function detailkamar($id)
    {
        $room = Room::find($id);
        $feature = Feature::where('room_id',$id)->get();
        $facilitiesroom = FacilitiesRoom::where('room_id',$id)->get();
        // $facility = DB::table('facilities')->join('detail_facilities','detail_facilities.facility_id','=','facilities.id')->join('rooms','rooms.id','=','detail_facilities.room_id')->where('rooms.id','=',1)->get();
        $roomimage = RoomImage::where('room_id',$id)->get();
        $testimoni = Testimonial::where('room_id',$id)->get();
        $rating = DB::table('testimonials')->where('room_id',$id)->avg('rating');
        return view ('customer.detailkamar', compact(['room','feature','facilitiesroom','roomimage','testimoni','rating']));

        // return DB::table('facilities')->join('detail_facilities','detail_facilities.facility_id','=','facilities.id')->join('rooms','rooms.id','=','detail_facilities.room_id')->where('rooms.id','=',1)->get(["facilities.nama","facilities.image"]);
    }
    // public function viewkamar($id)
    // {
    //     $room = Room::find($id);
    //     $feature = Feature::where('room_id',$id)->get();
    //     $facility = Facilities::where('room_id',$id)->get();
    //     $roomimage = RoomImage::where('room_id',$id)->get();
    //     return view ('customer.booking', compact(['room','feature','facility','roomimage']));
    // }

    public function filterkamar(Request $request)
    {
        // $room = DB::table('bookings')
        //     ->join('rooms','rooms.id','bookings.room_id')
        //     // ->join('features','features.room_id','rooms.id')
        //     // ->join('facilities','facilities.room_id','rooms.id')
        //     ->whereBetween('bookings.checkIn',[$request->checkIn, $request->checkOut])
        //     ->get();

        // $request->validate([
        //     'checkIn' => 'required|date|after:now',
        //     'checkOut' => 'required|date|after:checkIn',
        //  ]);

        return view('customer.kamarpesan',[
            'room' => Room::where('tersedia','>','0')->whereNotIn('status', ['tidak aktif'])->get(),
            'room_aktif' => Room::whereIn('status', ['aktif'])->get()
        ]);
    }
    




    // public function cek(Request $request)
    // {
    //     // $data = Room::create($request->only(['checkIn', 'checkOut']));
    //     return view('customer.kamar',[
    //         'pesanans' => Booking::where('status_pesanan','selesai')->get()
    //     ]);
    // }
}
