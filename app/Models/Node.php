<?php

namespace App\Models;

use App\Models\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Node extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'stage_id', 'name', 'details', 'from', 'to', 'start', 'end', 'status', 'value'
    ];
}
