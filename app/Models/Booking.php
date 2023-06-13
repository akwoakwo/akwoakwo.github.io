<?php

namespace App\Models;

use App\Models\Room;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'bookings';
    protected $guards = [];
    protected $fillable=['no_booking','customer_id','room_id','checkIn','checkOut','total','total_dewasa','total_anak','pesan','metode_pembayaran','status','kondisi'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
