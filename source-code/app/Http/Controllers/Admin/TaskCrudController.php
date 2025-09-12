<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\TaskRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class TaskCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class TaskCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Task::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/tasks');
        CRUD::setEntityNameStrings('задачу', 'Задачи');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::addClause('whereHas', 'group', function ($query) {
            $query->select('id')->whereHas('employee', function ($q) {
                $q->where('employees.id',backpack_user()->id);
            });
        });
        CRUD::column('id')->label('ID');
        CRUD::column('name')->label('Название')->searchLogic(
            function ($query, $column, $searchTerm) {
                $query->orWhere('name', 'ilike', '%' . $searchTerm . '%');
            }
        );
        CRUD::column('author_task')->label('Постановщик')->type('select');
        CRUD::column('executor_task')->label('Отвественный')->type('select');
        CRUD::column('priority_id')->label('Приоритет')->type('select');
        CRUD::column('status_id')->label('Статус')->type('select');
        CRUD::column('group_id')->label('Группа')->type('select');
        CRUD::column('date_create')->label('Дата создания')->type('datetime');
        CRUD::column('date_finish')->label('Дата завершения')->type('datetime');
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(TaskRequest::class);

        CRUD::field('name')->label('Название')->type('text');
        CRUD::field('description')->label('Описание')->type('textarea');
        CRUD::field([
            'name'  => 'date_create',
            'label' => 'Дата создания',
            'type'  => 'datetime'
        ]);
        CRUD::field([
            'name'  => 'date_finish',
            'label' => 'Дата завершения',
            'type'  => 'datetime'
        ]);
        CRUD::field(
            [
                'label' => "Отвественный",
                'type' => 'select',
                'name' => 'executor_id',
                'entity' => 'executor_task',
            ]
        );
        CRUD::field(
            [
                'label' => "Постановщик",
                'type' => 'select',
                'name' => 'author_id',
                'entity' => 'author_task',
            ]
        );
        CRUD::field(
            [
                'label' => "Группа",
                'type' => 'select',
                'name' => 'group_id',
                'entity' => 'group',
            ]
        );
        CRUD::field(
            [
                'label' => "Статус",
                'type' => 'select',
                'name' => 'status_id',
                'entity' => 'status',
            ]
        );
        CRUD::field(
            [
                'label' => "Приоритет",
                'type' => 'select',
                'name' => 'priority_id',
                'entity' => 'priority',
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
        $this->setupCreateOperation();
    }
}
