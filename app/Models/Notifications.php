<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{

//     Todo find a way to delete when the team or board is delete it before the user "to" confirm

    protected $fillable = [
        'type', 'content', 'for', 'to', 'from', 'read'
    ];
}
