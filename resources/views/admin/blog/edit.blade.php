@extends('admin.layouts.app')

@section('content')

    <div class="card border-top border-0 border-4 border-primary">
        <div class="card-body">
            
            <div class="card-title d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="bx bx-file me-1 font-22 text-primary"></i>
                    <h5 class="mb-0 text-primary">Update Blog</h5>
                </div>
                <div>
                    <a href="{{ route('blogs') }}" class="btn btn-primary"><i class="bx bx-list-ol"></i> Blog List</a> 
                </div>
            </div>
            <hr>
            
            <form action="{{ route('blog-update',['id' => $data->id]) }}" method="POST" class="row g-3" enctype="multipart/form-data">
                @csrf

                <div class="col-md-3">
                    <label for="category_id" class="form-label">Category</label>
                    <select name="category_id" class="single-select @error('category_id') is-invalid @enderror" id="category_id">
                        <option selected disabled value="">Choose...</option>
                        @foreach ($category as $cat)
                        <option value="{{ $cat->id }}" @selected($cat->id == old('category_id', $data->category_id))>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" class="single-select @error('status') is-invalid @enderror" id="status">
                        <option selected disabled value="">Choose...</option>
                        <option value="Pending" @selected('Pending' == old('status', $data->status))>Pending</option>
                        <option value="Publish" @selected('Publish' == old('status', $data->status))>Publish</option>
                        <option value="Schedule" @selected('Schedule' == old('status', $data->status))>Schedule</option>
                        <option value="Unpublish" @selected('Unpublish' == old('status', $data->status))>Unpublish</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-3">
                    <label for="publish_datetime" class="form-label">Published On<code>*</code></label>
                    <input type="datetime-local" name="publish_datetime" class="form-control @error('publish_datetime') is-invalid @enderror" id="publish_datetime" value="{{ old('publish_datetime', date("Y-m-d H:i:s", strtotime($data->publish_datetime))) }}" required>
                    @error('publish_datetime')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3">
                    <label for="image" class="form-label">Image </label>
                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" id="image">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-9">
                    <label for="title" class="form-label">Title <code>*</code></label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" placeholder="Enter latitude" id="title" value="{{ old('title', $data->title) }}">
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label for="image" class="form-label">Old Image</label>
                    <img src="{{ asset('images/blog/' . $data->image) }}" onerror="this.onerror=null;this.src='{{ asset('images/missing-image.png') }}';"  class="product-img-2" alt="img" style="margin-right: 8px;">
                </div>
                <div class="col-md-12">
                    <label for="content" class="form-label">Content <code>*</code></label>
                    <textarea id="editor" name="content">{!! old('content', $data->content) !!}</textarea>
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
