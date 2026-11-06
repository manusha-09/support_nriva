<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Categories;
use App\Models\department;
use App\Models\project;
use App\Models\tickets;
use App\Models\User;
use App\Models\chapters;
use App\Http\Controllers\notifications;
use Carbon\Carbon;
use Mail;
use App\Models\Comment;
use App\Mail\MailNotify;
use App\Mail\committeemail;
use App\Models\Committee;
use App\Models\CommitteeMember;
use App\Notifications\TicketUpdatedNotification;
use Auth;
use Session;



class AdminController extends Controller
{

    // $this->middleware('CheckRole');
    
 public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {  
      if (!Auth::check() || Auth::user()->id != 1270) {
        return redirect('/member')->with('error', 'Unauthorized access');
    } 
        $completedcount=tickets::select(DB::Raw('count(*) as total'),'issue_status')->groupby("issue_status")->pluck('total','issue_status')->toArray();
        $counttickets=DB::table('tbl_ticketing_system_notifications')->whereNull('read_at')->get();

        $list = department::get();
        //dd(count($list[0]->pending_tickets));


        return view('admin',compact('completedcount','counttickets','list'));
    }
   

    public function index1()
    {
        $categories = categories::orderBy('id','desc')->paginate(10);
        return view('categories.tickets',compact('categories'));
    }

    /**
    // * Show the form for creating a new resource.
    // *
    // * @return \Illuminate\Http\Response
    // */
    public function create()
    {
        return view('categories.create');
    }

    // /**
    // * Store a newly created resource in storage.
    // *
    // * @param  \Illuminate\Http\Request  $request
    // * @return \Illuminate\Http\Response
    // */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            
        ]);
        
        categories::create($request->post());

        
        return redirect()->route('tickets')->with('success','Category has been created successfully.');
    }

    // /**
    // * Display the specified resource.
    // *
    // * @param  \App\company  $company
    // * @return \Illuminate\Http\Response
    // */
    // public function show(Company $company)
    // {
    //     return view('companies.show',compact('company'));
    // }

    // /**
    // * Show the form for editing the specified resource.
    // *
    // * @param  \App\Company  $company
    // * @return \Illuminate\Http\Response
    // */
    public function edit(Request $request, $id)
    { 
        $categories=categories::whereId($id)->first();
        return view('categories.edit',compact('categories'));
    }

    // /**
    // * Update the specified resource in storage.
    // *
    // * @param  \Illuminate\Http\Request  $request
    // * @param  \App\company  $company
    // * @return \Illuminate\Http\Response
    // */
    public function update(Request $request, $category_id)
    {
        $list=categories::whereId($request->category_id)->first();
        //dd($list);
        $category = $request->validate([
            'name' => 'required',
            
        ]);
     
      //dd($category);
         categories::whereId($request->category_id)->update($category);
         tickets::where('category',$list->name)->update(['category' => $request->name]);

       return redirect()->route('tickets')->with('success','Category Has Been updated 
        successfully');
    }

   
    public function destroy($id)
    {
         $category = categories::findOrFail($id);
        $category->delete();
        return redirect()->route('tickets')->with('success','Category has been deleted successfully');
    }
   
    public function projects()
    {
        $categories = categories::orderBy('id','desc')->paginate(5);
        return view('projects',compact('categories'));
    }

 public function createticket()
{
    $categories = categories::all();
    $department = DB::table(config('nriva.database').'.committees')
        ->where('status', 1)
        ->orderBy('name', 'asc')
        ->get();
    $projects = project::all();
    $chapter = chapters::all();

    $userCommitteeIds = DB::table(config('nriva.database').'.committeemembers')
        ->where('user_id', Auth::id())
        ->where('status', 1)
        ->pluck('committee_id');
    $userCommittees = DB::table(config('nriva.database').'.committees')
        ->whereIn('id', $userCommitteeIds)
        ->where('status', 1)
        ->orderBy('name', 'asc')
        ->get();

    return view('createticket', compact(
        'categories', 'department', 'projects', 'chapter', 'userCommittees'
    ));
}
    public function createticketfile(Request $request)
    {
      //dd($request->all())->toArray();
        $request->validate([

           
            'subject' => 'required',
           
          
                    
             // 'name'=>'required',
             // 'email'=>'required',
             ]);


    if(empty($request->department) && empty($request->c_id))
    {
        return redirect()->back()
            ->withInput()
            ->with('error', 'Please select either Committee or Chapter.');
    }

    if(!empty($request->department) && !empty($request->c_id))
    {
        return redirect()->back()
            ->withInput()
            ->with('error', 'Please select only one: Committee or Chapter.');
    }

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
      $request['created_by']=Auth::user()->id??0;
      $request['ticket_created_by_id'] = Auth::user()->id;
      $request['email']=$request['email']??Auth::user()->email;
       // $request['name']=$request['name']??Auth::user()->name;
      $request['name'] = $request['name'] ?? (Auth::user()->first_name ?? Auth::user()->name);
       $request['issue_status']="pending";


     
    
      // dd($request->except(['_token','files']));

        $ticket=tickets::create($request->except(['_token','files']));

       $ticket_id = "NRIVA-".date('Y-M-d',strtotime($ticket->created_at))."-".$ticket->id;
       //dd(  $ticket_id);
        tickets::whereId($ticket->id)->update(['ticket_unique_id'=>$ticket_id]);
    


        //dd($aa);

        // $ticket->notify(new TicketUpdatedNotification($ticket));
        // dd($ticket->name);
         $details = [
        'title' =>  "Hello" .' ' .  $ticket->name ,
        'body' => '<p>Thank you for creating the ticket.</p>

                <p>We have received your ticket and our team will be working on it. We will notify you through email once the issue has been closed.</p>

                <p>Your ticket details are:</p>

                Ticket ID:'. $ticket_id .
                '<p>Ticket Link : <a href="https://support.nriva.org/ticketdetails/'.$ticket->id . '">Click Here</a>'

              
    ];
     \Mail::to($ticket->email)->send(new \App\Mail\MailNotify($details));
    // dd($ticket->email);
    // dd(Auth::user()->email);
     if(!empty($ticket->department))
     {

    $d_data = department::where('department', $ticket->department)->first();
    if (!$d_data) {
        $d_data = DB::table(config('nriva.database').'.committees')
            ->where('name', $ticket->department)
            ->select('name as department', 'email as committee_email')
            ->first();
    }

    if ($d_data && !empty($d_data->committee_email)) {
    
    //
    //dd($d_data->committee_email);

    $d_details = [
        'title' => 'Hello'. ' ' . $d_data->department,
        'body' => '<p>A new ticket has been created/assigned for your committee. Please login to support.nriva.org to check more details.</p>

                <p>Ticket Details:</p>

                Ticket ID:' . $ticket_id.
                '</p><p>Tikcet link: <a class="btn btn-danger" href="https://support.nriva.org/ticketdetails/'.$ticket->id . '">Click Here</a></p>'.
              
                '<p>Created By:</p>

                <p>Name:' . $ticket->name .
                '</p><p>Email: ' . $ticket->email .
                '</p>Contact Number: 9877899876'
    ];

     \Mail::to($d_data->committee_email)->send(new \App\Mail\committeemail($d_details));
    }
 }

  return redirect()->back()->with('success','Ticket has been created successfully.');
        
        if(Auth::user()){
            return redirect()->route('viewticket')->with('success','Ticket has been created successfully.');
                    }
                    else{
                         return redirect()->back()->with('success','Ticket has been created successfully.');
                     }
    }

    public function viewtickets(Request $request){
        //dd($request->status);
      
 $user = Auth::user();
if(!empty($request->department)){
    $request->session()->put('department',$request->department);
}
 if(!empty($request->category)){
        $request->session()->put('category',$request->category);
 }
if(!empty($request->priority)){
        $request->session()->put('priority',$request->priority);

}
 if(!empty($request->date_from)){
        $request->session()->put('date_from',$request->date_from);
}
if(!empty($request->date_to)){
            $request->session()->put('date_to',$request->date_to);
}
if(!empty($request->status) && $request->status !="All"){
            $request->session()->put('status',$request->status);

 }elseif($request->status =="All"){
        $request->session()->put('status',$request->status);
    }

         $categories = categories::all();
        $department = department::all();
        $projects = project::all();
        $chapters=chapters::all();
    
       //      $ticketlist = DB::table('tbl_ticketing_system_tickets')
       // ->leftjoin('users', 'users.id', '=', 'tickets.created_by')
       // ->leftjoin('tbl_ticketing_system_chapter', 'chapter.chapter_id', '=', 'tickets.c_id')
       // ->select('tickets.*','users.name as names','users.email as emails','chapter.*')
       // ->orderBy('id','desc');

// Logged in user committee IDs
$userCommitteeIds = DB::table(config('nriva.database').'.committeemembers')
    ->where('user_id', Auth::user()->id)
    ->where('status', 1)
    ->pluck('committee_id');

// Logged in user committees
$userCommittees = DB::table(config('nriva.database').'.committees')
    ->whereIn('id', $userCommitteeIds)
    ->where('status', 1)
    ->pluck('name')
    ->toArray();

        $ticketlist = DB::table('tbl_ticketing_system_tickets as tickets')
       ->leftJoin('tbl_ticketing_system_users as users', 'users.id', '=', 'tickets.created_by')
       ->leftJoin('tbl_ticketing_system_chapter as chapter', 'chapter.chapter_id', '=', 'tickets.c_id')
       ->select('tickets.*', 'users.name as names', 'users.email as emails', 'chapter.*')
       ->orderBy('tickets.id', 'desc');
      



if ($user->id == 2285) {
    $ticketlist = $ticketlist; 
}
    //dd($request->session()->get('date_from'));

       if(!empty($request->session()->get('department'))){
       
        $ticketlist= $ticketlist->where('tickets.department',$request->session()->get('department'));
       }   
       if(!empty($request->session()->get('category'))){
       
        $ticketlist= $ticketlist->where('tickets.category',$request->session()->get('category'));
       }
       // if(!empty($request->project)){
       //  $ticketlist= $ticketlist->where('tickets.project',$request->project);
       // } 
      if(!empty($request->session()->get('priority'))){
        $ticketlist= $ticketlist->where('tickets.issue_priority',$request->session()->get('priority'));
       }
       if(!empty($request->session()->get('date_from'))){
        $ticketlist= $ticketlist->whereDate('tickets.created_at','>=',$request->session()->get('date_from'));
       }
       else{
         $ticketlist= $ticketlist->whereDate('tickets.created_at','>=',date('Y-m-d',strtotime('-1 month')));
       }
        if(!empty($request->session()->get('date_to'))){
        $ticketlist= $ticketlist->whereDate('tickets.created_at','<=',$request->session()->get('date_to'));
       }
       else{
        $ticketlist= $ticketlist->whereDate('tickets.created_at','<=',date('Y-m-d
            '));
       }
        if(!empty($request->session()->get('status')) && $request->session()->get('status') !="All"){
           
        $ticketlist= $ticketlist->where('tickets.issue_status',$request->session()->get('status'));
       }
       elseif($request->session()->get('status') !="All"){
        
        $ticketlist= $ticketlist->where('tickets.issue_status','Pending');
       }
  
         $ticketlist=$ticketlist->get();
     
     
          $comments=Comment::where('post_id',$ticketlist[0]->id??0)->where('parent_id',0)->orderBy('id','desc')->get();
     
     

          

//dd($comments[1]->replies);
      

      
          return view('viewtickets',compact('ticketlist','categories','department','projects','chapters','comments'));



    }
    public function allfiles()
    {
        $files= tickets::all();
        return view('viewfile',compact('files'));

    }

   public function tickets_status(Request $request){
    //dd($request->all());
         $tid = $request->id;

         
     $status_list=tickets::where('id', $tid)->update(['issue_status'=> $request->status]);
   
        if($status_list->issue_status == 'completed')
        {
        
    
    //dd($status_list->issue_status);
    //dd($d_data->committee_email);

    $status_details = [
        'title' => 'Hello'. ' ' . $status_list->name,
        'body' => '<p>We have resolved your ticket. 

                        Your ticket details are:</p>
        
                <p>Ticket Details:</p>

                <p>Ticket ID: NRIVA - ' . $status_list->id .
                '<p>Tikcet link: support.nriva.org/</p>
              
                <p>Ticket Status: ' . $status_list->issue_status
               
    ];

     \Mail::to($status_list->email)->send(new \App\Mail\committeemail($status_details));
        }
        //dd("hello");

        return response()->json('success');
        }

    public function usersview()
    {
          $userlist=  User::whereNotIn('Role', [1])->get();;

        return view('createuser',compact('userlist'));
    }
     public function destroyusers($id)
    {
           $usersdata = User::findOrFail($id);
        $usersdata->delete();
        return redirect()->route('createusers')->with('success','User has been deleted successfully');
    }
    public function updateusers(Request $request, $userslist_id)
    {
        $users = $request->validate([
            'name' => 'required',
            'email'=>'required'
            
        ]);
     
      // dd($category);
         User::whereId($request->userslist_id)->update($users);
       return redirect()->route('createusers')->with('success','User Has Been updated 
        successfully');
    }
    public function markAsReads($id){
 
        $tickets= DB::table('tbl_ticketing_system_notifications')->where('id',$id)->update(['read_at' => Carbon::now()->toDateTimeString()]);
 // dd($tickets)->sqlArray();
    return redirect()->route('viewticket');
}
  public function markAllRead(){
 
        $tickets= DB::table('tbl_ticketing_system_notifications')->where('read_at')->update(['read_at' => Carbon::now()->toDateTimeString()]);
 // dd($tickets)->count();
    return redirect()->back();
}
  public function deleteadminticket($id)
    {
        //dd('hi');

        $ticket = tickets::findOrFail($id);
        $ticket->delete();
        if(Auth::user()->Role==1){
            //dd(Auth::user()->Role)
            return redirect()->intended('viewticket')->with('success','Ticket has been Deleted successfully.');

                    }else{
                         return redirect()->intended('mytickets')->with('success','Ticket has been Deleted successfully.');
                     }
    }

public function viewfile($id)
{
     $ticket =  DB::table('tbl_ticketing_system_tickets')->select(DB::raw('file_path'))->where('id',$id)->first();
  

//dd($ticket);

    return view('file',compact('ticket'));
}
 public function fileDestroy(Request $request)
    {
        $filename =  $request->get('file_path');
       $update_tickets= tickets::where('file_path',$filename)->delete();
        $path=public_path().'/images/'.$filename;
        if (file_exists($path)) {
            unlink($path);
        }
        $update_tickets->update();
        return $filename;  
    }
     public function delete_images(Request $request)
    {
        //dd($request->key);

      $deleteimage=tickets::where('id',$request->id)->first();
     $single_image=explode(',',$deleteimage->file_path);
        unset($single_image[$request->key]);
        $deleteimage->file_path = implode(',',$single_image);
        $deleteimage->save();

        return response()->json(['success' => true]);
    }
    public function status_change(Request $request)
    {
       //dd($request->all());
        $id=$request->id;
        //dd( $id);

        $statusticket=tickets::where('id',$id)->update(['issue_status'=>$request->statuschanged]);
       
    }
    public function reorder(Request $request)
    {
        $posts = tickets::all();

        foreach ($posts as $post) {

            foreach ($request->id as $order) {

                if ($order['id'] == $post->id) {

                    $post->update(['order' => $order['position']]);
                }
            }
        }

        return response(['message' => 'Update Successfully'], 200);
    }
  

}



