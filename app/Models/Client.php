<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
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
