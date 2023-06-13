<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aboutcontact extends Model
{
    use HasFactory;

    protected $table = 'aboutcontacts';
    protected $guards = [];
    protected $fillable=['id','alamat','maps','telepon','telepon_rujukan','email','email_rujukan','media_sosial','medsos_rujukan','iframe'];

}
