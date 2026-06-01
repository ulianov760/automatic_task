<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Goat1000\SVGGraph\SVGGraph;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class Settlement extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'date_create',
        'date_finish',
        'type_transaction_id',
        'employee_id',
        'status_id',
        'company_id',
        'sum',
    ];

    public $timestamps = false;

    public static function getReport($startDate,$endDate){
        $reportData = Settlement::query()
            ->join('companies', 'settlements.company_id', '=', 'companies.id')
            ->join('type_transactions', 'settlements.type_transaction_id', '=', 'type_transactions.id')
            ->select(
                'companies.name as company_name',
                'type_transactions.name as status_name',
                'type_transactions.id as status_id',
                DB::raw('SUM(settlements.sum) as total_sum')
            )
            ->whereBetween('settlements.date_create', [$startDate, $endDate])
            ->groupBy('companies.id', 'companies.name', 'type_transactions.id', 'type_transactions.name')
            ->orderBy('companies.name')
            ->get();

             return [$reportData->sum('total_sum'),$reportData];
    }

    public static function formedChartData($data){
       return $data->groupBy('company_name')->map(function ($items, $companyName) {
           return [
               'company' => $companyName,
               'operations' => $items->map(function($item) {
                   return [
                       'name' => $item->status_name,
                       'sum' => $item->total_sum,
                       'id' => $item->status_id,
                   ];
               })
           ];
       })->toArray();
    }

    public static function generateCh($chartData){
        $dataValues = [];
        foreach ($chartData as $companyData) {
            $operations = $companyData['operations'] ?? [];

            foreach ($operations as $operation) {
                $name = $operation['name'] ?? 'Другое';
                $sum = (float)($operation['sum'] ?? 0);
                if (!isset($dataValues[$name])) {
                    $dataValues[$name] = 0;
                }
                $dataValues[$name] += $sum;
            }
        }

        if (empty($dataValues)) {
            return '';
        }

        $mainColours = ['#0000FF', '#CC0000'];
        $defaultColour = '#D3D3D3';
        $datasetColours = [];

        $i = 0;
        $data = [];
        foreach ($dataValues as $statusName => $total) {
            $datasetColours[] = $mainColours[$i] ?? $defaultColour;
            $i++;
            $data[$statusName.': '.$total] = $total;
        }

        $settings = [
            'auto_rescale'     => true,
            'back_colour'      => '#ffffff',
            'back_stroke_width'  => 0,
            'back_stroke_colour' => 'none',
            'dataset_colours'  => $datasetColours,
            'show_labels'      => false,
            'show_legend'      => true,
            'legend_shadow'    => false,
            'legend_entries'   => array_keys($data),
            'legend_position'  => 'outer bottom left',
            'legend_stroke_width'     => 0,
            'legend_stroke_colour'    => '#ffffff',
            'legend_box_back_colour'  => '#ffffff',
            'legend_shadow_thickness' => 0,
            'legend_shadow_opacity'   => 0,
            'legend_padding'   => 5,
            'pad_left'         => 15,
            'pad_right'        => 15,
            'pad_top'          => 15,
            'pad_bottom'       => 100,
            'legend_font_size' => 11,
            'legend_font_weight'=> 'bold',
            'legend_text_colour'=> '#333333',
            'inner_radius'     => 0.5,
        ];

        $graph = new \Goat1000\SVGGraph\SVGGraph(600, 400, $settings);
        $graph->values($data);

        $svg = $graph->fetch('PieGraph');

        return 'data:image/svg+xml;base64,' . base64_encode($svg);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(PaymentStatus::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(TypeTransaction::class,'type_transaction_id');
    }

    public function setDatetimeAttribute($value) {
        $this->attributes['datetime'] = \Carbon\Carbon::parse($value);
    }
}
