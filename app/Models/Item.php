<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'stage_id', 'name', 'details', 'head', 'begin', 'end', 'status'
    ];

    public function stage()
    {
        $this->belongsTo(Stage::class);
    }
}
