<?php

namespace App\Models;

use App\Models\Room;
use App\Models\Facilities;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailFacilities extends Model
{
    use HasFactory;

    protected $table = 'detail_facilities';
    protected $guards = [];
    protected $fillable=['id','facility_id','room_id'];

    public function rooms()
    {
        return $this->belongsTo(Room::class);
    }

    public function facility()
    {
        return $this->belongsTo(Facilities::class);
    }
}
