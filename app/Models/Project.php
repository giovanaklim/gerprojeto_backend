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

    protected $appends = ['head_name'];

    public function stages()
    {
       return $this->hasMany(Stage::class);
    }

    public function headUser()
    {
       return $this->hasOne(Team::class,'id','head');
    }

    public function getHeadNameAttribute()
    {
        $head = Team::find($this->head);
        return $head->name ?? null;
    }



    // public function setStartAttribute($value)
    // {
    //     return Carbon::createFromFormat('d/m/Y', $value);
    // }

    // public function setEndAttribute($value)
    // {
    //     return Carbon::createFromFormat('d/m/Y', $value);
    // }
}
