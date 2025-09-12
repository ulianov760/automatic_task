<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Team extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $fillable = [
        'id',
        'name'
    ];

    public $timestamps = false;

    public function employee(): HasOne
    {
        return $this->hasOne(Employee::class);
    }

    public function delete()
    {
        if($this->employee()->where('team_id',$this->attributes['id'])->exists()){
            return false;
        }
        Team::where('id',$this->attributes['id'])->delete();
        return true;
    }
}
