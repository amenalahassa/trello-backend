<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Boards extends Model
{
    protected $fillable = [
        'name', 'image', 'ownable'
    ];

    public function ownable()
    {
        return $this->morphTo();
    }

}
