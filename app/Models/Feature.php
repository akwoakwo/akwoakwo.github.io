<?php

namespace App\Models;

use App\Models\Room;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Feature extends Model
{
    use HasFactory;

    protected $table = 'features';
    protected $guards = [];
    protected $fillable=['id','nama','room_id'];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
