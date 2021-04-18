<?php

namespace App\Models\Address;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Village extends Model
{
    use HasFactory;

    protected $table = 'id_villages';

    protected $fillable = [
        'disctrict_id',
        'name',
        'meta'
    ];
}
