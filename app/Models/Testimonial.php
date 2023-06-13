<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $table = 'testimonials';
    protected $guards = [];
    protected $fillable=['customer_id','room_id','rating','testimoni'];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
