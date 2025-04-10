<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roster extends Model
{

    use HasFactory;

    protected $guarded = []; 

    
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class, 'username');
    }
}
