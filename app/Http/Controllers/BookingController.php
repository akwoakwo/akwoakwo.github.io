<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Facilities;
use App\Models\FacilitiesRoom;
use App\Models\Feature;
use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\RoomImage;

class BookingController extends Controller
{
    public function newbooking($id, Request $request)
    {
        $request->validate([
            'checkIn' => 'required|date|after:now',
            'checkOut' => 'required|date|after:checkIn',
            'total_dewasa' => 'required',
            'total_anak' => 'required',
            'pesan' => 'required',
            'metode_pembayaran' => 'required',
         ]);

        $booking = Booking::create([
            'no_booking' => 'BO-'.date('Ymd').rand(1111,9999),
            'customer_id' => auth('user')->user()->id,
            'room_id' => $request->room_id,
            'checkIn' => $request->checkIn,
            'checkOut' => $request->checkOut,
            'total' => $request->total,
            'total_dewasa' => $request->total_dewasa,
            'total_anak' => $request->total_anak,
            'pesan' => $request->pesan,
            'metode_pembayaran' => $request->metode_pembayaran,
            'status' => 'dipesan',
            'kondisi' => 'digunakan',
        ]);
        Room::where('id',$id)->decrement('tersedia','1');
        if ($booking->save()) {
            return redirect('/bookingroom')->with('succes', 'Berhasil Dipesan. Kami Tunggu Kehadiran Anda Saat Check In.');
        };
        // dd($booking);
    }

    public function bookingroom($id)
    {
        $room = Room::find($id);
        $feature = Feature::where('room_id',$id)->get();
        $facility = FacilitiesRoom::where('room_id',$id)->get();
        $roomimage = RoomImage::where('room_id',$id)->get();
        return view ('customer.booking', compact(['room','feature','facility','roomimage']));
    }

    public function viewbooking()
    {
        $booking = Booking::select('*')->where('customer_id', [auth('user')->user()->id])->whereNotIn('status', ['selesai'])->with('room')->get();
        return view('customer.bookingroom',compact(['booking']));
    }

    public function viewriwayat()
    {
        $booking = Booking::select('*')->where('customer_id', [auth('user')->user()->id])->whereIn('status', ['selesai'])->get();
        return view('customer.bookingriwayat',compact(['booking']));
        // return 
    }

    // batal pemesanan
    public function destroypesan($id)
    {
        $booking = Booking::find($id);
        if ($booking->delete()){
            return redirect('bookingroom')->with('Succes', "Pemesanan Berhasil Dihapus");
        }
    }

}
