<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberTeam extends Model
{
    protected $fillable = [
        'team_id', 'active', 'email'
    ];

    public function team ()
    {
        return $this->belongsTo('App\Models\Team');
    }
}
