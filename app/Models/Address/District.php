<?php

namespace App\Models\Address;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    protected $table = 'id_districts';

    protected $fillable = [
        'city_id',
        'name',
        'meta'
    ];
}
