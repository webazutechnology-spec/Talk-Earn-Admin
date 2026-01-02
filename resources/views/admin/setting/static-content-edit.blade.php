@extends('admin.layouts.app')

@section('content')

				<div class="card border-top border-0 border-4 border-primary">
					<div class="card-body">
                        
						<div class="card-title d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <i class="bx bxs-file me-1 font-22 text-primary"></i>
                                <h5 class="mb-0 text-primary">Update Static Content</h5>
                            </div>
							<div>

							</div>
                        </div>
                        <hr>
                        <form class="row g-3" method="POST" action="{{ route('static-content-update', ['id' => $data->id]) }}" enctype="multipart/form-data">
                            @csrf

                            <label class="form-label" for="title"> Title <span class="text-danger">*</span></label>
                            <input  type="text" class="form-control mt-0" id="title" name="title" placeholder="Enter Title" value="{{ old('title', $data->title) }}" />
                            <label class="form-label mb-0" for="editor"> Content <span class="text-danger">*</span></label>
                            <textarea id="editor" name="content">{!! old('content', $data->desc) !!}</textarea>
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary px-3"><i class="bx bx-save mr-1"></i> Update</button>
                            </div>
                        </form>
					</div>
				</div>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/tinymce@6/tinymce.min.js"></script>
<script>
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