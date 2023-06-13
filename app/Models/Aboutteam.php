<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aboutteam extends Model
{
    use HasFactory;

    protected $table = 'aboutteams';
    protected $guards = [];
    protected $fillable=['id','nama','image'];
}
