@php
    $author = $item->user->name ?? 'Former user';
    $colors = ['teal', 'orange', 'green', 'purple', 'blue'];
    $color = $colors[abs(crc32($author)) % count($colors)];
    $date = $item->created_at ? \Carbon\Carbon::parse($item->created_at)->timezone('Asia/Kolkata') : null;
    $canEdit = Auth::check() && ((string) $item->user_id === (string) Auth::id() || Auth::user()->isSupportAdmin());
@endphp
<article class="ticket-comment removecomment" data-comment-id="{{ $item->id }}">
    <div class="ticket-comment-avatar ticket-comment-avatar--{{ $color }}" aria-hidden="true">{{ mb_strtoupper(mb_substr($author, 0, 1)) }}</div>
    <div class="ticket-comment-content">
        <header class="ticket-comment-header">
            <div>
                <span class="ticket-comment-author">{{ $author }}</span>
                @if($date)<time class="ticket-comment-date" datetime="{{ $date->toIso8601String() }}">{{ $date->format('M j, Y · g:i A') }}</time>@endif
            </div>
            <button type="button" class="ticket-comment-delete delete-comments" data-id="{{ $item->id }}" aria-label="Delete comment by {{ $author }}" title="Delete comment">
                <i class="far fa-trash-alt" aria-hidden="true"></i>
            </button>
        </header>
        <div class="ticket-comment-body">{{ $item->body }}</div>
        <div class="ticket-comment-actions">
            <button type="button" class="ticket-comment-reply" data-parent-id="{{ $rootCommentId }}" data-author="{{ $author }}">Reply</button>
            @if($canEdit)<button type="button" class="ticket-comment-edit">Edit</button>@endif
        </div>
        @if($canEdit)
            <form class="ticket-reply-form ticket-comment-edit-form" data-comment-edit-form action="{{ route('comments.update', $item->id) }}" method="POST" hidden>
                @csrf
                @method('PUT')
                <p class="ticket-reply-context">Editing {{ $threadRoot ? 'comment' : 'reply' }}</p>
                <label for="edit-comment-{{ $item->id }}" class="sr-only">Edit {{ $threadRoot ? 'comment' : 'reply' }}</label>
                <textarea id="edit-comment-{{ $item->id }}" class="form-control" name="body" rows="3" required>{{ $item->body }}</textarea>
                <p class="ticket-reply-error" role="alert" hidden></p>
                <div class="ticket-reply-actions">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="ticket-comment-edit-cancel">Cancel</button>
                </div>
            </form>
        @endif
        @if($threadRoot)
            <form class="ticket-reply-form" data-reply-form data-parent-id="{{ $rootCommentId }}" data-post-id="{{ $item->post_id }}" action="{{ route('reply.add') }}" method="POST" hidden>
                @csrf
                <p class="ticket-reply-context" data-reply-context>Replying to {{ $author }}</p>
                <label for="reply-body-{{ $rootCommentId }}" class="sr-only">Write a reply</label>
                <textarea id="reply-body-{{ $rootCommentId }}" class="form-control" name="body" rows="2" placeholder="Write a reply..." required></textarea>
                <p class="ticket-reply-error" role="alert" hidden></p>
                <div class="ticket-reply-actions">
                    <button type="submit" class="btn btn-primary">Reply</button>
                    <button type="button" class="ticket-reply-cancel">Cancel</button>
                </div>
            </form>
            @if($item->replies->isNotEmpty())
                <details class="ticket-comment-thread" open>
                    <summary><span class="ticket-replies-show">Show replies</span><span class="ticket-replies-hide">Hide replies</span> ({{ $item->replies->count() }})</summary>
                    <div class="ticket-comment-replies">
                        @foreach($item->replies as $reply)
                            @include('tickets.comment-item', ['item' => $reply, 'rootCommentId' => $rootCommentId, 'threadRoot' => false])
                        @endforeach
                    </div>
                </details>
            @endif
        @endif
    </div>
</article>
