@extends('partials.main')

@section('content')
<!-- Page Title -->
<div class="page-title light-background">
    <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Courses</h1>
        <nav class="breadcrumbs">
            <ol>
                <li><a href="{{ url('/') }}">Home</a></li>
                <li class="current">Courses</li>
            </ol>
        </nav>
    </div>
</div><!-- End Page Title -->

<!-- Courses 2 Section -->
<section id="courses-2" class="courses-2 section">

    <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row">
            <div class="col-lg-12">
                <div class="courses-grid" data-aos="fade-up" data-aos-delay="200">
                    <div class="row">

                        @forelse($data as $material)
                        <div class="col-lg-4 col-md-4">
                            <div class="course-card">
                                <div class="course-image">
                                    <img src="{{ asset('storage/' . $material->thumbnail) }}" alt="Course" class="img-fluid">
                                    <div class="course-badge">POPULAR</div>
                                </div>
                                <div class="course-content">
                                    <div class="course-meta">
                                        <span class="level">Beginner</span>
                                    </div>
                                    <h3>{{ $material->title }}</h3>
                                    <p>{{ Str::limit($material->description, 100) }}</p>
                                    <div class="course-stats">
                                        <div class="stat">
                                            <i class="bi bi-clock"></i>
                                            <span>15 hours</span>
                                        </div>
                                        <div class="stat">
                                            <i class="bi bi-people"></i>
                                            <span>1,245 students</span>
                                        </div>
                                        <div class="rating">
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-half"></i>
                                            <span>4.8 (89 reviews)</span>
                                        </div>
                                    </div>
                                    <div class="instructor-info">
                                        <img src="{{ asset('assets/img/person/person-m-3.webp')}}" alt="Instructor"
                                            class="instructor-avatar">
                                        <span class="instructor-name">{{ $material->creator->name }} • {{ $material->created_at->diffForHumans() }}</span>
                                    </div>
                                    <a href="{{ route('materials.show', $material) }}" class="btn-course">Enroll</a>
                                </div>
                            </div><!-- End Course Card -->
                        </div>
                        @empty
                        <div class="col-12">
                            <div class="text-center py-5">
                                <i class="fas fa-folder-open fa-4x text-muted mb-3"></i>
                                <h5 class="text-muted">Belum Ada Materi</h5>
                            </div>
                        </div>
                        @endforelse

                    </div>
                </div><!-- End Courses Grid -->

            </div>
        </div>

    </div>

</section><!-- /Courses 2 Section -->
@endsection
