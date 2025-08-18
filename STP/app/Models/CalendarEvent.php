<?php

namespace App\Models;

use Guava\FilamentCalendar\Concerns\InteractsWithCalendar;
use Illuminate\Database\Eloquent\Model;

class CalendarEvent extends Model
{
    // use InteractsWithCalendar;

    protected $fillable = ['name', 'description', 'starts_at', 'ends_at'];
}
