<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class business_details extends Model
{
    use HasFactory;

    protected $table = 'accounts';

    protected $fillable = [
        'business_name',
        'designation',
        'user_id',
        'address',
        'contact',
        'agent_greeting',
        'website',
        'obituary_link',
        'directions_link',
        'agent_notes',
        'fax_numbers',
        'bulk_emails',
        'bulk_sms',
        'business_phone',
        'did_config',
        'did_number',
        'callback_required',
        'call_person_name',
        'seconds_past', 
        'send_reminder_tx',
        'active_agents',
        'notifications',
        'survey',
        'join_calls',
        'schedule_greeting',    
        'timezone',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
}
