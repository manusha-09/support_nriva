<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class chapters extends Model
{
  protected $table='tbl_ticketing_system_chapter';

    protected $fillable = ['chapter_name','chapter_email'];

   
    
}
