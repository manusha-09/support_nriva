<form class="ticket-comment-composer" onsubmit="return false;">
    @csrf
    <h3 class="ticket-comments-title">Comments</h3>
    <div class="ticket-comment-compose-row">
        <div class="ticket-comment-avatar ticket-comment-avatar--teal" aria-hidden="true">{{ mb_strtoupper(mb_substr(Auth::user()->name ?? 'U', 0, 1)) }}</div>
        <div class="ticket-comment-compose-content">
            <label class="sr-only" for="ticket-comment-body">Add a comment</label>
            <textarea id="ticket-comment-body" name="body" class="form-control body" placeholder="Add a comment..." rows="2"></textarea>
            <input type="hidden" name="post_id" class="ticketid" value="{{ $commentTicketId }}">
            <input type="hidden" name="parent_id" class="commentspost_id" value="0">
            <div class="ticket-comment-compose-actions">
                <input type="button" class="btn btn-primary submit_comment" value="Add Comment">
            </div>
        </div>
    </div>
</form>
