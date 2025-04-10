<?php

namespace App\Models;

use App\Models\ivr_options;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class department extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name', 
        'email',
        'phone_number',
        'colour',   
        'assigned_key',
        'active_user_id'
    ];
    
    public function ivr_options()
    {
        return $this->hasMany(ivr_options::class, 'ivr_dept_id')
                    ->where('active_user_id', auth()->user()->id);
    }

    public function User(){
        return $this->hasOne(User::class);
        
    }
    
    public function callrecording(){
        return $this->hasMany(callrecording::class, 'department_id');
    }
    
}
