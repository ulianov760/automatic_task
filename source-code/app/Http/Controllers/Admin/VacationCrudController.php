<?php


namespace App\Http\Controllers\Admin;

use App\Http\Requests\SettlementRequest;
use App\Helpers\Helper;
use App\Http\Requests\VacationRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\CRUD\app\Library\Widget;

/**
 * Class TaskCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class VacationCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Vacation::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/vacations');
        CRUD::setEntityNameStrings('отпуск', 'Отпуска');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        Widget::add([
                        'type'     => 'view',
                        'view'     => 'vendor.backpack.ui.widgets.help_vacation_button',
                        'section'  => 'before_content',
                    ]);
        $user = backpack_user();
        if (!$user->hasRoles([Helper::ADMIN, Helper::SUPER_MANAGER]))
        {
            $this->crud->addClause('where', 'employee_id', '=', $user->id);
        }
        CRUD::column('id')->label('ID');
        CRUD::column('name')->label('Название')->searchLogic(
            function ($query, $column, $searchTerm) {
                $query->orWhere('name', 'ilike', '%' . $searchTerm . '%');
            }
        );
        CRUD::column('employee_id')->label('ФИО сотрудника')->type('select');
        CRUD::column('status_id')->label('Статус')->type('select');
        CRUD::column('date_start')->label('Дата начала')->type('date');
        CRUD::column('date_finish')->label('Дата завершения')->type('date');

    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(VacationRequest::class);

        CRUD::field('name')->label('Название')->type('text');
        CRUD::field([
            'name'  => 'date_start',
            'label' => 'Дата начала',
            'type'  => 'date'
        ]);
        CRUD::field([
            'name'  => 'date_finish',
            'label' => 'Дата завершения',
            'type'  => 'date'
        ]);
        CRUD::field(
            [
                'label' => "Статус",
                'type' => 'select',
                'name' => 'status_id',
                'entity' => 'status',
            ]
        );
        if (!backpack_user()->hasRoles([Helper::ADMIN, Helper::SUPER_MANAGER]))
        {
            CRUD::field([
                            'name'  => 'employee_name_display',
                            'label' => 'ФИО сотрудника',
                            'type'  => 'text',
                            'value' => backpack_user()->fio,
                            'attributes' => ['readonly' => 'readonly', 'disabled' => 'disabled']
                        ]);
            CRUD::field([
                            'name'  => 'employee_id',
                            'type'  => 'hidden',
                            'value' => backpack_user()->id,
                        ]);

            CRUD::modifyField('status_id', [
                'attributes' => [
                    'readonly' => 'readonly',
                    'style' => 'pointer-events: none; background-color: #e9ecef;',
                ],
                'hint' => 'Статус заявки будет изменен после ее рассмотрения',
            ]);
        }else{
            CRUD::field(
                [
                    'label' => "ФИО сотрудника",
                    'type' => 'select',
                    'name' => 'employee_id',
                    'entity' => 'employee',
                ]
            );
        }
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
