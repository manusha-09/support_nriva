 
<?php

use App\Models\department;
use App\Models\tickets;

function is_user_committee()
{
$department=department::where('committee_email',Auth::user()->email)->first();
         
             
$datalist=tickets::where('department',$department->department??"")->get();

return true;

         
}