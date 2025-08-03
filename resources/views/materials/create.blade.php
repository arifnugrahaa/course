@extends('layouts.app')

@section('content')
<!-- Page Title -->
    <div class="page-title light-background">
      <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Materials</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="{{ url('/') }}">Home</a></li>
            <li class="current">Materials</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

    <!-- Enroll Section -->
    <section id="enroll" class="enroll section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row">
          <div class="col-lg-10 mx-auto">
            <div class="enrollment-form-wrapper">

              <div class="enrollment-header text-center mb-5" data-aos="fade-up" data-aos-delay="200">
                <h2>ADD MATERIALS</h2>
                </div>

              <form action="{{ route('materials.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="title" class="form-label">Judul Materi <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                       id="title" name="title" value="{{ old('title') }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Deskripsi</label>
                                <textarea class="form-control @error('description') is-invalid @enderror"
                                          id="description" name="description" rows="3">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="content" class="form-label">Konten Artikel</label>
                                <textarea class="form-control @error('content') is-invalid @enderror"
                                          id="content" name="content" rows="10">{{ old('content') }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="type" class="form-label">Tipe Materi <span class="text-danger">*</span></label>
                                <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                    <option value="">Pilih Tipe</option>
                                    <option value="article" {{ old('type') === 'article' ? 'selected' : '' }}>Artikel</option>
                                    {{-- <option value="image" {{ old('type') === 'image' ? 'selected' : '' }}>Gambar</option> --}}
                                    <option value="pdf" {{ old('type') === 'pdf' ? 'selected' : '' }}>PDF/E-book</option>
                                    <option value="audio" {{ old('type') === 'audio' ? 'selected' : '' }}>Audio</option>
                                    <option value="video" {{ old('type') === 'video' ? 'selected' : '' }}>Video</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="file" class="form-label">Upload File Materi</label>
                                <input type="file" class="form-control @error('file') is-invalid @enderror"
                                       id="file" name="file" accept=".jpg,.jpeg,.png,.gif,.pdf,.mp3,.wav,.mp4,.avi,.mov">
                                <div class="form-text">
                                    Max: 100MB<br>
                                    Format: JPG, PNG, GIF, PDF, MP3, WAV, MP4, AVI, MOV
                                </div>
                                @error('file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="fileThumbnail " class="form-label">Upload Thumbnail <span class="text-danger">*</span></label>
                                <input type="file" class="form-control @error('fileThumbnail') is-invalid @enderror"
                                       id="fileThumbnail" name="fileThumbnail" accept=".jpg,.jpeg,.png" required>
                                <div class="form-text">
                                    Max: 100MB<br>
                                    Format: JPG, PNG
                                </div>
                                @error('fileThumbnail')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('materials.index') }}" class="btn btn-secondary">Kembali</a>
                            <div>
                                <button type="submit" name="action" value="save_draft" class="btn btn-outline-primary me-2">
                                    <i class="fas fa-save"></i> Save as Draft
                                </button>
                                <button type="submit" name="action" value="submit_review" class="btn btn-primary">
                                    @if(auth()->user()->isAdmin())
                                        <i class="fas fa-check"></i> Publish Now
                                    @else
                                        <i class="fas fa-paper-plane"></i> Submit for Review
                                    @endif
                                </button>
                            </div>
                        </div>
                    </form>

            </div>
          </div><!-- End Form Column -->

        </div>

      </div>

    </section><!-- /Enroll Section -->



<!-- Include CKEditor -->
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    // ClassicEditor
    //     .create(document.querySelector('#content'), {
    //         toolbar: [
    //             'heading', '|',
    //             'bold', 'italic', 'link', '|',
    //             'imageUpload', 'insertTable', 'mediaEmbed', '|',
    //             'codeBlock', 'blockQuote', '|',
    //             'undo', 'redo'
    //         ],
    //         mediaEmbed: {
    //             previewsInData: true
    //         },
    //         table: {
    //             contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells']
    //         },
    //         image: {
    //             toolbar: [
    //                 'imageTextAlternative',
    //                 'imageStyle:inline',
    //                 'imageStyle:block',
    //                 'imageStyle:side'
    //             ]
    //         }
    //     })
    //     .catch(error => {
    //         console.error(error);
    //     });



        class MyUploadAdapter {
        constructor(loader) {
            this.loader = loader;
        }

        upload() {
            return this.loader.file.then(file => {
                const data = new FormData();
                data.append('upload', file);

                return fetch('/upload-image', {
                    method: 'POST',
                    body: data,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(result => {
                    return {
                        default: result.url
                    };
                })
                .catch(error => {
                    console.error('Upload failed:', error);
                    throw error;
                });
            });
        }

        abort() {}
    }

    function MyCustomUploadAdapterPlugin(editor) {
        editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
            return new MyUploadAdapter(loader);
        };
    }

    ClassicEditor
        .create(document.querySelector('#content'), {
            extraPlugins: [MyCustomUploadAdapterPlugin],
        })
        .catch(error => {
            console.error(error);
        });

</script>
@endsection
