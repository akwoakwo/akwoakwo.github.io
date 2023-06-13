<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function newtestimoni(Request $request)
    {
        $data = Testimonial::create(array_merge($request->except('token', 'submit')));
        if($data->save()){
            return redirect('/profil')->with('succes', 'Terimakasih Telah Berkunjung, Kami Tunggu kedatangan Anda Kembali');
        }
    }

    public function viewtestimoni($id)
    {
        $booking= Booking::find($id);
        return view('customer.testimonial', compact(['booking']));
    }
}
