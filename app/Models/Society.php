<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Society extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $hidden = ['id', 'id_card_number', 'password', 'login_tokens', 'regional_id'];
    public $timestamps = false;

    public function regional () {
        return $this->belongsTo(Regional::class);
    }
}
