<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Models\tickets;
use App\Models\Categories;
use App\Models\department;
use App\Models\project;
use App\Models\chapters;
use App\Models\Comment;
use App\Models\Committee;
use App\Models\CommitteeMember;
use App\Http\Controllers\notifications;
use Carbon\Carbon;

use App\Notifications\TicketUpdatedNotification;

class userController extends Controller
{
     public function memberindex()
    { 
 $data=tickets::where('created_by',Auth::user()->id)->get();
$data_list=$data->where('issue_status','pending')->count();
$data_assign=$data->where('issue_status','assigned')->count();
$data_complete=$data->where('issue_status','completed')->count();

$data_incomplete=$data->where('issue_status','inprogress')->count();

// dd($data_list);

        return view('users.userdashborad',compact('data_list','data_assign','data_complete','data_incomplete'));
    }
    public function myticketslist(Request $request)
    {
        $categories = categories::all();
        $department = department::all();
        $projects = project::all();
        $chapters=chapters::all();
        $comments=Comment::with('user','replies')->where('post_id',$ticketlist[0]->id??0)->where('parent_id',0)->get();
         $data=tickets::where('created_by',Auth::user()->id);
          if(!empty($request->priority)){
        $data= $data->where('issue_priority',$request->priority);
       }
       if(!empty($request->status) && $request->status !="All"){
        $data= $data->where('issue_status',$request->status);
       }elseif($request->status !="All"){
      $data= $data->where('issue_status','Pending');
       } 
          $data= $data->get();
     return view('users.mytickets', compact('data','comments','department','projects','chapters','categories'));
    }
//    public function deleteticket($id){

   

//     tickets::find($id)->delete($id);

  

//     return response()->json([

//         'success' => 'Record deleted successfully!'

//     ]);

// }
     public function deleteticket($id)
    {
         $tickets = tickets::findOrFail($id);
        $tickets->delete();
        return redirect()->route('mytickets')->with('success','Ticket has been deleted successfully');
    }
     public function editticket($id)

    { 
        //dd($id);
           $categories = categories::all();
        $department = department::where('status', 1)->whereNull('deleted_at')->orderBy('name')->get();
      
        $ticket = tickets::where('id',$id)->first();
        return view('edittickets', compact('ticket','categories','department'));
    }
     public function updateticket(Request $request, $id = null)
    {  
        //dd($request->all());
      $id = $id ?? $request->input('id');
   
        $ticket = tickets::findOrFail($id);
        // Keep historical assignments, but allow reassignment only to active groups.
        if ($request->filled('department') && $request->department !== $ticket->department) {
            $request->validate(['department' => [
                \Illuminate\Validation\Rule::exists('committees', 'name')->where('status', 1)->whereNull('deleted_at'),
            ]]);
        }
        if ($request->filled('chapter') && (string) $request->chapter !== (string) $ticket->c_id) {
            $request->validate(['chapter' => [
                'integer', \Illuminate\Validation\Rule::exists('chapters', 'id')->where('status', 1)->whereNull('deleted_at'),
            ]]);
        }
        if ($request->exists('department')) {
            $department = $request->filled('department') ? $request->department : null;
            if ($department !== $ticket->department) {
                $ticket->assigned_committee_user_id = null;
                $ticket->assigned_committee_member_id = null;
            }
            $ticket->department = $department;
        }
        $ticket->subject = $request->subject;
        $ticket->category = $request->category;
        // $ticket->project = $request->input('project');
          $ticket->issue_priority = $request->issue_priority;
        $ticket->description = $request->description;
             $ticket->issue_status = $request->issue_status;
             if ($request->exists('chapter')) {
                 $request->validate(['chapter' => 'nullable|integer|exists:chapters,id']);
                 $chapter = $request->filled('chapter') ? $request->chapter : null;
                 if ((string) $chapter !== (string) $ticket->c_id) {
                     $ticket->assigned_chapter_user_id = null;
                     $ticket->assigned_chapter_lead_id = null;
                 }
                 $ticket->c_id = $chapter;
             }
             //dd($request->all());
     
      
           $files = $request->file('files');

           if(($request->hasFile('files'))){

                        $paths = array_values(array_filter(explode(',', (string) $ticket->file_path)));

                if($request->hasFile('files'))
                {
                    foreach ($files as $file) {
                   
                        $path=$file->storeAs('public/images',time().$file->getClientOriginalName());
                        $paths[]=$path;
                    }
                }
        $ticket->file_path=implode(',', $paths);
    }
        //dd($ticket->file_path);
        $ticket->update();
        // dd($ticket);
      
       
      // if(Auth::user()->Role==1){
      //       //dd(Auth::user()->Role)
      //       return redirect()->intended('viewticket?id='.$id.'')->with('success','Ticket has been Updated successfully.');

      //               }else{
      //                    return redirect()->intended('mytickets')->with('success','Ticket has been Updated successfully.');
      //                }
        if ($request->ajax() || $request->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->back()->with('success', 'Ticket has been updated successfully.');
    }
    public function ticketview(Request $request,$id)
    {
//dd($request->id);
     $details = tickets::find($id);
        //dd($details);
        if($details=='')
        {
            echo "<h3>sorry your ticket is deleted in database.</h3>";
        }
        else{
     return view('users.ticketdetails',compact('details'));
 }
      // $response['data'] = $employees;

      // return response()->json($response);
   
    }
    public function withoutlogincreateticket(){
        $categories = categories::all();
        $department = DB::table(config('nriva.database').'.committees')
            ->where('status', 1)
            ->whereNull('deleted_at')
            ->orderBy('name', 'asc')
            ->get();

        $projects = project::all();
         // $chapter = chapters::all();
        $chapter = chapters::where('status', 1)->whereNull('deleted_at')->orderBy('name')->get();

      
        return view('users.home',compact('categories','department','projects','chapter'));

    }
     public function createticketfiles(Request $request)
    {
      // dd($request->all());
        $request->validate([

           
            'subject' => 'required',
            'category' => 'required',
            'department'=>'required',
            'project'=>'required',
             'description' => 'required',
             'name'=>'required',
             'email'=>'required',
             
             ]);
        //dd($request->all());

      //    $path = $request->file('files')->store('images');
      // $request['file_path']=$path;
                        $files = $request->file('files');

                        $paths=[];

                if($request->hasFile('files'))
                {
                    foreach ($files as $file) {
                   
                        $path=$file->storeAs('public/images',time().$file->getClientOriginalName());

                        $paths[]=$path;
                    }
                }
      $request['file_path']=implode(',', $paths);
     
      //dd($request->except(['_token','files']));

    

        $ticket=tickets::create($request->except(['_token','files']));
        $ticket->notify(new TicketUpdatedNotification($ticket));
            //      if(Auth::user()->Role==1){
            // return redirect()->intended('admin')

            //             ->with('success','Ticket has been Created successfully');
            //         }else{
            //             return redirect()->intended('mytickets')

            //             ->with('success','Ticket has been Created successfully');
            //         }

        // }

  

    
        return redirect()->back()->with('success','Ticket has been created successfully.');
    }
   //  public function getUsers($id){

   //   $employees = tickets::find($id);;
   //   dd($employees);
   //   // Fetch all records
   //   $response['data'] = $employees;

   //   return response()->json($response);
   // }

   public function getUserbyid(Request $request){

      $userid = $request->userid;

      $employees = tickets::with(['chapters','users','comments'])->where('id', $userid)->first();

      $comments=Comment::with(['user','replies.user'])->where('post_id',$userid??0)->where('parent_id',0)->orderBy('id','desc')->get();
      
      $statusticket=tickets::where('id', $userid)->first();
       //dd($statusticket);

       $days=[];
        if($statusticket->issue_status == 'completed')
        {
              $days = $statusticket->created_at->diffInDays($statusticket->updated_at).' ' ."days";
            //dd($days);
           
        }else{
           $days = $statusticket->created_at->diffInDays(Carbon::now()).' ' . 'sincedue';
            
        }
        

    $html = view('tickets.comment-list', compact('comments'))->render();


            
      return response()->json(['employees'=> $employees, 'comments'=> $html ,'days'=> $days]);
   }
   public function search_by_id(Request $request)

   {
         $searchid=[]??''; 
        if($request->search)
        {
         $searchid = tickets::where('ticket_unique_id',$request->search)->first();
        
        }
        else{
             echo "<h3>sorry your ticket is deleted in database.</h3>";

        }
        //dd($searchid);
           return view('users.ticketdata',compact('searchid'));
        

   
  

   }
   //  public function image_upload(Request $request)
   // {
   //  $images=$request->images;
   //  //  if ($request->images) {
   //  //    $total=$request->TotalImages;
   //  //     $images = $request->images;
   //  //     for($j=0; $j<$total;$j++){
            
   //  //         $images->storeAs('public/images',time().$images->getClientOriginalName());
   //  //     }
        
   //  // }
   //   $id=$request->id;
   //      dd($images);
   //      tickets::where('id',$id)->update(['file_path'=>$images]);
   //      return response()->json();

   // }
   
    
}
