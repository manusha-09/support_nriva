<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\tickets;
use App\Models\User;
use DB;
use Auth;

class CommentController extends Controller
{
      public function store(Request $request)
    {
        //dd($request->all());
    	$request->validate([
            'body'=>'required',
        ]);
   
        $input = $request->except(['_token','files']);
        $input['user_id'] = Auth::user()->id;
        //dd($input);
    
        Comment::create($input);
        $comments=Comment::with(['user','replies'])->where('post_id', $input['post_id']??0)->where('parent_id',0)->orderBy('id','desc')->get();
     


        $html='<div>';
            foreach($comments as $comment){
                
                $html.=' <div class="row py-2 removecomment">
         <div class="col-2 col-md-1">
            <div class="letter_circle mx-2"><span class="firstletter">'.ucfirst(substr($comment->user->name,0,1)).'</span></div></div>
       <div class="col-10 col-md-11 pl-3 pl-md-0"><b>'.$comment->user->name.'</b><a class="pull-right delete-comments mr-2 py-1" data-id="'.$comment->id.'" href="javascript:;"><i class="fa fa-trash text-red" aria-hidden="true"></i></a> ';

              
                 
                $html.='<div class="text-break"> '.$comment->body.' </div></div></div>';
           

                
          }
         $html.='</div>';


        return response()->json(['success' => true,'comments'=> $html]);
   
         // return redirect()->intended('viewticket?id='.$request->post_id.'');
    }
     public function commentDelete(Request $request){

      $commentid= $request->id;
      $comment_delete=Comment::where('id',$commentid)->delete();

        return response()->json(['success' => true]);

    }
}