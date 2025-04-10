<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ivr_configurations extends Model
{
    use HasFactory;
    protected $fillable = [
        'did_number',
        'business_phone',
        'ivr_type',
        'tts_audio',
        'ttstype',
        'main_greeting',
        'repeat_count',
        'added_by',
    ];
}
