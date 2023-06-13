<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aboutus extends Model
{
    use HasFactory;

    protected $table = 'aboutuss';
    protected $guards = [];
    protected $fillable=['id','site_title','site_about','deskripsi'];

}
