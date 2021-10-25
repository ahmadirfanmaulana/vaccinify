<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spot extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;
    protected $hidden = ['regional_id'];
    protected $appends = ['available_vaccines'];

    public function regional () {
        return $this->belongsTo(Regional::class);
    }

    public function spot_vaccine () {
        return $this->hasMany(SpotVaccine::class);
    }

    public function getAvailableVaccinesAttribute () {
        $id = $this->id;
        $available_vaccines = [];

        foreach (Vaccine::all() as $vaccine) {
            $available_vaccines[$vaccine->name] = SpotVaccine::where('spot_id', $id)->where('vaccine_id', $vaccine->id)->first() ? true : false;
        }

        return $available_vaccines;
    }
}
