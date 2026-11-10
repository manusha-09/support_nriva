<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class chapters extends Model
{
  protected $table='chapters';

    // Ticket details and edit forms use these aliases in their JSON responses.
    protected $appends = ['chapter_id', 'chapter_name', 'chapter_email'];

    public function getChapterIdAttribute() { return $this->attributes['id']; }
    public function getChapterNameAttribute() { return $this->attributes['name']; }
    public function getChapterEmailAttribute() { return $this->attributes['email']; }

    protected $fillable = ['chapter_name','chapter_email'];

   
    
}
