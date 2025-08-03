@extends('layouts.app')

@section('content')
<!-- Page Title -->
<div class="page-title light-background">
    <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Materials Details</h1>
        <nav class="breadcrumbs">
            <ol>
                <li><a href="{{ url('/') }}">Home</a></li>
                <li class="current">Materials Details</li>
            </ol>
        </nav>
    </div>
</div><!-- End Page Title -->

<!-- Blog Details Section -->
<section id="blog-details" class="blog-details section">
    <div class="container" data-aos="fade-up">

        <article class="article">
            <div class="article-header">

                <h1 class="title" data-aos="fade-up" data-aos-delay="100">{{ $material->title }}</h1>

                <div class="article-meta" data-aos="fade-up" data-aos-delay="200">
                    <div class="author">
                        <img src="{{ asset('assets/img/person/person-m-6.webp')}}" alt="Author" class="author-img">
                        <div class="author-info">
                            <h4>{{ $material->creator->name }}</h4>
                        </div>
                    </div>
                    <div class="post-info">
                        <span><i class="bi bi-calendar4-week"></i> {{ $material->created_at->format('d M Y H:i') }}</span>
                        <span><i class="bi bi-chat-square-text"></i> {{ $material->comments_count }} Comments</span>
                    </div>
                </div>
            </div>
          <div class="article-wrapper">
            <aside class="table-of-contents" data-aos="fade-left">
              <h3>Table of Contents</h3>
              {{-- <nav>
                <ul>
                  <li><a href="#introduction" class="active">Introduction</a></li>
                  <li><a href="#skeuomorphism">The Skeuomorphic Era</a></li>
                  <li><a href="#flat-design">Flat Design Revolution</a></li>
                  <li><a href="#material-design">Material Design</a></li>
                  <li><a href="#neumorphism">Rise of Neumorphism</a></li>
                  <li><a href="#future">Future Trends</a></li>
                </ul>
              </nav> --}}
            </aside>

            <div class="article-content">
              <div class="content-section" id="introduction" data-aos="fade-up">
                @if($material->description)
                <p class="lead">
                  {{ $material->description }}
                 </p>
                @endif
              </div>

              <div class="content-section" id="flat-design" data-aos="fade-up">
                    <!-- Display multimedia content -->
                    @if($material->file_path)
                    <div class="mb-4">
                        @switch($material->type)
                        @case('image')
                        <div class="text-center">
                            <img src="{{ asset('storage/' . $material->file_path) }}" class="img-fluid rounded"
                                alt="{{ $material->title }}" style="max-height: 500px;">
                        </div>
                        @break

                        @case('pdf')
                        <div class="text-center">
                            <embed src="{{ asset('storage/' . $material->file_path) }}" type="application/pdf"
                                width="100%" height="600px" />
                            <div class="mt-2">
                                <a href="{{ asset('storage/' . $material->file_path) }}" class="btn btn-primary"
                                    target="_blank">
                                    <i class="fas fa-download"></i> Download PDF ({{ $material->file_size_human }})
                                </a>
                            </div>
                        </div>
                        @break

                        @case('audio')
                        <div class="text-center">
                            <audio controls class="w-100" style="max-width: 500px;">
                                <source src="{{ asset('storage/' . $material->file_path) }}" type="audio/mpeg">
                                Your browser does not support the audio element.
                            </audio>
                            <div class="mt-2">
                                <small class="text-muted">{{ $material->file_name }}
                                    ({{ $material->file_size_human }})</small>
                            </div>
                        </div>
                        @break

                        @case('video')
                        <div class="text-center">
                            <video controls class="w-100" style="max-width: 800px; max-height: 500px;">
                                <source src="{{ asset('storage/' . $material->file_path) }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                            <div class="mt-2">
                                <small class="text-muted">{{ $material->file_name }}
                                    ({{ $material->file_size_human }})</small>
                            </div>
                        </div>
                        @break
                        @endswitch
                    </div>
                    @endif
              </div>

              <div class="content-section" id="material-design" data-aos="fade-up">
                <!-- Display article content -->
                    @if($material->content)
                    @php
                            $content = $material->content;

                            $content = preg_replace_callback(
                                '/<oembed\s+url="([^"]+)"\s*><\/oembed>/i',
                                function ($matches) {
                                    $url = $matches[1];
                                    $embedUrl = str_replace("watch?v=", "embed/", $url);
                                    $embedUrl = strtok($embedUrl, '&');

                                    return '<iframe width="100%" height="400" src="' . $embedUrl . '" frameborder="0" allowfullscreen></iframe>';
                                },
                                $content
                            );
                        @endphp
                    <div class="content-area">
                        {!! $content !!}
                </div>
                @endif
              </div>
            </div>
          </div>

          <div class="article-footer" data-aos="fade-up">
            <div class="share-article">
              <h4>Share this article</h4>
              <div class="share-buttons">
                <a href="#" class="share-button twitter">
                  <i class="bi bi-twitter-x"></i>
                  <span>Share on X</span>
                </a>
                <a href="#" class="share-button facebook">
                  <i class="bi bi-facebook"></i>
                  <span>Share on Facebook</span>
                </a>
                <a href="#" class="share-button linkedin">
                  <i class="bi bi-linkedin"></i>
                  <span>Share on LinkedIn</span>
                </a>
              </div>
            </div>

            <div class="article-tags">
              <h4>Related Topics</h4>
              <div class="tags">
                <a href="#" class="tag">UI Design</a>
                <a href="#" class="tag">User Experience</a>
                <a href="#" class="tag">Design Trends</a>
                <a href="#" class="tag">Innovation</a>
                <a href="#" class="tag">Technology</a>
              </div>
            </div>
          </div>

        </article>

    </div>
</section><!-- /Blog Details Section -->

{{-- <section>

</section> --}}
<div class="card m-md-2">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="fas fa-comments"></i>
                    Diskusi & Komentar ({{ $material->comments_count }})
                </h6>
            </div>
            <div class="card-body">
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                <!-- Add Comment Form -->
                <form action="{{ route('comments.store', $material) }}" method="POST" class="mb-4">
                    @csrf
                    <div class="d-flex">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=007bff&color=fff&size=40"
                            class="rounded-circle me-3" alt="Avatar" style="width: 40px; height: 40px;">
                        <div class="flex-grow-1">
                            <textarea name="content" class="form-control @error('content') is-invalid @enderror"
                                rows="3" placeholder="Tulis komentar Anda..." required>{{ old('content') }}</textarea>
                            @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <small class="text-muted">Maksimal 1000 karakter</small>
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fas fa-paper-plane"></i> Kirim Komentar
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Comments List -->
                @forelse($material->comments as $comment)
                @include('partials.comment', ['comment' => $comment, 'material' => $material])
                @empty
                <div class="text-center py-4">
                    <i class="fas fa-comment-slash fa-3x text-muted mb-3"></i>
                    <h6 class="text-muted">Belum ada komentar</h6>
                    <p class="text-muted">Jadilah yang pertama memberikan komentar!</p>
                </div>
                @endforelse
            </div>
        </div>
{{-- <section id="blog-comments" class="blog-comments section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="blog-comments-4">
          <div class="comments-header">
            <h3 class="title">Community Feedback</h3>
            <div class="comments-stats">
              <span class="count">{{ $material->comments_count }}</span>
              <span class="label">Comments</span>
            </div>
          </div>

          <div class="comments-container">
            <!-- Comment #1 -->
            <div class="comment-thread">
              <div class="comment-box">
                <div class="comment-wrapper">
                  <div class="avatar-wrapper">
                    <img src="{{ asset('assets/img/person/person-f-9.webp')}}" alt="Avatar" loading="lazy">
                    <span class="status-indicator"></span>
                  </div>

                  <div class="comment-content">
                    <div class="comment-header">
                      <div class="user-info">
                        <h4>Thomas Anderson</h4>
                        <span class="time-badge">
                          <i class="bi bi-clock"></i>
                          2 hours ago
                        </span>
                      </div>
                      <div class="engagement">
                        <span class="likes">
                          <i class="bi bi-heart"></i>
                          24
                        </span>
                      </div>
                    </div>

                    <div class="comment-body">
                      <p>Nullam ac urna eu felis dapibus condimentum sit amet a augue. Sed non neque elit. Sed ut imperdiet nisi. Proin condimentum fermentum nunc.</p>
                    </div>

                    <div class="comment-actions">
                      <button class="action-btn like-btn" aria-label="Like comment">
                        <i class="bi bi-heart"></i>
                        <span>Like</span>
                      </button>
                      <button class="action-btn reply-btn" aria-label="Reply to comment">
                        <i class="bi bi-chat"></i>
                        <span>Reply</span>
                      </button>
                      <button class="action-btn share-btn" aria-label="Share comment">
                        <i class="bi bi-share"></i>
                        <span>Share</span>
                      </button>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Replies Container -->
              <div class="replies-container">
                <!-- Reply #1 -->
                <div class="comment-box reply">
                  <div class="comment-wrapper">
                    <div class="avatar-wrapper">
                      <img src="assets/img/person/person-m-9.webp" alt="Avatar" loading="lazy">
                      <span class="status-indicator"></span>
                    </div>

                    <div class="comment-content">
                      <div class="comment-header">
                        <div class="user-info">
                          <h4>Maria Rodriguez</h4>
                          <span class="time-badge">
                            <i class="bi bi-clock"></i>
                            1 hour ago
                          </span>
                        </div>
                        <div class="engagement">
                          <span class="likes">
                            <i class="bi bi-heart"></i>
                            8
                          </span>
                        </div>
                      </div>

                      <div class="comment-body">
                        <p>Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae.</p>
                      </div>

                      <div class="comment-actions">
                        <button class="action-btn like-btn" aria-label="Like comment">
                          <i class="bi bi-heart"></i>
                          <span>Like</span>
                        </button>
                        <button class="action-btn reply-btn" aria-label="Reply to comment">
                          <i class="bi bi-chat"></i>
                          <span>Reply</span>
                        </button>
                        <button class="action-btn share-btn" aria-label="Share comment">
                          <i class="bi bi-share"></i>
                          <span>Share</span>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Reply #2 -->
                <div class="comment-box reply">
                  <div class="comment-wrapper">
                    <div class="avatar-wrapper">
                      <img src="assets/img/person/person-f-9.webp" alt="Avatar" loading="lazy">
                      <span class="status-indicator"></span>
                    </div>

                    <div class="comment-content">
                      <div class="comment-header">
                        <div class="user-info">
                          <h4>Alex Chen</h4>
                          <span class="time-badge">
                            <i class="bi bi-clock"></i>
                            30 minutes ago
                          </span>
                        </div>
                        <div class="engagement">
                          <span class="likes">
                            <i class="bi bi-heart"></i>
                            5
                          </span>
                        </div>
                      </div>

                      <div class="comment-body">
                        <p>Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus.</p>
                      </div>

                      <div class="comment-actions">
                        <button class="action-btn like-btn" aria-label="Like comment">
                          <i class="bi bi-heart"></i>
                          <span>Like</span>
                        </button>
                        <button class="action-btn reply-btn" aria-label="Reply to comment">
                          <i class="bi bi-chat"></i>
                          <span>Reply</span>
                        </button>
                        <button class="action-btn share-btn" aria-label="Share comment">
                          <i class="bi bi-share"></i>
                          <span>Share</span>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Comment #2 -->
            <div class="comment-thread">
              <div class="comment-box">
                <div class="comment-wrapper">
                  <div class="avatar-wrapper">
                    <img src="assets/img/person/person-f-7.webp" alt="Avatar" loading="lazy">
                    <span class="status-indicator"></span>
                  </div>

                  <div class="comment-content">
                    <div class="comment-header">
                      <div class="user-info">
                        <h4>Emily Watson</h4>
                        <span class="time-badge">
                          <i class="bi bi-clock"></i>
                          3 hours ago
                        </span>
                      </div>
                      <div class="engagement">
                        <span class="likes">
                          <i class="bi bi-heart"></i>
                          15
                        </span>
                      </div>
                    </div>

                    <div class="comment-body">
                      <p>Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum.</p>
                    </div>

                    <div class="comment-actions">
                      <button class="action-btn like-btn" aria-label="Like comment">
                        <i class="bi bi-heart"></i>
                        <span>Like</span>
                      </button>
                      <button class="action-btn reply-btn" aria-label="Reply to comment">
                        <i class="bi bi-chat"></i>
                        <span>Reply</span>
                      </button>
                      <button class="action-btn share-btn" aria-label="Share comment">
                        <i class="bi bi-share"></i>
                        <span>Share</span>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </section><!-- /Blog Comments Section --> --}}

<style>
    .content-area img {
        max-width: 100%;
        height: auto;
        display: block;
        margin: 1em 0;
    }

    .ckeditor-content iframe {
        width: 100%;
        height: 400px;
        max-width: 100%;
        border: none;
    }

    .content-area {
        line-height: 1.6;
        color: #333;
    }

    .content-area h1,
    .content-area h2,
    .content-area h3,
    .content-area h4,
    .content-area h5,
    .content-area h6 {
        margin-top: 1.5rem;
        margin-bottom: 1rem;
    }

    .content-area p {
        margin-bottom: 1rem;
    }

    .content-area ul,
    .content-area ol {
        margin-bottom: 1rem;
        padding-left: 2rem;
    }

    .content-area blockquote {
        border-left: 4px solid #007bff;
        margin: 1rem 0;
        padding-left: 1rem;
        font-style: italic;
        color: #666;
    }

    .content-area table {
        width: 100%;
        margin-bottom: 1rem;
        border-collapse: collapse;
    }

    .content-area table th,
    .content-area table td {
        padding: 0.75rem;
        border: 1px solid #dee2e6;
    }

    .content-area table th {
        background-color: #f8f9fa;
        font-weight: bold;
    }

    .comment-item {
        transition: background-color 0.2s ease;
    }

    .comment-item:hover {
        background-color: #f8f9fa;
    }

    .reply-form {
        display: none;
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid #dee2e6;
    }

    .comment-actions {
        opacity: 0;
        transition: opacity 0.2s ease;
    }

    .comment-item:hover .comment-actions {
        opacity: 1;
    }

</style>

<!-- Reply Form Toggle Script -->
<script>
    function toggleReplyForm(commentId) {
        const replyForm = document.getElementById('reply-form-' + commentId);
        const isVisible = replyForm.style.display === 'block';

        // Hide all reply forms
        document.querySelectorAll('.reply-form').forEach(form => {
            form.style.display = 'none';
        });

        // Show/hide current reply form
        replyForm.style.display = isVisible ? 'none' : 'block';

        if (!isVisible) {
            replyForm.querySelector('textarea').focus();
        }
    }

    function toggleEditForm(commentId) {
        const commentContent = document.getElementById('comment-content-' + commentId);
        const editForm = document.getElementById('edit-form-' + commentId);

        const isEditing = editForm.style.display === 'block';

        commentContent.style.display = isEditing ? 'block' : 'none';
        editForm.style.display = isEditing ? 'none' : 'block';

        if (!isEditing) {
            editForm.querySelector('textarea').focus();
        }
    }

</script>
@endsection
