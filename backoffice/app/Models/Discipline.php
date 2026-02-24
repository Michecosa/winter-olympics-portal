<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discipline extends Model
{
    public function athletes() {
        return $this->belongsToMany(Athlete::class)
            ->withPivot('medal_type');
    }
}
