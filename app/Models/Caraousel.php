<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caraousel extends Model
{
    use HasFactory;

    protected $table = 'caraousels';
    protected $guards = [];
    protected $fillable=['id','image'];
}
