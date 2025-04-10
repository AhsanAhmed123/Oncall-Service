<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CallRecording extends Model
{
    use HasFactory;

    protected $fillable = [
        'call_sid',
        'recording_url',
        'recording_sid',
        'recording_duration',
        'from_number',
        'from_city',
        'from_state',
        'from_zip',
        'from_country',
        'to_number',
        'to_city',
        'to_state',
        'to_zip',
        'to_country',
        'direction',
        'caller',
        'caller_city',
        'caller_state',
        'caller_zip',
        'caller_country',
        'call_status',
        'called',
        'called_city',
        'called_state',
        'called_zip',
        'called_country',
        'account_sid',
        'api_version',
        'department_id'
    ];
    
      public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }
}
