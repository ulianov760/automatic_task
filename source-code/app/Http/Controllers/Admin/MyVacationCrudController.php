<?php


namespace App\Http\Controllers\Admin;

use App\Http\Requests\VacationRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Hash;

/**
 * Class TaskCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class MyVacationCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { create as traitCreate;}
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation {update as traitUpdate;}
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
        CRUD::setRoute(config('backpack.base.route_prefix') . '/my-vacations');
        CRUD::setEntityNameStrings('отпуск', 'Мои отпуска');
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
        CRUD::column('status_id')->label('Статус')->type('select');
        CRUD::column('date_start')->label('Дата начала')->type('datetime');
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
        CRUD::setValidation(VacationRequest::class);

        CRUD::field('name')->label('Название')->type('text');
        CRUD::field([
            'name'  => 'date_start',
            'label' => 'Дата начала',
            'type'  => 'datetime'
        ]);
        CRUD::field([
            'name'  => 'date_finish',
            'label' => 'Дата завершения',
            'type'  => 'datetime'
        ]);
        CRUD::field(
            [
                'label' => "Статус",
                'type' => 'select',
                'name' => 'status_id',
                'entity' => 'status',
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

    public function create()
    {
        /** @var \Illuminate\Http\Request $request */
        $request = CRUD::getRequest();
        $request->request->set('employee_id', backpack_user()->id);
        dd($request->request);exit();
        CRUD::setRequest($request);
        $response = $this->traitCreate();
        return $response;
    }

    public function update()
    {
        /** @var \Illuminate\Http\Request $request */
        $request = CRUD::getRequest();
        $request->request->set('employee_id', backpack_user()->id);
        CRUD::setRequest($request);
        $response = $this->traitUpdate();
        return $response;
    }
}
