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
            'body' => 'required|string',
            'post_id' => 'required|integer|exists:tbl_ticketing_system_tickets,id',
            'parent_id' => 'nullable|integer|min:0',
        ]);
   
        $parentId = (int) $request->input('parent_id', 0);
        if ($parentId && !Comment::where('id', $parentId)->where('post_id', $request->post_id)->where('parent_id', 0)->exists()) {
            throw \Illuminate\Validation\ValidationException::withMessages(['parent_id' => 'Please reply to a comment on this ticket.']);
        }
        $input = $request->only(['body', 'post_id']);
        $input['parent_id'] = $parentId;
        $input['user_id'] = Auth::user()->id;
        //dd($input);
    
        Comment::create($input);
        $comments=Comment::with(['user','replies.user'])->where('post_id', $input['post_id']??0)->where('parent_id',0)->orderBy('id','desc')->get();
     


        $html = view('tickets.comment-list', compact('comments'))->render();


        return response()->json(['success' => true,'comments'=> $html]);
   
         // return redirect()->intended('viewticket?id='.$request->post_id.'');
    }
    public function update(Request $request, $id)
    {
        $comment = Comment::findOrFail($id);
        abort_unless((string) $comment->user_id === (string) Auth::id() || Auth::user()->isSupportAdmin(), 403);
        $request->validate(['body' => 'required|string']);
        $comment->body = $request->body;
        $comment->save();
        $comments = Comment::with(['user', 'replies.user'])->where('post_id', $comment->post_id)
            ->where('parent_id', 0)->orderBy('id', 'desc')->get();

        return response()->json(['success' => true, 'comments' => view('tickets.comment-list', compact('comments'))->render()]);
    }

     public function commentDelete(Request $request){

      $commentid= $request->id;
      $comment = Comment::findOrFail($commentid);
      DB::transaction(function () use ($comment) {
          Comment::where('post_id', $comment->post_id)->where('parent_id', $comment->id)->delete();
          $comment->delete();
      });

        $comments = Comment::with(['user', 'replies.user'])->where('post_id', $comment->post_id)
            ->where('parent_id', 0)->orderBy('id', 'desc')->get();
        return response()->json(['success' => true, 'comments' => view('tickets.comment-list', compact('comments'))->render()]);

    }
}
