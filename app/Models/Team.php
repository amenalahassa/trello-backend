<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
   protected $fillable = [
        'secteur', 'name'
   ];

    protected $withCount = ['user', 'invited'];

    protected $hidden = [
        'updated_at', 'created_at',
    ];

//    Todo : Complete the list of category
    const Category = [
        'W-IT-S' =>  'Websites, IT & Sotware',
        'WC' => 'Writing & Content',
        'D-M&A' => 'Design, Media & Architecture',
    ];

    protected $with = ['boards'];

    public function boards()
    {
        return $this->morphMany('App\Models\Boards', 'ownable');
    }

    public function user ()
    {
        return $this->belongsToMany('App\Models\User', 'member_teams', 'team_id', 'user_email', 'id', 'email')->withPivot('admin')->withTimestamps();
    }

    public function invited()
    {
        return $this->hasMany('App\Models\Invitations');
    }


}
