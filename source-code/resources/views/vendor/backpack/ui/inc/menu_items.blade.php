{{-- This file is used for menu items by any Backpack v6 theme --}}
@include('backpack.language-switcher::language-switcher')
<li class="nav-item">
    <a class="nav-link"
       href="javascript:void(0)"
       role="button"
       data-bs-toggle="popover"
       data-bs-placement="right"
       data-bs-trigger="hover focus"
       title="Справка о программе"
       data-bs-content="CRM система предназначеная для автоматизации рабочих процессов. В реализованы возможности: формирования отчетов, управление проектам, а также ведение отпусков">
        <i class="nav-icon la la-question-circle"></i>
        <span>Справка</span>
    </a>
</li>

@if (backpack_user()->hasRoles([App\Helpers\Helper::ADMIN, App\Helpers\Helper::SUPER_MANAGER]))
    <x-backpack::menu-item title="Отчет" icon="la la-chart-bar" :link="backpack_url('/dashboard')"/>
     <x-backpack::menu-item title="Команды" icon="la la-users-cog" :link="backpack_url('commands')"/>
    <x-backpack::menu-item title="Группы" icon="la la-layer-group" :link="backpack_url('groups')"/>
    <x-backpack::menu-item title="Сотрудники" icon="la la-id-card" :link="backpack_url('employees')"/>
    <x-backpack::menu-item title="Взаиморасчеты" icon="la la-hand-holding-usd" :link="backpack_url('settlements')"/>
    <x-backpack::menu-item title="Приоритеты" icon="la la-exclamation-circle" :link="backpack_url('priorities')"/>
    <x-backpack::menu-item title="Статусы" icon="la la-tasks" :link="backpack_url('statuses')"/>
@endif
<x-backpack::menu-item title="Отпуска" icon="la la-umbrella-beach" :link="backpack_url('vacations')"/>
<x-backpack::menu-item title="Должности" icon="la la-briefcase" :link="backpack_url('posts')"/>

@if (backpack_user()->hasRoles([App\Helpers\Helper::ADMIN]))
    <li class="nav-item">
        <a class="nav-link" href="{{ backpack_url('backup') }}">
            <i class="nav-icon la la-database"></i>
            <span>Бекап БД</span>
        </a>
    </li>
    <x-backpack::menu-item title="Роли" icon="la la-user-shield" :link="backpack_url('roles')"/>
    <x-backpack::menu-item title="Логирование" icon="la la-history" :link="backpack_url('entities')"/>
    <x-backpack::menu-item title="Компании" icon="la la-city" :link="backpack_url('companies')"/>
    <x-backpack::menu-item title="Статусы оплаты" icon="la la-money-check-alt" :link="backpack_url('payment-statuses')"/>
    <x-backpack::menu-item title="Статусы отпуска" icon="la la-calendar-check" :link="backpack_url('vacation-statuses')"/>
    <x-backpack::menu-item title="Типы операций" icon="la la-exchange-alt" :link="backpack_url('type-transactions')"/>
@endif

<x-backpack::menu-item title="Задачи" icon="la la-clipboard-list" :link="backpack_url('')"/>
<script>

    document.addEventListener('DOMContentLoaded', function () {
        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
        var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl)
        })
    })
</script>
