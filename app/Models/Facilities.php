<?php

namespace App\Models;

use App\Models\Room;
use App\Models\DetailFacilities;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Facilities extends Model
{
    use HasFactory;

    protected $table = 'facilities';
    protected $guards = [];
    protected $fillable=['id','nama','ket','logo'];

    public function room()
    {
        return $this->belongsToMany(Room::class, 'detail_facilities','facility_id','room_id');
    }

    public function detail()
    {
        return $this->hasMany(DetailFacilities::class);
    }
}
