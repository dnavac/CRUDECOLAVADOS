<?php

namespace App\Models;

use Database\Factories\ClientFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return ClientFactory::new();
    }

    protected $fillable = [
        'name',
        'document',
        'email',
        'phone',
        'address',
    ];

    public function containers()
    {
        return $this->hasMany(Container::class);
    }
}