<div class="comment-item border-bottom py-3 {{ $comment->isReply() ? 'ms-' . min($comment->getLevel() * 4, 12) : '' }}">
    <div class="d-flex">
        <!-- Avatar -->
        <img src="https://ui-avatars.com/api/?name={{ urlencode($comment->user->name) }}&background={{ $comment->user->isAdmin() ? 'dc3545' : '007bff' }}&color=fff&size=40"
             class="rounded-circle me-3" alt="Avatar" style="width: 40px; height: 40px;">

        <div class="flex-grow-1">
            <!-- Comment Header -->
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <strong class="text-primary">{{ $comment->user->name }}</strong>
                    @if($comment->user->isAdmin())
                        <span class="badge bg-danger ms-1">Admin</span>
                    @endif
                    @if($comment->user->id === $material->created_by)
                        <span class="badge bg-success ms-1">Author</span>
                    @endif
                    <small class="text-muted ms-2">{{ $comment->created_at->diffForHumans() }}</small>
                    @if($comment->created_at != $comment->updated_at)
                        <small class="text-muted">(edited)</small>
                    @endif
                </div>

                <!-- Comment Actions -->
                @auth
                    <div class="comment-actions">
                        <div class="btn-group btn-group-sm">
                            @if($comment->getLevel() < 3)
                                <button type="button" class="btn btn-outline-primary btn-sm"
                                        onclick="toggleReplyForm({{ $comment->id }})">
                                    <i class="fas fa-reply"></i> Reply
                                </button>
                            @endif

                            @if($comment->user_id === auth()->id())
                                <button type="button" class="btn btn-outline-warning btn-sm"
                                        onclick="toggleEditForm({{ $comment->id }})">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                            @endif

                            @if($comment->user_id === auth()->id() || auth()->user()->isAdmin())
                                <form action="{{ route('comments.destroy', $comment) }}" method="POST"
                                      class="d-inline" onsubmit="return confirm('Hapus komentar ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endauth
            </div>

            <!-- Comment Content -->
            <div id="comment-content-{{ $comment->id }}" class="mt-2">
                <p class="mb-2">{{ $comment->content }}</p>
            </div>

            <!-- Edit Form -->
            @if(auth()->check() && $comment->user_id === auth()->id())
                <div id="edit-form-{{ $comment->id }}" class="reply-form">
                    <form action="{{ route('comments.update', $comment) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <textarea name="content" class="form-control" rows="3" required>{{ $comment->content }}</textarea>
                                <div class="d-flex justify-content-end mt-2">
                                    <button type="button" class="btn btn-secondary btn-sm me-2"
                                            onclick="toggleEditForm({{ $comment->id }})">Cancel</button>
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <i class="fas fa-save"></i> Update
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            @endif

            <!-- Reply Form -->
            @auth
                @if($comment->getLevel() < 3)
                    <div id="reply-form-{{ $comment->id }}" class="reply-form">
                        <form action="{{ route('comments.store', $material) }}" method="POST">
                            @csrf
                            <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                            <div class="d-flex">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=007bff&color=fff&size=32"
                                     class="rounded-circle me-2" alt="Avatar" style="width: 32px; height: 32px;">
                                <div class="flex-grow-1">
                                    <textarea name="content" class="form-control" rows="2"
                                              placeholder="Tulis balasan untuk {{ $comment->user->name }}..." required></textarea>
                                    <div class="d-flex justify-content-end mt-2">
                                        <button type="button" class="btn btn-secondary btn-sm me-2"
                                                onclick="toggleReplyForm({{ $comment->id }})">Cancel</button>
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fas fa-reply"></i> Reply
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                @endif
            @endauth
        </div>
    </div>

    <!-- Replies -->
    @if($comment->replies->count() > 0)
        <div class="mt-3">
            @foreach($comment->replies as $reply)
                @include('partials.comment', ['comment' => $reply, 'material' => $material])
            @endforeach
        </div>
    @endif
</div>
