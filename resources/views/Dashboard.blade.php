@extends('partials.main')

@section('content')

<!-- Mata Kuliah	: Rekayasa Perangkat Lunak
Kelas	: IF401
Prodi	: Informatika PJJ S1
Nama Mahasiswa	: Arif Nugraha
NIM	: 230401010015
Dosen	: Riad Sahara, S.SI., M.T. -->
    <!-- Courses Hero Section -->
    <section id="courses-hero" class="courses-hero section light-background">

      <div class="hero-content">
        <div class="container">
          <div class="row align-items-center">

            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
              <div class="hero-text">
                <h1>Transform Your Future with Expert-Led Online Courses</h1>
                <p>Discover thousands of high-quality courses designed by industry professionals. Learn at your own pace, gain in-demand skills, and advance your career from anywhere in the world.</p>

                <div class="hero-stats">
                  <div class="stat-item">
                    <span class="number purecounter" data-purecounter-start="0" data-purecounter-end="50000" data-purecounter-duration="2"></span>
                    <span class="label">Students Enrolled</span>
                  </div>
                  <div class="stat-item">
                    <span class="number purecounter" data-purecounter-start="0" data-purecounter-end="1200" data-purecounter-duration="2"></span>
                    <span class="label">Expert Courses</span>
                  </div>
                  <div class="stat-item">
                    <span class="number purecounter" data-purecounter-start="0" data-purecounter-end="98" data-purecounter-duration="2"></span>
                    <span class="label">Success Rate %</span>
                  </div>
                </div>

                <div class="hero-features">
                  <div class="feature">
                    <i class="bi bi-shield-check"></i>
                    <span>Certified Programs</span>
                  </div>
                  <div class="feature">
                    <i class="bi bi-clock"></i>
                    <span>Lifetime Access</span>
                  </div>
                  <div class="feature">
                    <i class="bi bi-people"></i>
                    <span>Expert Instructors</span>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
              <div class="hero-image">
                <div class="main-image">
                  <img src="assets/img/education/courses-13.webp" alt="Online Learning" class="img-fluid">
                </div>

                <div class="floating-cards">
                  <div class="course-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="card-icon">
                      <i class="bi bi-code-slash"></i>
                    </div>
                    <div class="card-content">
                      <h6>Web Development</h6>
                      <span>2,450 Students</span>
                    </div>
                  </div>

                  <div class="course-card" data-aos="fade-up" data-aos-delay="400">
                    <div class="card-icon">
                      <i class="bi bi-palette"></i>
                    </div>
                    <div class="card-content">
                      <h6>UI/UX Design</h6>
                      <span>1,890 Students</span>
                    </div>
                  </div>

                  <div class="course-card" data-aos="fade-up" data-aos-delay="500">
                    <div class="card-icon">
                      <i class="bi bi-graph-up"></i>
                    </div>
                    <div class="card-content">
                      <h6>Digital Marketing</h6>
                      <span>3,200 Students</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>

      <div class="hero-background">
        <div class="bg-shapes">
          <div class="shape shape-1"></div>
          <div class="shape shape-2"></div>
          <div class="shape shape-3"></div>
        </div>
      </div>

    </section><!-- /Courses Hero Section -->


        <!-- Featured Courses Section -->
    <section id="featured-courses" class="featured-courses section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Featured Courses</h2>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4">

        @forelse($data as $material)
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
            <div class="course-card">
              <div class="course-image">
                <img src="{{ asset('storage/' . $material->thumbnail) }}" alt="Course" class="img-fluid">
                <div class="badge featured">Featured</div>
              </div>
              <div class="course-content">
                <div class="course-meta">
                  <span class="level">Beginner</span>
                </div>
                <h3><a href="{{ route('materials.show', $material) }}">{{ $material->title }}</a></h3>
                <p>{{ Str::limit($material->description, 100) }}</p>
                <div class="instructor">
                  <img src="{{ asset('assets/img/person/person-m-5.webp') }}" alt="Instructor" class="instructor-img">
                  <div class="instructor-info">
                    {{ $material->creator->name }} • {{ $material->created_at->diffForHumans() }}
                  </div>
                </div>
                <div class="course-stats">
                  <div class="rating">
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-half"></i>
                    <span>(4.5)</span>
                  </div>
                  <div class="students">
                    <i class="bi bi-people-fill"></i>
                    <span>students</span>
                  </div>
                </div>
              </div>
            </div>
          </div><!-- End Course Item -->
        @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-folder-open fa-4x text-muted mb-3"></i>
                    <h5 class="text-muted">Belum Ada Materi</h5>
                </div>
            </div>
        @endforelse

        <div class="more-courses text-center" data-aos="fade-up" data-aos-delay="500">
          <a href="{{ url('/course') }}" class="btn-more">View All Courses</a>
        </div>

        </div>
      </div>

    </section><!-- /Featured Courses Section -->
@endsection
