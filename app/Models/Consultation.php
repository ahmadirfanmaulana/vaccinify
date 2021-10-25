<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;
    protected $hidden  = ['society_id', 'doctor_id'];

    public function society () {
        return $this->belongsTo(Society::class);
    }

    public function doctor () {
        return $this->belongsTo(Medical::class, 'doctor_id', 'id');
    }
}
