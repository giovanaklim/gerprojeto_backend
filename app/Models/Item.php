<?php

namespace App\Models;

use App\Models\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory, SoftDeletes, Uuids;

    protected $fillable = [
        'stage_id', 'name', 'details', 'head', 'start', 'end', 'status', 'value'
    ];

    public function stage()
    {
        $this->belongsTo(Stage::class);
    }
}
