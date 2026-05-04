<?php

namespace App\Observers;

use App\Models\EntityUpdate;
use Illuminate\Database\Eloquent\Model;

class EntityUpdates
{
    /**
     * Handle the HasUpdatesInterface "created" event.
     */
    public function created(Model $entity, string $move='Добавление'): void
    {
        if (backpack_user()->id) {
            EntityUpdate::query()->insert([
               'fio' => backpack_user()->fio,
               'name' =>$entity->name,
               'move' => $move,
                'type' => $entity->getEntityName(),
               'created_at' => now(),]);
        }
    }

    /**
     * Handle the HasUpdatesInterface "updated" event.
     */
    public function updated(Model $entity): void
    {
        $this->created($entity,'Изменение');
    }

    /**
     * Handle the HasUpdatesInterface "deleted" event.
     */
    public function deleted(Model $entity): void
    {
        $this->created($entity,'Удаление');
    }
}
