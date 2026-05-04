<?php

namespace App\Models;

use App\Interfaces\HasUpdatesInterface;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vacation extends Model implements HasUpdatesInterface
{
    use CrudTrait;
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'date_start',
        'date_finish',
        'priority_id',
        'employee_id',
        'status_id',
    ];

    public $timestamps = false;

    public static function getReport($startDate, $endDate, $id){
        $reportData = Employee::query()
            ->select(['id', 'fio'])
            ->with(['vacation' => function ($query) use ($startDate, $endDate, $id) {
                if ($id > 0) {
                    $query->where('status_id', $id);
                }
                $query->whereBetween('date_start', [$startDate, $endDate]);
            }])
            ->get()
            ->map(function ($employee) {
                $daysCount = $employee->vacation->reduce(function ($carry, $vacation) {
                    $start = \Carbon\Carbon::parse($vacation->date_start);
                    $finish = \Carbon\Carbon::parse($vacation->date_finish);
                    return $carry + $start->diffInDays($finish);
                }, 0);

                return (object)[
                    'fio' => $employee->fio,
                    'total_days' => $daysCount
                ];
            })
            ->filter(fn($item) => $item->total_days > 0);

       return [$reportData->sum('total_days'),$reportData];
    }

    public function getEntityName(): string
    {
        return 'Отпуск';
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(VacationStatus::class);
    }

    public function setDatetimeAttribute($value) {
        $this->attributes['datetime'] = \Carbon\Carbon::parse($value);
    }
}
