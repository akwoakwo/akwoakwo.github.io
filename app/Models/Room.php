<?php

namespace App\Models;

use App\Models\Booking;
use App\Models\Feature;
use App\Models\RoomImage;
use App\Models\Facilities;
use App\Models\Testimonial;
use App\Models\FacilitiesRoom;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use HasFactory;

    protected $table = 'rooms';
    protected $guards = [];
    protected $fillable=['id','jenis_kamar','harga','tamu_dewasa','tamu_anak','deskripsi','image','tersedia','status'];

    public function facilities()
    {
        return $this->belongsToMany(Facilities::class, 'detail_facilities','room_id','facility_id');
    }
    public function feature()
    {
        return $this->hasMany(Feature::class);
    }

    public function facilitiesroom()
    {
        return $this->hasMany(FacilitiesRoom::class);
    }

    public function roomimage()
    {
        return $this->hasMany(RoomImage::class);
    }

    public function bookings()
    {
        return $this->hasOne(Booking::class);
    }

    public function testimonials()
    {
        return $this->hasOne(Testimonial::class);
    }

}
