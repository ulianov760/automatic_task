<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>

        * {
            font-family: "DejaVu Sans", sans-serif !important;
        }
        @page { margin: 120px 50px 50px 50px; }
        header {
            position: fixed;
            top: -100px;
            left: 0;
            right: 0;
            height: 100px;
            text-align: right;
            font-size: 10px;
            border-bottom: 1px solid #ccc;
            font-family: 'DejaVu Sans', sans-serif;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
        }
        .content { font-family: 'DejaVu Sans', sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; page-break-after: auto;}
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        .total-row { font-weight: bold; background: #eee; }
        .row-view-item { margin-bottom: 10px; border-bottom: 1px dashed #ccc; padding: 5px; }
        table, div, p {
            font-family: 'DejaVu Sans', sans-serif;
        }
        thead {
            display: table-header-group;
        }

        tr {
            page-break-inside: avoid;
        }

    </style>
</head>
<body>

<header>

    <div>Общество с ограниченной ответственностью «П-Сейлс»</div>
    <div>НИЖЕГОРОДСКАЯ УЛ, Д. 11, КОМ. 3, НИЖНИЙ НОВГОРОД, РОССИЯ, 603000</div>
    <div>ОГРНИП / ИНН 5257169600</div>
</header>

<div class="content">
    <h3>Отчет за период с {{ $startDate }} по {{ $endDate }}</h3>

@if($view == 1)
        <table>
            <thead>
            @if($type == 1)
                <tr><th>ФИО</th><th>Количество задач</th></tr>
                @elseif($type == 3)
                    <tr>
                        <th>ФИО сотрудника</th>
                        <th>Количество дней отпуска</th>
                    </tr>
                @else
                <tr><th>Компания</th><th>Статус</th><th>Сумма</th></tr>
            @endif
            </thead>
            <tbody>
            @foreach($data as $item)
                <tr>
                    @if($type == 1)
                        <td>{{ $item->fio }}</td>
                        <td>{{ $item->executor_task_count }}</td>
                        @elseif($type == 3)
                            <td>{{ $item->fio }}</td>
                            <td>{{ $item->total_days }}</td>
                    @else
                        <td>{{ $item->company_name }}</td>
                        <td>{{ $item->status_name }}</td>
                        <td>{{ number_format($item->total_sum, 2) }}</td>
                    @endif
                </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr class="total-row">
                <td>ИТОГО:</td>
                @if($type == 1)
                    <td>{{ $total }}</td>
                    @elseif($type == 3)
                        <td>{{ $total }}</td>
                @else
                    <td></td><td>{{ number_format($total, 2) }}</td>
                @endif
            </tr>
            </tfoot>
        </table>
    @elseif($view == 3)
        <div style="text-align: center; margin-top: 20px;">
            <img src="{{ $chatBase64 }}" style="width: 100%; height: auto;">
        </div>
@else
            @foreach($data as $item)
            <div class="row-view-item">
                @if($type == 1)
                    <strong>{{ $item->fio }}</strong>: {{ $item->executor_task_count }} задач.
                    @elseif($type == 3)
                        <strong>{{ $item->fio }}</strong>: {{ $item->total_days }} дн.
                @else
                    <strong>{{ $item->company_name }}</strong> ({{ $item->status_name }}): {{ number_format($item->total_sum, 2) }} руб.
                @endif
            </div>
        @endforeach
        <hr>
                <div style="page-break-inside: avoid;">
                    <hr>
                    <div class="total-row">
                        ОБЩИЙ ИТОГ: {{ $type == 2 ? number_format($total, 2) . ' руб.' : $total . ($type == 3 ? ' дн.' : '') }}
                    </div>
                </div>
    @endif
</div>
</body>
</html>
