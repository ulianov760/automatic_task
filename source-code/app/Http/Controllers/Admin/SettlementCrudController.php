<?php


namespace App\Http\Controllers\Admin;

use App\Http\Requests\SettlementRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class TaskCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class SettlementCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Settlement::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/settlements');
        CRUD::setEntityNameStrings('взаиморасчет', 'Взаиморасчеты');
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
        CRUD::column('name')->label('Название')->searchLogic(
            function ($query, $column, $searchTerm) {
                $query->orWhere('name', 'ilike', '%' . $searchTerm . '%');
            }
        );
        CRUD::column('company_id')->label('Компания')->type('select');
        CRUD::column('employee_id')->label('Отвественный')->type('select');
        CRUD::column('status_id')->label('Статус')->type('select');
        CRUD::column('sum')->label('Сумма')->type('text');
        CRUD::column('date_create')->label('Дата создания')->type('datetime');
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(SettlementRequest::class);

        CRUD::field('name')->label('Название')->type('text');
        CRUD::field([
            'name'  => 'date_create',
            'label' => 'Дата создания',
            'type'  => 'datetime'
        ]);
        CRUD::field(
            [
                'label' => "Отвественный",
                'type' => 'select',
                'name' => 'employee_id',
                'entity' => 'employee',
            ]
        );
        CRUD::field(
            [
                'label' => "Тип операции",
                'type' => 'select',
                'name' => 'type_transaction_id',
                'entity' => 'transaction',
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
                'label' => "Компания",
                'type' => 'select',
                'name' => 'company_id',
                'entity' => 'company',
            ]
        );
        CRUD::field('sum')->label('Сумма')->type('number');
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
