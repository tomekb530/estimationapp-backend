<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estimation extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'project_id', 'price', 'duration', 'type'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
