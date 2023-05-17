<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function period()
    {
        return $this->hasMany(Period::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function venuecat()
    {
        return $this->belongsTo(Venuecat::class);
    }
}
