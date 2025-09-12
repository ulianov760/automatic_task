<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Group extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $fillable = [
        'id',
        'name'
    ];

    public $timestamps = false;

    public function employee():BelongsToMany
    {
        return $this->belongsToMany(Employee::class, 'employee_groups', 'group_id', 'employee_id');
    }

    public function delete()
    {
        if($this->employee()->where('group_id',$this->attributes['id'])->exists()){
            return false;
        }
        Group::where('id',$this->attributes['id'])->delete();
        return true;
    }
}
