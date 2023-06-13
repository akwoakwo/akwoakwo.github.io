<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacilitiesRoom extends Model
{
    use HasFactory;

    use HasFactory;

    protected $table = 'facilities_rooms';
    protected $guards = [];
    protected $fillable=['id','nama','room_id'];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
