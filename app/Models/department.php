<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class department extends Model
{
protected $table = 'tbl_ticketing_system_departments';
    
   
    protected $fillable = ['department','committee_email'];
    // public function tickets()
    // {
    //   return $this->hasMany('App\Models\tickets','department','department')->where('department','');
    // }
   
    public function pending_tickets($value='')
    {
       return $this->hasMany('App\Models\tickets','department','department')->where('issue_status','pending');
    }
    public function tickets_assigned($value='')
    {
       return $this->hasMany('App\Models\tickets','department','department')->where('issue_status','assigned');
    }
    public function tickets_completed($value='')
    {
       return $this->hasMany('App\Models\tickets','department','department')->where('issue_status','completed');
    }
    public function tickets_in_progress($value='')
    {
       return $this->hasMany('App\Models\tickets','department','department')->where('issue_status','inprogress');
    }
}
