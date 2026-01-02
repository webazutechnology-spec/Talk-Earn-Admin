@extends('admin.layouts.app')

@section('content')

    <div class="card border-top border-0 border-4 border-primary">
        <div class="card-body">
            
            <div class="card-title d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="bx bx-file me-1 font-22 text-primary"></i>
                    <h5 class="mb-0 text-primary">Update Product</h5>
                </div>
                <div>
                    <a href="{{ route('products') }}" class="btn btn-primary"><i class="bx bx-list-ol"></i> Product List</a> 
                </div>
            </div>
            <hr>
            
            <form action="{{ route('product-update',['id' => $data->id]) }}" method="POST" class="row g-3" enctype="multipart/form-data">
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
                    <label for="brand_id" class="form-label">Brand</label>
                    <select name="brand_id" class="single-select @error('brand_id') is-invalid @enderror" id="brand_id">
                        <option selected disabled value="">Choose...</option>
                        @foreach ($brand as $cat)
                        <option value="{{ $cat->id }}" @selected($cat->id == old('brand_id', $data->brand_id))>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    @error('brand_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                    <div class="col-md-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Enter Name" value="{{ old('name', $data->name) }}">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3">
                    <label for="image" class="form-label">Thumbnail </label>
                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" id="image">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                 <div class="col-md-3">
                    <label for="sku" class="form-label">SKU <code>*</code></label>
                    <input type="text" name="sku" class="form-control @error('sku') is-invalid @enderror" id="sku" placeholder="Enter SKU" value="{{ old('sku ', $data->sku) }}" required>
                    @error('sku')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label for="capacity" class="form-label">Capacity <code>*</code></label>
                    <input type="text" name="capacity" class="form-control @error('capacity') is-invalid @enderror" id="capacity" placeholder="Enter Capacity" value="{{ old('capacity', $data->capacity) }}" required>
                    @error('capacity')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label for="type" class="form-label">Type <code>*</code></label>
                    <input type="text" name="type" class="form-control @error('type') is-invalid @enderror" id="type" placeholder="Enter type" value="{{ old('type' , $data->type)  }}" required>
                    @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label for="voltage" class="form-label">Voltage <code>*</code></label>
                    <input type="text" name="voltage" class="form-control @error('voltage') is-invalid @enderror" id="voltage" placeholder="Enter voltage" value="{{ old('voltage', $data->voltage) }}" required>
                    @error('vlotage')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label for="price" class="form-label">Price <code>*</code></label>
                    <input type="number" name="price"  step=".01" class="form-control @error('price') is-invalid @enderror" id="price" placeholder="Enter Price" value="{{ old('price', $data->price) }}" required>
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label for="disc_price" class="form-label">Discount Price <code>*</code></label>
                    <input type="number" name="disc_price" step=".01" class="form-control @error('disc_price') is-invalid @enderror" id="disc_price" placeholder="Enter Discount" value="{{ old('disc_price', $data->disc_price) }}" required>
                    @error('disc_price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label for="stock_quantity" class="form-label">Stock Quantity <code>*</code></label>
                    <input type="number" name="stock_quantity" class="form-control @error('stock_quantity') is-invalid @enderror" id="stock_quantity" placeholder="Enter Quantity" value="{{ old('stock_quantity', $data->stock_quantity) }}" required>
                    @error('stock_quantity')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3">
                    <label for="image" class="form-label">Old Image</label>
                    <img src="{{ asset('images/product/' . $data->image) }}" onerror="this.onerror=null;this.src='{{ asset('images/missing-image.png') }}';"  class="product-img-2" alt="img" style="margin-right: 8px;">
                </div>
                <div class="col-md-12">
                    <label for="content" class="form-label">Specification <code>*</code></label>
                    <textarea id="editor" name="content">{!! old('content', $data->specifications) !!}</textarea>
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
