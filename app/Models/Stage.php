<?php

namespace App\Models;

use App\Models\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stage extends Model
{
    use HasFactory, SoftDeletes, Uuids;

    protected $fillable = [
        'project_id', 'name', 'start', 'end', 'status', 'detail', 'head', 'color', 'value'
    ];

    public function project()
    {
        $this->belongsTo(Project::class);
    }
}
