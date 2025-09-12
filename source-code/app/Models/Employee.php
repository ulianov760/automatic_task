<?php

namespace App\Models;

use App\Enums\SexSelect;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable
{
    use CrudTrait;
    use HasFactory;

    protected $fillable = [
        'id',
        'fio',
        'email',
        'password',
        'age',
        'sex',
        'post_id',
        'team_id',
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
    public function author_task(): HasOne
    {
        return $this->hasOne(Task::class,'author_id');
    }

    public function executor_task(): HasMany
    {
        return $this->hasMany(Task::class,'executor_id');
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function employee_roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'employee_roles', 'employee_id', 'role_id');
    }

    public function employee_groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class, 'employee_groups', 'employee_id', 'group_id');
    }

    public function hasRoles(array $roles): bool
    {
        foreach ($roles as $role) {
            if($this->employee_roles()->where('name', $role)->exists()){
                return true;
            }
        }
        return false;
    }

    public function getId(){
        return $this->id;
    }

    public function delete()
    {
        if($this->author_task()->where('author_id',$this->attributes['id'])->exists() || $this->executor_task()->where('executor_id',$this->attributes['id'])->exists()){
            return false;
        }
        Employee::where('id',$this->attributes['id'])->delete();

        return true;
    }
}
