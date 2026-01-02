@extends('admin.layouts.app')

@section('content')

    <div class="card border-top border-0 border-4 border-primary">
        <div class="card-body">
            
            <div class="card-title d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="bx bx-file me-1 font-22 text-primary"></i>
                    <h5 class="mb-0 text-primary">Add Training</h5>
                </div>
                <div>
                    <a href="{{ route('trainings') }}" class="btn btn-primary"><i class="bx bx-list-ol"></i> Training List</a> 
                </div>
            </div>
            <hr>
            
            <form action="{{ route('training-add') }}" method="POST" class="row g-3" enctype="multipart/form-data">
                @csrf

                <div class="col-md-3">
                    <label for="category_id" class="form-label">Category</label>
                    <select name="category_id" class="single-select @error('category_id') is-invalid @enderror" id="category_id">
                        <option selected disabled value="">Choose...</option>
                        @foreach ($category as $cat)
                        <option value="{{ $cat->id }}" @selected($cat->id == old('category_id'))>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
               

                <div class="col-md-3">
                    <label for="title" class="form-label">Title <code>*</code></label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" placeholder="Enter latitude" id="title" value="{{ old('title') }}">
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label for="video" class="form-label">Video URL <code>*</code></label>
                    <input type="url" name="video" class="form-control @error('title') is-invalid @enderror" placeholder="Enter url" id="video" value="{{ old('video') }}">
                    @error('video')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12">
                    <label for="content" class="form-label">Content <code>*</code></label>
                    <textarea id="editor" name="content">{!! old('content') !!}</textarea>
                    @error('content')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <hr>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary"><i class="bx bx-send"></i> Save</button>
                </div>
            </form>

        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/tinymce@6/tinymce.min.js"></script>
    <script>
		$('.single-select').select2({
			theme: 'bootstrap4',
			width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
			placeholder: $(this).data('placeholder'),
			allowClear: Boolean($(this).data('allow-clear')),
		});

        tinymce.init({
            selector: '#editor',
            plugins: 'lists link image table code',
            toolbar: 'undo redo | bold italic | bullist numlist | link image | code'
        });
        $(document).ready(function() {
            setTimeout(function() {
                $('.tox-promotion').remove();
                $('.tox-statusbar__branding').remove();
                $('.tox-editor-header').addClass('d-flex');
                
            }, 10);
        });
	</script>
@endpush
