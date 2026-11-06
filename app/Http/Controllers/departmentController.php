<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

use App\Models\Categories;
use App\Models\department;
use App\Models\project;
use App\Models\tickets;
use App\Models\Committee;
use App\Models\CommitteeMember;
use App\Models\User;


class departmentController extends Controller
{
    public function department(Request $request)
    {

//dd($request);
        
        if ($request->search_committee) 
        {
       $departments = department::where('department', 'like', '%' . $request->search_committee . '%')->get();
        } else {
       
   
        $departments = department::orderBy('id','desc')->get();
        }
        return view('department.departmentmenu',compact('departments'));
    }
    public function departmentcreate()
    {
        return view('department.departmentmenu');
    }

     public function departmentstore(Request $request)
    {
//dd($request->all());
        $request->validate([
            'department' => 'required',
            
        ]);
        
         department::create($request->post());

        
        return redirect()->route('department')->with('success','Department has been created successfully.');
    }
    public function departmentedit(Request $request, $id)
    { 
        $department=department::whereId($id)->first();
        return view('department',compact('department'));
    }

   

    
    public function departmentupdate(Request $request, $department_id)
    {
        $list = department::whereId($request->department_id)->first();
  
        $department = $request->validate([
            'department' => 'required',
           'committee_email' => 'required',

            
            
        ]);
        
     
         department::whereId($request->department_id)->update($department);
         tickets::where('department',$list->department)->update(['department' => $request->department]);
         

       return redirect()->route('department')->with('success','Department Has Been updated 
        successfully');
    }

  
    public function departmentdestroy($id)
    {
         $departments = department::findOrFail($id);
        $departments->delete();
        return redirect()->route('department')->with('success','Committee deleted successfully');
    }


            public function status(Request $request){
         $did = $request->id;

         $list = department::where('id', $did)->first();

         if($department->status == 0){
          $status = 1;
         } else
         {
          $status = 0;
        }
        department::where('id', $did)->update(['status'=> $status]);

        return response()->json('success');
        }
public function commiitteedata(Request $request)
{
    $user = Auth::user();

   
    $userCommitteeIds = DB::table(config('nriva.database').'.committeemembers')
        ->where('user_id', $user->id)
        ->where('status', 1)
        ->pluck('committee_id');

   
    $userCommittees = DB::table(config('nriva.database').'.committees')
        ->whereIn('id', $userCommitteeIds)
        ->where('status', 1)
        ->pluck('name')
        ->toArray();

   
    $datalist = DB::table('tbl_ticketing_system_tickets')
        ->whereIn('department', $userCommittees);

   
    if (!empty($request->priority)) {
        $datalist->where('issue_priority', $request->priority);
    }

    
    if (!empty($request->status) && $request->status != 'All') {
        $datalist->where('issue_status', $request->status);
    } else {
        $datalist->where('issue_status', 'Pending');
    }

    $datalist = $datalist->orderBy('id', 'desc')->get();

    return view('department.user_committee', compact('datalist'));
}

//         public function commiitteedata(Request $request){

//     $department = department::where('committee_email', Auth::user()->email)->first();

//     $datalist = tickets::where('department', $department->department ?? "");

//     if(!empty($request->priority)){
//         $datalist = $datalist->where('issue_priority', $request->priority);
//     }

//     if(!empty($request->status) && $request->status != "All"){
//         $datalist = $datalist->where('issue_status', $request->status);
//     }
//     elseif($request->status != "All"){
//         $datalist = $datalist->where('issue_status', 'Pending');
//     }

//     $datalist = $datalist->get();

//     return view('department.user_committee', compact('datalist'));
// }
}
