<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invitations extends Model
{

//    Todo : Find a way to send invitations

    protected $fillable = [
        'from_id', 'to_email', 'receive', 'slug'
    ];

}
