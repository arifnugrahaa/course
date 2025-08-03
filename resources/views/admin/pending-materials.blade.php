@extends('layouts.app')

@section('content')
  <!-- Page Title -->
    <div class="page-title light-background">
      <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Review</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="{{ url('/') }}">Home</a></li>
            <li class="current">Review</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

    <!-- Courses Events Section -->
    <section id="courses-events" class="courses-events section">
        @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row">

          <div class="col-lg-10">

            @forelse($pendingMaterials as $material)
                <article class="event-card" data-aos="fade-up" data-aos-delay="200">
              <div class="row g-0">
                <div class="col-md-4">
                  <div class="event-image">
                    <img src="{{ asset('storage/' . $material->thumbnail) }}" class="img-fluid" alt="Event Image">
                    <div class="date-badge">
                      <span class="day">{{ $material->created_at->diffForHumans() }}</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-8">
                  <div class="event-content">
                    <div class="event-meta">
                      <span class="location"><i class="bi bi-geo-alt"></i> Online</span>
                    </div>
                    <h3 class="event-title">
                      <a href="{{ route('materials.show', $material) }}">{{ $material->title }}</a>
                    </h3>
                    <p class="event-description">{{ Str::limit($material->description, 150) }}</p>
                    <div class="event-footer">
                      <div class="instructor">
                        <img src="{{ asset('assets/img/person/person-f-8.webp') }}" alt="Instructor" class="instructor-avatar">
                        <span>By {{ $material->creator->name }}</span>
                      </div>
                    </div>
                    <div class="event-actions">
                        <form action="{{ route('materials.approve', $material) }}" method="POST" class="mb-2">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success w-100"
                                                        onclick="return confirm('Approve this material?')">
                                                    <i class="fas fa-check"></i> Approve
                                                </button>
                                            </form>
                                            <button type="button" class="btn btn-sm btn-danger"
                                                    data-bs-toggle="modal" data-bs-target="#rejectModal{{ $material->id }}">
                                                <i class="fas fa-times"></i> Reject
                                            </button>
                      {{-- <a href="#" class="btn btn-outline">Reject</a> --}}
                    </div>
                  </div>
                </div>
              </div>
            </article><!-- End Event Item -->




            <div class="modal fade" id="rejectModal{{ $material->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Reject Material: {{ Str::limit($material->title, 30) }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="{{ route('materials.reject', $material) }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="rejection_reason{{ $material->id }}" class="form-label">
                                                    Reason for Rejection <span class="text-danger">*</span>
                                                </label>
                                                <textarea class="form-control"
                                                          id="rejection_reason{{ $material->id }}"
                                                          name="rejection_reason"
                                                          rows="4"
                                                          placeholder="Please provide a detailed reason for rejecting this material..."
                                                          required></textarea>
                                                <input type="hidden" name="id" value="{{ $material->id }}">
                                                <div class="form-text">This reason will be shown to the user so they can improve their material.</div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-danger">Reject Material</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
            @empty
                <div class="text-center py-5 m-5">
                            <i class="fas fa-clipboard-check fa-4x text-muted mb-3"></i>
                            <h5 class="text-muted">No materials pending review</h5>
                            <p class="text-muted">All submitted materials have been reviewed!</p>
                        </div>
            @endforelse
            <!-- Event Item -->
          </div>

        </div>

      </div>

    </section><!-- /Courses Events Section -->
@endsection
