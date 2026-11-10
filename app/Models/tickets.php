<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class tickets extends Model
{
    protected $table='tbl_ticketing_system_tickets';
    use  Notifiable;
    protected $fillable = ['subject','category','issue_priority','department','project','description','file_path','created_by','name','email','issue_status','c_id','committee','ticket_unique_id','created_at','updated_at','ticket_created_by_id'];


     public function chapters()
    {
        return $this->belongsTo('App\Models\chapters','c_id','id');
    }
     public function users()
    {
        return $this->belongsTo('App\Models\User','created_by');
    }
     public function comments()
    {
        return $this->hasMany('App\Models\Comment','post_id');
    }
}
