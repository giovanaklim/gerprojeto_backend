<?php

namespace App\Models;

use App\Models\Traits\Uuids;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes, Uuids;

    protected $fillable = [
        'name', 'due_date', 'value', 'status', 'start', 'end', 'company', 'user_id', 'head'
    ];

    public function stages()
    {
        $this->hasMany(Stage::class);
    }

    public function setStartAttribute($value)
    {
        return Carbon::createFromFormat('d/m/Y', $value);
    }

    public function setEndAttribute($value)
    {
        return Carbon::createFromFormat('d/m/Y', $value);
    }
}
