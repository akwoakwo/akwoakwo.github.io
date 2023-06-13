<?php

namespace App\Models;

use App\Models\Room;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RoomImage extends Model
{
    use HasFactory;

    protected $table = 'roomsimages';
    protected $guards = [];
    protected $fillable=['id','image','room_id'];

    public function rooms()
    {
        return $this->belongsTo(Room::class);
    }
}
