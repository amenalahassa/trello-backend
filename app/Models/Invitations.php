<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invitations extends Model
{

//    Todo : Find a way to send invitations

    protected $fillable = [
        'user_id', 'to_email', 'receive', 'slug', 'team_id'
    ];


    protected $hidden = [
        'updated_at', 'created_at',
    ];


    public function team ()
    {
        return $this->belongsTo('App\Models\Team');
    }

    public function user ()
    {
        return $this->belongsTo('App\Models\User');
    }
}
