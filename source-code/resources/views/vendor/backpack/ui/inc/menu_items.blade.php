{{-- This file is used for menu items by any Backpack v6 theme --}}
@include('backpack.language-switcher::language-switcher')
<x-backpack::menu-item title="Отчет" icon="la la-globe" :link="backpack_url('/dashboard')"/>
@if (backpack_user()->hasRoles([App\Helpers\Helper::ADMIN,App\Helpers\Helper::SUPER_MANAGER,App\Helpers\Helper::FINANCE_MANAGER]))<x-backpack::menu-item title="Команды" icon="la la-globe" :link="backpack_url('')"/>
<x-backpack::menu-item title="Группы" icon="la la-file" :link="backpack_url('groups')"/>
<x-backpack::menu-item title="Сотрудники" icon="la la-user" :link="backpack_url('employees')"/>
@endif
<x-backpack::menu-item title="Должности" icon="la la-group" :link="backpack_url('posts')"/>
@if (backpack_user()->hasRoles([App\Helpers\Helper::ADMIN]))
<x-backpack::menu-item title="Роли" icon="la la-user-tag" :link="backpack_url('roles')"/>
@endif
<x-backpack::menu-item title="Приоритеты" icon="la la-file" :link="backpack_url('priorities')"/>
<x-backpack::menu-item title="Статусы" icon="la la-file-alt" :link="backpack_url('statuses')"/>
<x-backpack::menu-item title="Задачи" icon="la la-file-alt" :link="backpack_url('tasks')"/>
