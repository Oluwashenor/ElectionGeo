<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Election extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'election_date'];

    public function contestants()
    {
        return $this->hasMany(Contestant::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }
}
