<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TypeTransaction extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $fillable = [
        'id',
        'name'
    ];

    public $timestamps = false;

    public function settlement(): HasMany
    {
        return $this->hasMany(Settlement::class,'company_id');
    }

    public function delete()
    {
        if($this->settlement()->where('type_transaction_id',$this->attributes['id'])->exists()){
            return false;
        }
        TypeTransaction::where('id',$this->attributes['id'])->delete();
        return true;
    }
}
