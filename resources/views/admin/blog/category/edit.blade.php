@extends('admin.layouts.app')

@section('content')

    <div class="card border-top border-0 border-4 border-primary">
        <div class="card-body">
            
            <div class="card-title d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="bx bx-file me-1 font-22 text-primary"></i>
                    <h5 class="mb-0 text-primary">Update Category</h5>
                </div>
                <div>
                    <a href="{{ route('blog-categories') }}" class="btn btn-primary"><i class="bx bx-list-ol"></i> Category List</a> 
                </div>
            </div>
            <hr>
            
            <form action="{{ route('blog-category-update', ['id' => $data->id]) }}" method="POST" class="row g-3" enctype="multipart/form-data">
                @csrf

                <div class="col-md-3">
                    <label for="name" class="form-label">Name <code>*</code></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Enter Name" value="{{ old('name', $data->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3">
                    <label for="image" class="form-label">Image <code>*</code></label>
                    <input type="file" accept="image/*" name="image" class="form-control @error('image') is-invalid @enderror" placeholder="Enter image" id="image" value="{{ old('image') }}">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3">
                    <label for="longitude" class="form-label">Old Image</label>
                    <img src="{{ asset('images/blog/category/' . $data->image) }}" class="product-img-2" alt="product img" style="margin-right: 8px;">
                </div>


                <hr>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary"><i class="bx bx-send"></i> Update</button>
                </div>
            </form>

        </div>
    </div>
@endsection
@push('scripts')
    <script>
		$('.single-select').select2({
			theme: 'bootstrap4',
			width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
			placeholder: $(this).data('placeholder'),
			allowClear: Boolean($(this).data('allow-clear')),
		});
	</script>
@endpush