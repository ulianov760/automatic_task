<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Employee;
use App\Models\EmployeeExport;
use App\Models\Settlement;
use App\Models\Status;
use App\Models\Task;
use App\Models\Vacation;
use App\Models\VacationStatus;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;


class ReportController extends Controller
{
      public function getData(){
          $statuses = Status::all();
          $statusesVacation = VacationStatus::all();
          return json_encode([
              'statuses' => $statuses,
              'statusesVacation' => $statusesVacation,
          ]);
      }

      public function createReport(Request $request){
          $startDate = $request->request->get('startDate');
          $endDate = $request->request->get('endDate');
          $id = $request->request->get('id');
          $type = $request->request->get('type');
          $view = $request->request->get('view');

          $fileName = 'report_' . time() . '.pdf';
          $data = [];
          $totalSum = 0;
          $chatBase64 = '';

          if(!in_array($type,[1,2,3])){
              return json_encode([
                                     'status' => false,
                                     'error' => 'Выберите тип отчета'
                                 ]);
          }

          if (!$startDate && !$endDate) {
              return json_encode([
                  'status' => false,
                  'error' => 'Выберите дату'
              ]);
          }

          if($type == 3 && $id < 1){
              return json_encode([
                                     'status' => false,
                                     'error' => 'Выберите статус'
                                 ]);
          }
          $endDate = $endDate.' 23:59:59';
          if($type == 1) {
              $result = Employee::getReport($startDate,$endDate,$id);
              $totalSum = $result[0];
              $data = $result[1];
              $fileName = 'Отчет по задачам_' . time() . '.pdf';
          }elseif($type == 2) {
              $result = Settlement::getReport($startDate,$endDate);
              $totalSum = $result[0];
              $data = $result[1];
              $fileName = 'Отчет по взаиморасчетам_' . time() . '.pdf';
              if($view == 3){
                  $chartData = Settlement::formedChartData($data);
                  $chatBase64 = Settlement::generateCh($chartData);
              }
          }else{
              $fileName = 'Отчет по отпускам_' . time() . '.pdf';
              $result = Vacation::getReport($startDate,$endDate,$id);
              $totalSum = $result[0];
              $data = $result[1];
          }

          $pdf = PDF::loadView('reports.pdf_template', [
              'data' => $data,
              'chatBase64' => $chatBase64,
              'total' => $totalSum,
              'type' => $type,
              'view' => $view,
              'startDate' => $startDate,
              'endDate' => $endDate
          ])->setPaper('a4', 'portrait')
              ->setOptions([
                               'tempDir' => public_path(),
                               'logOutputDir' => storage_path('logs/'),
                               'isRemoteEnabled' => true,
                               'isHtml5ParserEnabled' => true,
                               'defaultFont' => 'dejavu sans',
                           ]);

         $pdf->download('report.pdf');
         Storage::disk('downloads')->put($fileName, $pdf->output());
          return json_encode([
              'status' => true
          ]);
      }
}
