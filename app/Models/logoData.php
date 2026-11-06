<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class logoData extends Model
{
	protected $table='tbl_ticketing_system_logoData';
  
    protected $fillable = ['name', 'logoimage'];
}
