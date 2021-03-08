<?php

namespace Modules\Employee\Entities;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    protected $fillable = [];
    protected $table = 'role_user';
}
