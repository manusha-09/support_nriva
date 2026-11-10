@foreach($comments as $comment)
    @include('tickets.comment-item', ['item' => $comment, 'rootCommentId' => $comment->id, 'threadRoot' => true])
@endforeach
