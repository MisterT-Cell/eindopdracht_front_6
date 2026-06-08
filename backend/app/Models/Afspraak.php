<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Afspraak extends Model
{
    protected $table = 'afspraken';

    protected $fillable = [
        'naam',
        'datum',
        'tijd',
        'dienst',
        'opmerking',
    ];
}
