<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class VacationStatus extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $fillable = [
        'id',
        'name'
    ];

    public $timestamps = false;

    public function vacation(): HasMany
    {
        return $this->hasMany(Vacation::class,'status_id');
    }

    public function delete()
    {
        if($this->vacation()->where('status_id',$this->attributes['id'])->exists()){
            return false;
        }
        VacationStatus::where('id',$this->attributes['id'])->delete();
        return true;
    }
}
