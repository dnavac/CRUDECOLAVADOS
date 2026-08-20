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

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}