<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        'user_id', 'name', 'notes', 'tags'
    ];
    
    protected $casts = [
        'user_id' => 'user',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
