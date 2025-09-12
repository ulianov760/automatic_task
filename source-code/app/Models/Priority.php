<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Priority extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $fillable = [
        'id',
        'name'
    ];

    public $timestamps = false;

    public function task(): HasOne
    {
        return $this->hasOne(Task::class);
    }

    public function delete()
    {
        if($this->task()->where('priority_id',$this->attributes['id'])->exists()){
            return false;
        }
        Priority::where('id',$this->attributes['id'])->delete();
        return true;
    }
}
