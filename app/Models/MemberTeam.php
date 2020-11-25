<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberTeam extends Model
{
    protected $fillable = [
        'team_id', 'user_email', 'active', 'admin'
    ];

}
