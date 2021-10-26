<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vaccination extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;
    protected $hidden = ['id', 'society_id', 'spot_id', 'vaccine_id', 'doctor_id', 'officer_id'];
    protected $appends = ['status'];

    public function getVaccinationDateAttribute ($val) {
        return date('F j, Y', strtotime($val));
    }

    public function society () {
        return $this->belongsTo(Society::class);
    }

    public function spot () {
        return $this->belongsTo(Spot::class);
    }

    public function vaccine () {
        return $this->belongsTo(Vaccine::class);
    }

    public function doctor () {
        return $this->belongsTo(Medical::class, 'doctor_id', 'id');
    }

    public function officer () {
        return $this->belongsTo(Medical::class, 'officer_id', 'id');
    }

    public function getStatusAttribute () {
        return $this->vaccine ? 'done' : 'registered';
    }


}
