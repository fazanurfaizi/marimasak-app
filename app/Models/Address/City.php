<?php

namespace App\Models\Address;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $table = 'id_cities';

    protected $fillable = [
        'province_id',
        'name',
        'meta'
    ];
}
