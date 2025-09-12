<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Role extends Model
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
        return $this->belongsToMany(Employee::class, 'employee_roles',
        'role_id','employee_id');
    }

    public function delete()
    {
        if($this->employee()->where('role_id',$this->attributes['id'])->exists()){
            return false;
        }
        Role::where('id',$this->attributes['id'])->delete();
        return true;
    }
}
