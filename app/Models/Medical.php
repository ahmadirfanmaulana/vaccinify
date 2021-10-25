<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medical extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;
    protected $hidden = ['spot_id', 'user_id'];
}
