<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Athlete extends Model
{
    public function country() {
        return $this->belongsTo(Country::class);
    }
    
    public function disciplines() {
        return $this->belongsToMany(Discipline::class)
            ->withPivot('medal_type');
    }
}
