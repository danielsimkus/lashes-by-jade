<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $guarded = [];

    public function user()
    {
        return $this->hasOne(User::class);
    }
}