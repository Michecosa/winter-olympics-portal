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

    public function getGoldCountAttribute()
    {
        return $this->disciplines->filter(fn($d) => $d->pivot->medal_type === 'gold')->count();
    }

    public function getSilverCountAttribute()
    {
        return $this->disciplines->filter(fn($d) => $d->pivot->medal_type === 'silver')->count();
    }

    public function getBronzeCountAttribute()
    {
        return $this->disciplines->filter(fn($d) => $d->pivot->medal_type === 'bronze')->count();
    }
}
