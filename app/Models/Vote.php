<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;

    protected $fillable = ['election_id', 'contestant_id', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function contestant()
    {
        return $this->belongsTo(Contestant::class);
    }

    public function info()
    {
        return $this->hasOne(UserInfo::class, 'user_id', 'user_id');
    }
}
