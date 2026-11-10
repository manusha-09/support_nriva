<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\project;
use DataTables;

class projectController extends Controller
{
    public function projects()
    {
        $projects = project::orderBy('id','desc')->paginate(10);
        return view('projects',compact('projects'));
    }
    // public function projectcreate()
    // {
    //     return view('department.departmentmenu');
    // }

     public function projectstore(Request $request)
    {
        // dd($request)->all();
        $request->validate([
            'name' => 'required',
            
        ]);
        // dd($request)->all();
        
         project::create($request->post());

        // dd("hi");
        return redirect()->route('projects')->with('success','Project has been created successfully.');
    }
    // public function departmentedit(Request $request, $id)
    // { 
    //     $department=department::whereId($id)->first();
    //     return view('department',compact('department'));
    // }

   

    
    public function projectupdate(Request $request, $project_id)
    {
  
        $projects = $request->validate([
            'name' => 'required',
            
        ]);
        
     
         project::whereId($request->project_id)->update($projects);
       return redirect()->route('projects')->with('success','Project Has Been updated successfully');
    }

  
    public function projectdestroy($id)
    {
         $projects = project::findOrFail($id);
        $projects->delete();
        return redirect()->route('projects')->with('success','Project has been deleted successfully');
    }


            public function status(Request $request){

         $request->validate(['status' => 'required|in:0,1']);
         $did = $request->id;


         $list = project::where('id', $did)->firstOrFail();

         $status = (int) $request->status;
        project::where('id', $did)->update(['status'=> $status]);

        return response()->json(['success' => true, 'message' => 'updated successfully', 'status' => $status]);
        }
}
