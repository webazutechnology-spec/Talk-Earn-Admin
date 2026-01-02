@extends('admin.layouts.app')

@section('content')
				 <div class="card border-top border-0 border-4 border-primary">
					<div class="card-body p-0">
						<div class="accordion" id="accordionExample">
							<div class="accordion-item">
								<h2 class="accordion-header" id="headingOne">
									<button class="accordion-button text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
										<i class="bx bx-filter-alt font-18 text-primary me-1"></i> Filter
									</button>
								</h2>
								<div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
									<div class="accordion-body">	
										<form action="{{ route('trainings') }}" method="POST" class="row g-3" enctype="multipart/form-data">
											@csrf

											<div class="col-md-3">
												<label for="category_id" class="form-label">Category</label>
												<select name="category_id" class="single-select @error('category_id') is-invalid @enderror" id="category_id">
													<option selected disabled value="">Choose...</option>
													@foreach ($category as $cat)
													<option value="{{ $cat->id }}" @selected($cat->id == request()->category_id)>{{ $cat->name }}</option>
													@endforeach
												</select>
												@error('category_id')
													<div class="invalid-feedback">{{ $message }}</div>
												@enderror
											</div>
											
											<div class="col-12 text-center">
												<button type="submit" class="btn btn-primary"><i class="bx bx-search"></i> Filter</button>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				
				<div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-3 row-cols-xxl-3 product-grid">
					@foreach ($data as $value)
					<div class="col">
						<div class="card">
							<iframe  src="{{$value->url}}" style="padding: 5px">
                               </iframe>
							<div class="card-body">
								<h6 class="card-title cursor-pointer"><b>Title :</b> {{$value->title}}</h6>
								<h6 class="small card-title cursor-pointer"><b>Category :</b>  {{$value->category->name??''}}</h6>

								<div class="clearfix">
									<span class="ms-2 order-actions-primary float-start">
										<a href="{{ route('training-view', ['id' => $value->id]) }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="View"><i class="bx bx-show"></i></a>
									</span>
									@if(in_array(auth()->user()->role_id, [1,2]))
									<span class="ms-2 order-actions-primary float-start">
										<a class="" href="{{ route('training-edit', ['id' => $value->id]) }}"  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Edit"><i class="bx bx-edit"></i></a>
									</span>
									<span class="mb-0 order-actions-primary float-start">
										@if(empty($value->deleted_at))
										
										<a href="{{ route('training-delete', ['id' => $value->id]) }}" class="ms-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Delete"><i class="bx bx-trash"></i></a>
										
										@else
										<a href="{{ route('training-delete', ['id' => $value->id]) }}" class="ms-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Restore"><i class="bx bx-revision"></i></a>
										
										@endif
									</span>
									@endif
								</div>
							</div>
						</div>
					</div>
					 @endforeach
				</div> 
				
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
		
        var table = $('#example').DataTable( {
            lengthChange: true,
            buttons: [ 'copy', 'excel', 'csv', 'pdf', 'print'],
        });

		table.buttons().container().hide();

		$('.buttons-copys').on('click', () => table.button('.buttons-copy').trigger());
		$('.buttons-excels').on('click', () => table.button('.buttons-excel').trigger());
		$('.buttons-pdfs').on('click', () => table.button('.buttons-pdf').trigger());
		$('.buttons-csvs').on('click', () => table.button('.buttons-csv').trigger());
		$('.buttons-prints').on('click', () => table.button('.buttons-print').trigger());
    });
		
	
	$('.single-select').select2({
		theme: 'bootstrap4',
		width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
		placeholder: $(this).data('placeholder'),
		allowClear: Boolean($(this).data('allow-clear')),
	});
</script>
@endpush