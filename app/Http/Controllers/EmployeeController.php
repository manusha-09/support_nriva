<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\logoData;
use DB;

class EmployeeController extends Controller
{
    public function role()
    {
        return view("Role.role");
    }
    public function employee()
    {
        return view("Role.create_employee");
    }
     public function employeelist()
    {
        return view("Role.employee_list");
    }
    public function Editlogo()

    {
        return view("Role.change_logo");

    }
     public function updatelogo(Request $request)
    {
      //dd($request->all());
    
       
        if($request->hasFile('logoimages')){
            $file= $request->file('logoimages');
             $path=$file->storeAs('public/images',time().$file->getClientOriginalName());
            //dd($path);
              $request['logoimage']=$path;           
        }
        DB::table('logoData')->where('id', '1')->update($request->except(['_token','logoimages']));

        return redirect()->back()->with('success','Logo Updated Successfully.');


}
}
