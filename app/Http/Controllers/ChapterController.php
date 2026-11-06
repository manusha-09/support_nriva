<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\chapters;
use DB;

class ChapterController extends Controller

{

   public function viewchapter()

   {
      $chapters=chapters::get();
      //dd($chapters);
     return view('chapters.chapters',compact('chapters'));
   }
   public function chaptercreate(Request $request)
   {
      //dd($request->all());
       chapters::create($request->except(['_token']));

        
        return redirect()->route('chapters')->with('success','Chapter created successfully.');
   }
   public function chapterdestroy($id)
   {
      $chapters = chapters::where('chapter_id',$id);
        $chapters->delete();
        return redirect()->route('chapters')->with('success','Chapter deleted successfully');
   }
    public function chapterupdate(Request $request, $chapter_id)
    {
        $list = chapters::where('chapter_id',$request->chapter_id)->first();
  
        $chapter = $request->validate([
            'chapter_name' => 'required',
           'chapter_email' => 'required',
   
        ]);
        
     
         chapters::where('chapter_id',$request->chapter_id)->update($chapter);
         // tickets::where('department',$list->department)->update(['department' => $request->department]);
         

       return redirect()->route('chapters')->with('success','Chapter Has Been updated 
        successfully');
    }

  

   }
