<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
   protected $fillable = [
       'user_id', 'secteur', 'access', 'name'
   ];

    public function user ()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function members ()
    {
        return $this->hasMany('App\Models\MemberTeam');
    }

    const Category = [
        'W-IT-S' =>  'Websites, IT & Sotware',
        'WC' => 'Writing & Content',
        'D-M&A' => 'Design, Media & Architecture',
    ];

}
