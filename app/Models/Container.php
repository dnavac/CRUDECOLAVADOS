<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Container extends Model
{
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
