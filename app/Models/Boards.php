<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Boards extends Model
{
    protected $fillable = [
        'name', 'image', 'ownable_type', 'ownable_id',
    ];


    protected $hidden = [
        'updated_at', 'created_at',
    ];


    public function ownable()
    {
        return $this->morphTo();
    }

}
