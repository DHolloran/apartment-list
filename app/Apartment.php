<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    protected $fillable = [
        'name',
        'order',
        'addressLine1',
        'addressLine2',
        'city',
        'state',
        'zip',
        'notes',
        'price',
        'parkingPrice',
        'deposit',
        'user_id',
    ];

    /**
     * Apartments that belong to an user.
     *
     * @return  \Illuminate\Database\Eloquent\Relaions\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
