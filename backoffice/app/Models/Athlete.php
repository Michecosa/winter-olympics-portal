<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Athlete extends Model
{
    public function athlete() {
        return $this->belongsTo(Country::class);
    }
}
