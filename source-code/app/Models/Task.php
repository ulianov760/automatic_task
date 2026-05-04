<?php

namespace App\Models;

use App\Interfaces\HasUpdatesInterface;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Task extends Model implements HasUpdatesInterface
{
    use CrudTrait;
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'description',
        'date_create',
        'date_finish',
        'priority_id',
        'author_id',
        'executor_id',
        'group_id',
        'status_id'
    ];

    public $timestamps = false;

    public function getEntityName(): string
    {
        return 'Задача';
    }

    public function author_task(): BelongsTo
    {
        return $this->belongsTo(Employee::class,'author_id');
    }

    public function executor_task(): BelongsTo
    {
        return $this->belongsTo(Employee::class,'executor_id');
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    public function priority(): BelongsTo
    {
        return $this->belongsTo(Priority::class);
    }

    public function setDatetimeAttribute($value) {
        $this->attributes['datetime'] = \Carbon\Carbon::parse($value);
    }
}
