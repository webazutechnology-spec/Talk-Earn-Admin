@extends('admin.layouts.app')

@section('content')

    <div class="card border-top border-0 border-4 border-primary">
        <div class="card-body">
            
            <div class="card-title d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="bx bx-file me-1 font-22 text-primary"></i>
                    <h5 class="mb-0 text-primary">Add Banner</h5>
                </div>
                <div>
                    <a href="{{ route('banners') }}" class="btn btn-primary"><i class="bx bx-list-ol"></i> Banner List</a> 
                </div>
            </div>
            <hr>
            <form action="{{ route('banner-store') }}" method="POST" class="row g-3" enctype="multipart/form-data">
            @csrf
                <div class="col-md-3">
                    <label for="for" class="form-label">For <code>*</code></label>
                    <select name="for" class="form-select @error('for') is-invalid @enderror" id="for" required>
                        <option selected disabled value="">Choose...</option>
                        <option value="Android" @selected('Android' == old('for'))>Android</option>
                        <option value="Website" @selected('Website' == old('for'))>Website</option>
                       <option value="Both" @selected('Both' == old('for'))>Both</option>
                       
                    </select>
                    @error('for')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label for="type" class="form-label">Type <code>*</code></label>
                    <select name="type" class="form-select @error('type') is-invalid @enderror" id="type" required>
                        <option selected disabled value="">Choose...</option>
                        <option value="Home Abaut Consalt" @selected('Home Abaut Consalt' == old('type'))>Home Abaut Consalt</option>
                        <option value="Home Offer Banner" @selected('Home Offer Banner' == old('type'))>Home Offer Banner</option>
                        <option value="Home Offer Zone Banner" @selected('Home Offer Zone Banner' == old('type'))>Home Offer Zone Banner</option>
                        <option value="Home Our Testimonials" @selected('Home Our Testimonials' == old('type'))>Home Our Testimonials</option>
                        <option value="Home Slider" @selected('Home Slider' == old('type'))>Home Slider</option>
                        <option value="Footer Product Banner" @selected('Footer Product Banner' == old('type'))>Footer Product Banner</option>
                        <option value="Header Banner" @selected('Header Banner' == old('type'))>Header Banner</option>
                        <option value="Offer Brand Image" @selected('Offer Brand Image' == old('type'))>Offer Brand Image</option>
                        <option value="Other" @selected('Other' == old('type'))>Other</option>
                       
                    </select>
                    @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3">
                    <label for="name" class="form-label">Name <code>*</code></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Enter Name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label for="title" class="form-label">Title <code>*</code></label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" id="title" placeholder="Enter Title" value="{{ old('title') }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                   <div class="col-md-3">
                    <File for="file_type" class="form-label">File Type <code>*</code></label>
                    <select name="file_type"  class="form-select @error('file_type') is-invalid @enderror" id="file_type" > required>
                        <option selected disabled value="">Choose...</option>
                        <option value="image" @selected('image' == old('file_type'))>Image</option>
                        <option value="url" @selected('url' == old('file_type'))> Video URL</option>  
                    </select>
                    @error('file_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3 url_show" style="display:{{ old('file_type')=='url'?'':'none' }}">
                    <label for="url" class="form-label"> URL<code>*</code></label>
                    <input type="url" name="url" class="form-control @error('url') is-invalid @enderror" placeholder="Url" id="url" value="{{ old('url')}}" >
                    @error('url')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror 
                </div>

                <div class="col-md-3 image_show"  style="display:{{ old('file_type')=='image'?'':'none' }}" >
                    <label for="image" class="form-label">Image <code>*</code></label>
                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" placeholder="Image" id="image" value="{{old('image')}}">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                     <label for="status" class="form-label">Status <code>*</code></label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror" id="status" required>
                        <option selected disabled value="">Choose...</option>
                        <option value="Active" @selected('Active' == old('status'))>Active</option>
                        <option value="Inactive" @selected('Inactive' == old('status'))>Inactive</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                 <div class="col-md-12">
                    <label for="description" class="form-label">Description <code>*</code></label>
                    <textarea id="editor" name="description" class="form-control">{!! old('description') !!} </textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary"><i class="bx bx-send"></i> Save</button>
                </div>
            </form>

        </div>
    </div>
@endsection
@push('scripts')
    <script>
      $('#file_type').on('change',function(e){
        $('.url_show').hide();
        $('.image_show').hide();
        if(e.target.value=='url'){
            $('.url_show').show();
        } else if(e.target.value=='image'){
            $('.image_show').show();
        }
      });
    </script>
@endpush