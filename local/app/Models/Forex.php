<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Forex extends Model
{
    protected $fillable = [
        'exchange_date', 'iso3', 'unit', 'name', 'buy', 'sell'
    ];
}
