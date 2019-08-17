<?php

namespace App;

use Carbon\Carbon;
use Carbon\Traits\Boundaries;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    //
    protected $guarded = [];

    protected $casts = [
        'date_starts' => 'datetime',
        'date_ends' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function path()
    {
        return '/appointments/' . $this->id;
    }

    public function day()
    {
        return $this->date_starts->format('l jS \o\f F');
    }

    public function time()
    {
        return $this->date_starts->format('H:i');
    }

    public function length()
    {
        return $this->date_starts->longAbsoluteDiffForHumans($this->date_ends);
    }
}
