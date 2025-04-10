<?php

namespace App\Models;

use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ivr_options extends Model
{
    use HasFactory;

    protected $fillable = [
        'ivr_config_id', 
        'ivr_dept_id',   
        'text_greeting',
        'audio_greeting',
        'link', 
        'active_user_id'        
    ];

     public function department()
    {
        return $this->belongsTo(Department::class, 'ivr_dept_id', 'id');
    }
}
