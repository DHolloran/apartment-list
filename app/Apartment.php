<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    protected $fillable = [
        'name',
        'addressLine1',
        'addressLine2',
        'city',
        'state',
        'zip',
        'notes',
        'price',
        'parkingPrice',
        'deposit',
    ];
}
