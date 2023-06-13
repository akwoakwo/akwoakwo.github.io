<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use App\Models\Customer;
use App\Models\Testimonial;
// use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class AdminController extends Controller
{
    public function indeks()
    {
        return view('admin.index');
    }
    
    public function login(Request $request)
    {
        $request->validate([
           'email' => 'required',
           'password'=> 'required' 
        ]);
        if (Auth::guard('admin')->attempt($request->only('email','password'))) {
            return redirect('/adminD');
        }
        else {
            return redirect('/admin')->with('wrong', 'Invalid Email and Password ! Try Again');
        }
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/admin');
    }

    public function profil()
    {
        $admin = auth('admin')->user();
        return view('admin.profile',compact(['admin']));
    }

    public function addadmin(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'email' => 'required|email|unique:users',
            'telepon' => 'required|numeric|digits:12',
            'alamat' => 'required',
            'tanggal_lahir' => 'required',
            'image' => 'required',
            'password'=> 'required' 
         ]);

        $data = Admin::create(array_merge($request->except('token', 'submit'),[
            'password' => Hash::make($request->password)
        ]));
        if($request->has(('image'))){
            $request->file('image')->move('images/admin', $request->file('image')->getClientOriginalName());
            $data->image = $request->file('image')->getClientOriginalName();
            $data->save();
        }
        if($data->save()){
            return redirect('/profilD')->with('succes', 'Data berhasil disimpan. Selamat Datang !');
        }
    }

    public function editprofil($id)
    {
        $admin = Admin::find($id);
        return view ('admin.profileedit', compact(['admin']));
    }

    public function updateprofil($id, Request $request)
    {
        $User = Admin::find($id);
        $User->update($request->only(['username','email','telepon','alamat','tanggal_lahir']));
        if ($User->save()){
            return redirect('/profilD')->with('succes', 'Profil Berhasil Diupdate');
        }
    }

    public function updateimage($id, Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
         ]);

        $User = Admin::find($id);
        $User->update($request->only(['image']));
        if($request->has(('image'))){
            $request->file('image')->move('images/admin', $request->file('image')->getClientOriginalName());
            $User->image = $request->file('image')->getClientOriginalName();
            $User->save();
        }
        if ($User->save()){
            return redirect('/profilD')->with('succes', 'Profil Berhasil Diupdate');
        }
    }

    public function user()
    {
        $admin = Admin::all();
        $customer = Customer::all();
        return view('admin.user',compact('admin','customer'));
    }



    public function dashboard()
    {
        $income = Booking::select('*')->sum('total');
        $digunakan = DB::table('bookings')->whereIn('status', ['digunakan','dikonfirmasi'])->count();
        $tersedia =  Room::select('*')->sum('tersedia');
        $kotor = DB::table('bookings')->whereIn('kondisi', ['kotor'])->count();
        $fasilitas = DB::table('facilities')->count();
        $testimoni =  Testimonial::all();
        $rating =  DB::table('testimonials')->avg('rating');
        $user = DB::table('users')->count();
        $customer = Customer::limit(5)->orderBy('created_at', 'desc')->get();
        $antrian = Booking::limit(3)->whereNotIn('status', ['selesai'])->get();
        $linechart = Booking::selectRaw('count(id) as total_bookings, checkIn')->groupBy('checkIn')->get();
        $piechart = DB::table('rooms')->join('bookings','bookings.room_id','=','rooms.id')->select('rooms.jenis_kamar', DB::raw('count(rooms.jenis_kamar) as penggunaan'))->groupBy('rooms.jenis_kamar')->get();

        $label=[];
        $data=[];
        foreach($linechart as $lc){
            $label[]=$lc['checkIn'];
            $data[]=$lc['total_bookings'];
        }

        $plabels = [];
        $pdata = [];
        foreach($piechart as $pc) {
            $plabels[]=$pc->jenis_kamar;
            $pdata[]=$pc->penggunaan;
        }
        return view('admin.dashboard', compact(['income','digunakan','tersedia','kotor','fasilitas','testimoni','rating','user','customer','antrian','label','data','plabels','pdata']));
    }


    public function viewantrian()
    {
        $booking = Booking::select('*')->whereNotIn('status', ['selesai'])->get();
        return view('admin.antrian',compact(['booking']));
    }

    public function editantriankonfirmasi($id)
    {
        DB::table('bookings')->where('id',$id)->update(['status' => 'dikonfirmasi']);
        return redirect('/antrianD');
    }
    public function editantrianbatalkan($id)
    {
        DB::table('bookings')->where('id',$id)->update(['status' => 'dipesan']);
        return redirect('/antrianD');
    }
    public function editantrianselesai($id)
    {
        DB::table('bookings')->where('id',$id)->update(['status' => 'selesai']);
        DB::table('bookings')->where('id',$id)->update(['kondisi' => 'kotor']);
        return redirect('/bookingriwayat');
    }
    public function editantriankamarkotor1($id)
    {
        Room::where('id',$id)->increment('tersedia','1');;
        return redirect('/kamarR')->with('succes', 'Kamar Kembali Tersedia, Silahkan Konfirmasi Kembali');
    }
    
    public function editantriankamarkotor2($id)
    {
        DB::table('bookings')->where('id',$id)->update(['kondisi' => 'available']);
        return redirect('/kamarR');
    }
}
