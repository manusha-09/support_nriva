<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $table = 'tbl_ticketing_system_categories';

    protected $fillable = ['name', 'email', 'address'];
}