<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Employee;
use App\Models\EmployeeExport;
use App\Models\Status;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;


class ReportController extends Controller
{
      public function getData(){
          $statuses = Status::all();

          return json_encode([
              'statuses' => $statuses
          ]);
      }

      public function createReport(Request $request){
          $startDate = $request->request->get('startDate');
          $endDate = $request->request->get('endDate');
          $id = $request->request->get('id');
          $type = $request->request->get('type');
          $employeeQuery = Employee::query();


          if (!$startDate && !$endDate) {
              return json_encode([
                  'status' => false,
                  'error' => 'Выберите дату'
              ]);
          }
          $endDate = $endDate.' 23:59:59';
          if($type == 1) {
              $report = $employeeQuery->select(['id', 'fio'])->withCount([
                  'executor_task' => function ($query) use ($startDate, $endDate, $id) {
                      if ($id > 0) {
                          $query->where('status_id', $id);
                      }
                      $query->whereBetween('tasks.date_create', [$startDate, $endDate]);
                  }
              ])
                  ->get();
              $report->prepend([
                  'ID',
                  'ФИО',
                  'Колличество задач',
              ]);

              (new EmployeeExport($report))->store('employee.xlsx', "downloads");
          }else {
              $reportData = \App\Models\Settlement::query()
                  ->join('companies', 'settlements.company_id', '=', 'companies.id')
                  ->join('type_transactions', 'settlements.type_transaction_id', '=', 'type_transactions.id')
                  ->select(
                      'companies.name as company_name',
                      'type_transactions.name as status_name',
                      DB::raw('SUM(settlements.sum) as total_sum')
                  )
                  ->whereBetween('settlements.date_create', [$startDate, $endDate])
                  ->groupBy('companies.id', 'companies.name', 'type_transactions.id', 'type_transactions.name')
                  ->orderBy('companies.name')
                  ->get();
              $data = $reportData->map(function ($item) {
                  return [
                      $item->company_name,
                      $item->status_name,
                      $item->total_sum ?? 0,
                  ];
              });
              $data->prepend([
                  'Компания',
                  'Статус',
                  'Сумма',
              ]);

              (new EmployeeExport($data))->store('settlements.xlsx', "downloads");
          }
          return json_encode([
              'status' => true
          ]);
      }
}
