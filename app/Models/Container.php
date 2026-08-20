<?php

namespace App\Models;

use Database\Factories\ContainerFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Container extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return ContainerFactory::new();
    }

    protected $fillable = [
        'code',
        'type',
        'capacity',
        'status',
        'client_id',
    ];

    //Un contenedor pertenece a un cliente(N:1)
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
