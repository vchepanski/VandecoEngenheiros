<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['title', 'description', 'type', 'priority', 'status', 'documentation'];

    public function subtasks(){
        return $this->hasMany(Subtask::class);
    }
}
