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
      if (!Auth::check() || !Auth::user()->isSupportAdmin()) {
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
        ->whereNull('deleted_at')
        ->orderBy('name', 'asc')
        ->get();
    $projects = project::all();
    $chapter = chapters::where('status', 1)->whereNull('deleted_at')->orderBy('name')->get();

    $userCommitteeIds = DB::table(config('nriva.database').'.committeemembers')
        ->where('user_id', Auth::id())
        ->where('status', 1)
        ->whereIn('year', DB::table(config('nriva.database').'.years')->where('default_year', 1)->select('id'))
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
        if (!\App\Services\TicketSettings::bothAssignmentEnabled() &&
            ($request->input('assignment_type') === 'both' ||
                ($request->input('assignment_type') === null && $request->filled('department') && $request->filled('c_id')))) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'assignment_type' => 'Assigning to both a committee and a chapter is disabled. Please choose Committee or Chapter.',
            ]);
        }
        // Keep existing submissions compatible; the new form sends an explicit mode.
        if ($request->input('assignment_type') === 'committee') {
            $request->merge(['c_id' => null]);
        } elseif ($request->input('assignment_type') === 'chapter') {
            $request->merge(['department' => null]);
        }
      //dd($request->all())->toArray();
        $request->validate([

           
            'subject' => 'required|string',
            'project' => 'required|string|exists:tbl_ticketing_system_projects,name',
            'category' => 'required|string|exists:tbl_ticketing_system_categories,name',
            'description' => ['required', 'string', function ($attribute, $value, $fail) {
                $text = html_entity_decode(strip_tags($value), ENT_QUOTES | ENT_HTML5, 'UTF-8');
                if (preg_replace('/[\s\x{00A0}\x{200B}]+/u', '', $text) === '') {
                    $fail('Please enter a description.');
                }
            }],
            'name' => Auth::check() ? 'nullable|string' : 'required|string',
            'email' => Auth::check() ? 'nullable|email' : 'required|email',
            'assignment_type' => 'nullable|in:committee,chapter,both',
            'department' => [
                'nullable', 'required_without:c_id', 'required_if:assignment_type,committee,both',
                \Illuminate\Validation\Rule::exists('committees', 'name')->where('status', 1)->whereNull('deleted_at'),
            ],
            'c_id' => [
                'nullable', 'required_without:department', 'required_if:assignment_type,chapter,both',
                'integer', \Illuminate\Validation\Rule::exists('chapters', 'id')->where('status', 1)->whereNull('deleted_at'),
            ],
           
          
                    
             // 'name'=>'required',
             // 'email'=>'required',
             ], [
                 'project.required' => 'Please select a project.',
                 'project.exists' => 'Please select a valid project.',
                 'category.required' => 'Please select a category.',
                 'category.exists' => 'Please select a valid category.',
                 'subject.required' => 'Please enter a subject.',
                 'description.required' => 'Please enter a description.',
                 'department.required_if' => 'Please select a committee.',
                 'department.required_without' => 'Please select a committee or chapter.',
                 'c_id.required_if' => 'Please select a chapter.',
                 'c_id.required_without' => 'Please select a committee or chapter.',
             ]);


        foreach (['committee' => 'assigned_committee_user_id', 'chapter' => 'assigned_chapter_user_id'] as $type => $column) {
            $enabled = \App\Services\TicketSettings::memberAssignmentEnabled()
                && $request->boolean('assign_'.$type.'_member');
            $group = $request->input($type === 'committee' ? 'department' : 'c_id');
            $allowed = $request->input('assignment_type') === $type || $request->input('assignment_type') === 'both';
            $member = null;
            if ($enabled && $allowed && $group) {
                $member = \App\Services\TicketAssignees::members($type, $group)->first(function ($item) use ($request, $column) {
                    return (string) $item->user_id === (string) $request->input($column);
                });
                if (!$member) {
                    throw \Illuminate\Validation\ValidationException::withMessages([
                        $column => 'Please select an active member of this '.$type.' for the default year.',
                    ]);
                }
            }
            $legacyColumn = $type === 'committee' ? 'assigned_committee_member_id' : 'assigned_chapter_lead_id';
            $request->merge([
                $column => $member ? $member->user_id : null,
                $legacyColumn => $member ? $member->id : null,
            ]);
        }

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
      $request['ticket_created_by_id'] = Auth::id();
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
        \App\Services\SupportTicketMail::send($ticket->fresh(), 'created');
  return redirect()->back()->with('success','Ticket has been created successfully.');
        
        if(Auth::user()){
            return redirect()->route('viewticket')->with('success','Ticket has been created successfully.');
                    }
                    else{
                         return redirect()->back()->with('success','Ticket has been created successfully.');
                     }
    }

    public function viewtickets(Request $request){
        // Dashboard counts cover all dates and must not inherit old list filters.
        if ($request->boolean('dashboard')) {
            $request->session()->forget(['department', 'category', 'priority', 'date_from', 'date_to', 'status']);
        }
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
       ->leftJoin('users as users', 'users.id', '=', 'tickets.created_by')
       ->leftJoin('chapters as chapter', 'chapter.id', '=', 'tickets.c_id')
       ->select('tickets.*', DB::raw("COALESCE(NULLIF(TRIM(CONCAT_WS(' ', users.first_name, users.last_name)), ''), tickets.name) as names"), 'users.email as emails', 'chapter.id as chapter_id', 'chapter.name as chapter_name', 'chapter.email as chapter_email')
       ->orderBy('tickets.id', 'desc');
      



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
       elseif (!$request->boolean('dashboard')) {
         $ticketlist= $ticketlist->whereDate('tickets.created_at','>=',date('Y-m-d',strtotime('-1 month')));
       }
        if(!empty($request->session()->get('date_to'))){
        $ticketlist= $ticketlist->whereDate('tickets.created_at','<=',$request->session()->get('date_to'));
       }
       elseif (!$request->boolean('dashboard')) {
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

         
     $status_list = tickets::findOrFail($tid);
     $status_list->issue_status = $request->status;
     $status_list->save();
   
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
        if(Auth::user()->isSupportAdmin()){
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
        $request->validate(['file_path' => 'required|string']);
        $filename = $request->get('file_path');
        $ticket = tickets::whereRaw('FIND_IN_SET(?, file_path) > 0', [$filename])->firstOrFail();
        abort_unless(Auth::user()->isSupportAdmin() ||
            (string) $ticket->created_by === (string) Auth::id(), 403);

        $attachments = explode(',', $ticket->file_path);
        $attachments = array_filter($attachments, function ($attachment) use ($filename) {
            return $attachment !== $filename;
        });
        $ticket->file_path = implode(',', $attachments);
        $ticket->save();
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

        $statusticket = tickets::findOrFail($id);
        $statusticket->issue_status = $request->statuschanged;
        $statusticket->save();
       
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



