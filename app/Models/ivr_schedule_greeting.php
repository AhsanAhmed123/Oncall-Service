<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ivr_schedule_greeting extends Model
{
    use HasFactory;

    protected $fillable = [
        'ivr_config_id',
        'start_date_time',
        'end_date_time',
        'title',
        'greeting_text',
        'greeting_audio',
    ];
}
