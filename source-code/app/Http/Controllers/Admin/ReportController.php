<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\EmployeeExport;
use App\Models\Status;
use App\Models\Task;
use Illuminate\Http\Request;
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
          $employeeQuery = Employee::query();

          if (!$startDate && !$endDate) {
              return json_encode([
                  'status' => false,
                  'error' => 'Выберите дату'
              ]);
          }
          $endDate = $endDate.' 23:59:59';

          $report = $employeeQuery->select(['id','fio'])->withCount(['executor_task' => function ($query)use($startDate, $endDate,$id)
          { if($id > 0)$query->where('status_id',$id); $query->whereBetween('tasks.date_create', [$startDate, $endDate]);
          }])
              ->get();
          $report->prepend([
              'ID',
              'ФИО',
              'Колличество задач',
          ]);

       (new EmployeeExport($report))->store('employee.xlsx',"downloads");
          return json_encode([
              'status' => true
          ]);
      }
}
