<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stage extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'start', 'end', 'status', 'detail', 'head', 'to', 'from'
    ];

    public function project()
    {
        $this->belongsTo(Project::class);
    }
}
