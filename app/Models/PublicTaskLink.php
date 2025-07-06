<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; // Assuming Task model exists

class PublicTaskLink extends Model
{
    use HasFactory;

    protected $fillable = ['task_id', 'token', 'expires_at'];

    public function publicLinks()
    {
        return $this->hasMany(PublicTaskLink::class);
    }

    public function task()
    {
        return $this->belongsTo(Tasks::class);
    }
}
