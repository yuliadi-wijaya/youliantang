<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleAccess extends Model
{
    use HasFactory;

    protected $table = "role_access";

    protected $fillable = [
        "access_code"
    ];
}
