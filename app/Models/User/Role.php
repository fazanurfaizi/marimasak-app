<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends \Spatie\Permission\Models\Role
{
    use HasFactory;

    public $guard_name = 'api';
}
