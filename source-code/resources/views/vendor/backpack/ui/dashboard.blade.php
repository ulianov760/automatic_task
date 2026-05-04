@extends(backpack_view('blank'))
@section('content')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <h1>Отчеты</h1>
    <div class="container" >
        <label for="status">Выберите тип Отчета:</label>
        <select id="type" name="type">
            <option value="1">по задачам сотрудников</option>
            <option value="2">по взаиморасчетам сотрудников</option>
            <option value="3">по отпускам сотрудников</option>
        </select>
        <label for="view">Выберите вид Отчета:</label>
        <select id="view" name="view">
            <option value="1">табличный</option>
            <option value="2">строковый</option>
            <option value="3" id="diagram" hidden>диаграмма</option>
        </select>
        <label>Выберите дату</label>
        <input type="text" name="daterange" id="daterange"/>
        <label for="status" id="status-label" hidden >Выберите статус Задачи:</label>
        <select id="status" name="status" hidden>
        </select>
        <button type="button" class="btn btn-primary" onclick="send()">Создать отчет</button>
    </div>

    <script >
        const typeSelect = document.getElementById("type");
        const statusSelect = document.getElementById("status");
        const statusLabel = document.getElementById("status-label");
        const viewSelect = document.getElementById("view");
        const diagram = document.getElementById('diagram');
        let startDate = '';
        let endDate = '';
        let statuses = '';
        let statusesVacation = '';
        let select = document.getElementById('status');

        function updateVisibility() {
            if (typeSelect.value === "1") {
                statusLabel.removeAttribute("hidden");
                statusSelect.removeAttribute("hidden");
                diagram.setAttribute("hidden", "true");
                select.length = 0;
                formedSelect(statuses);
            } else if (typeSelect.value === "2") {
                statusLabel.setAttribute("hidden", "true");
                statusSelect.setAttribute("hidden", "true");
                diagram.removeAttribute("hidden");
            }else{
                statusLabel.removeAttribute("hidden");
                statusSelect.removeAttribute("hidden");
                diagram.setAttribute("hidden", "true");
                select.length = 0;
                formedSelect(statusesVacation);
            }
        }

        function formedSelect(object){
            if(typeSelect.value === "1"){
                var li = document.createElement('option');
                li.value = 0;
                var a = document.createElement('a');
                $(a).appendTo(li);
                $(a).text('Все');
                $(li).appendTo(select);
            }
            for (var key in object) {
                var li = document.createElement('option');
                li.value = object[key]['id'];
                var a = document.createElement('a');
                $(a).appendTo(li);
                $(a).text(object[key]['name']);
                $(li).appendTo(select);
            }
        }

        typeSelect.addEventListener("change", updateVisibility);
        $('#daterange').on('apply.daterangepicker', function(ev, picker) {
            startDate = picker.startDate.format('YYYY-MM-DD');
            endDate = picker.endDate.format('YYYY-MM-DD');
        });
        function send(){
            var select = document.getElementById('status');
            $.ajax({
                url: '/api/create-report',
                type: 'POST',
                data: {
                    startDate: startDate,
                    endDate: endDate ,
                    id: select.options[select.selectedIndex].value,
                    type: typeSelect.value,
                    view: viewSelect.value,
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    const obj = JSON.parse(data);
                    if(obj.status){
                        alert('Отчет успешно сформирован!')
                    }
                    if(!obj.status){
                        alert(`Ошибка при формировании отчета: ${obj.error} `)
                    }
                }
            });
        }
        //
        reloadData();
        updateVisibility();
        $('input[name="daterange"]').daterangepicker({
            showDropdowns: true,
            buttonClasses: 'btn',
            applyButtonClasses: 'btn-primary',
            cancelButtonClasses: 'btn-default',
            showWeekNumbers: true,
            locale: {
                format: "DD.MM.YYYY",
                separator: " - ",
                applyLabel: "Применить",
                cancelLabel: "Отмена",
                fromLabel: "От",
                toLabel: "До",
                customRangeLabel: "Свой интервал",
                weekLabel: "Н",
                daysOfWeek: ["Вс", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб"],
                monthNames: [
                    "Январь", "Февраль", "Март", "Апрель", "Май", "Июнь",
                    "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"
                ],
                firstDay: 1
            }
        });

        function reloadData(){
            $.ajax({
                url: '/api/get-data',
                type: 'GET',
                success: function(data) {
                    document.getElementById('status').innerHTML = '';
                    const obj = JSON.parse(data);
                    if(obj.statusesVacation.length > 0){
                        statusesVacation = obj.statusesVacation;
                    }
                    if(obj.statuses.length > 0) {
                        statuses = obj.statuses;
                        formedSelect(statuses);
                    }
                }
            });
        }


    </script>
    <style>
        .table-wrapper {
            max-height: 200px;
            overflow: auto;
            display:inline-block;
        }
        .table-earnings {
            background: #F3F5F6;
        }
        .container {
            margin-bottom: 20px;
        }
        .card {
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.15);
        }

        .card-header {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .card-body {
            background-color: white;
        }

        .list-group-item {
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .list-group-item:hover {
            background-color: #f0f0f0;
        }

        .scrollbar-inner {
            padding-right: 10px;
        }

        #table-last-edit {
            width: 100%;
            border-spacing: 0;
            border-collapse: collapse;
        }

        #table-last-edit th,
        #table-last-edit td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #eaeaea;
        }

        @media (max-width: 768px) {
            body {
                font-size: 14px;
            }
            .card {
                margin-bottom: 10px;
            }
        }

        input[name="daterange"] {
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ced4da;
            font-size: 16px;
            line-height: 1.5;
        }

        input[name="daterange"]:hover {
            border-color: #80bdff;
        }

        input[name="daterange"]:focus {
            outline: none;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
    </style>
@endsection
