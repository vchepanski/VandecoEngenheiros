<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subtask extends Model
{
    protected $fillable = [
        'task_id',
        'description',
        'completed',
        'content',
    ];

    protected $casts = [
        'completed' => 'boolean',
    ];

    public function task(){
        return $this->belongsTo(Task::class);
    }
}
