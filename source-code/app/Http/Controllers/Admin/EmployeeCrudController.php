<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\EmployeeRequest;
use App\Http\Requests\EmployeesCreateRequest;
use App\Http\Requests\EmployeesUpdateRequest;
use App\Models\Group;
use App\Models\Role;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Hash;

/**
 * Class EmployeeCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class EmployeeCrudController extends CrudController
{
    use CreateOperation { create as traitCreate;}
    use DeleteOperation;
    use ListOperation;
    use ShowOperation;
    use UpdateOperation {update as traitUpdate;}

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Employee::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/employees');
        CRUD::setEntityNameStrings('сотрудника', 'Сотрудники');
    }

    protected function setupShowOperation()
    {
        $this->setupListOperation();
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('id')->label('ID');
        CRUD::column('fio')->label('ФИО')->searchLogic(
            function ($query, $column, $searchTerm) {
                $query->orWhere('fio', 'ilike', '%' . $searchTerm . '%');
            }
        );
        CRUD::column('email')->label('Почта')->searchLogic(
            function ($query, $column, $searchTerm) {
                $query->orWhere('email', 'ilike', '%' . $searchTerm . '%');
            }
        );
        CRUD::column('age')->label('Возраст');
        CRUD::column('post_id')->label('Должность')->type('select');
        CRUD::column('team_id')->label('Команда')->type('select');

    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(EmployeesCreateRequest::class);

        CRUD::field('fio')-> label('ФИО')->type('text');
        CRUD::field('email')->label('Почта')->type('email');
        CRUD::field('password')->label('Пароль')->type('password');
        CRUD::field('age')->label('Возраст')->type('number');
        CRUD::field( [
            'name'  => 'sex',
            'label' => 'Пол',
            'type'  => 'enum',
            'enum_function' => 'readableText',
            'enum_class' => 'App\Enums\Gender'
        ]);

        CRUD::field(
            [
                'label' => "Должность",
                'type' => 'select',
                'name' => 'post_id',
                'entity' => 'post',
            ]
        );
        CRUD::field(
            [
                'label' => "Команда",
                'type' => 'select',
                'name' => 'team_id',
                'entity' => 'team',
            ]
        );
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {

        CRUD::setValidation(EmployeesUpdateRequest::class);

        $employee = $this->crud->getCurrentEntry();

        CRUD::field('fio')->label('ФИО')->type('text');
        CRUD::field('email')->label('Почта')->type('email');
        CRUD::field('password')->label('Пароль')->type('password')->default($employee->password);
        CRUD::field('age')->label('Возраст')->type('number');
        CRUD::field( [
            'name'  => 'sex',
            'label' => 'Пол',
            'type'  => 'enum',
            'enum_function' => 'readableText',
            'enum_class' => 'App\Enums\Gender'
        ]);

        CRUD::field([
            'name' => 'employee_roles',
            'type' => 'checklist',
            'label' => 'Роли',
            'entity' => 'employee_roles',
            'pivot' => true,
            'attribute' => 'name',
            'model' => Role::class,
            'number_of_columns' => 4,
        ]);

        CRUD::field([
            'name' => 'employee_groups',
            'type' => 'checklist',
            'label' => 'Группы',
            'entity' => 'employee_groups',
            'pivot' => true,
            'attribute' => 'name',
            'model' => Group::class,
            'number_of_columns' => 4,
        ]);

        CRUD::field(
            [
                'label' => "Должность",
                'type' => 'select',
                'name' => 'post_id',
                'entity' => 'post',
            ]
        );
        CRUD::field(
            [
                'label' => "Команда",
                'type' => 'select',
                'name' => 'team_id',
                'entity' => 'team',
            ]
        );
    }

    public function create()
    {
        /** @var \Illuminate\Http\Request $request */
        $request = CRUD::getRequest();
        $request->request->set('password', Hash::make($request->input('password')));
        CRUD::setRequest($request);
        $response = $this->traitCreate();
        return $response;
    }

    public function update()
    {
        CRUD::setRequest(CRUD::validateRequest());

        /** @var \Illuminate\Http\Request $request */
        $request = CRUD::getRequest();

        if ($request->input('password')) {
            $request->request->set('password', Hash::make($request->input('password')));
        } else {
            $request->request->remove('password');
        }

        CRUD::setRequest($request);
        CRUD::unsetValidation();
        $response = $this->traitUpdate();
        return $response;
    }
}
