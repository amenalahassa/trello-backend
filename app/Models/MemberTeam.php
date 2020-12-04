<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberTeam extends Model
{
    protected $fillable = [
        'team_id', 'user_email', 'active', 'admin'
    ];


    protected $hidden = [
        'updated_at', 'created_at',
    ];


}
