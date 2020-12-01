<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Boards extends Model
{
    protected $fillable = [
        'name', 'image', 'ownable_type', 'ownable_id',
    ];

    public function ownable()
    {
        return $this->morphTo();
    }

}
