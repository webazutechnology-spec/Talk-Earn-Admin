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
										<form action="{{ route('cities') }}" method="POST" class="row g-3" enctype="multipart/form-data">
											@csrf

											<div class="col-md-3">
												<label for="country_id" class="form-label">Country</label>
												<select name="country_id" class="single-select @error('country_id') is-invalid @enderror" id="country_id">
													<option selected disabled value="">Choose...</option>
													@foreach ($countrie as $country)
													<option value="{{ $country->id }}" @selected($country->id == request()->country_id)>{{ $country->name }}</option>
													@endforeach
												</select>
												@error('country_id')
													<div class="invalid-feedback">{{ $message }}</div>
												@enderror
											</div>

											<div class="col-md-3">
												<label for="state_id" class="form-label">State</label>
												<select name="state_id" class="single-select @error('state_id') is-invalid @enderror" id="state_id">
													<option selected disabled value="">Choose...</option>
													@foreach ($states as $state)
													<option value="{{ $state->id }}" @selected($state->id == request()->state_id)>{{ $state->name }}</option>
													@endforeach
												</select>
												@error('state_id')
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

				<div class="card border-top border-0 border-4 border-primary">
					<div class="card-body">
                        
						<div class="card-title d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <i class="bx bxs-file me-1 font-22 text-primary"></i>
                                <h5 class="mb-0 text-primary">Cities</h5>
                            </div>
							<div>
                                <a href="{{ route('city-add') }}" class="btn btn-primary"><i class="bx bx-plus"></i> Add City</a>
                            </div>
                        </div>
                        <hr>
						<div class="table-responsive">
							<table id="example" class="table table-striped table-bordered" style="width:100%">
								<thead>
									<tr>
										<th>Sn.</th>
										<th>Name</th>
										<th>State</th>
										<th>Country</th>
										<th>Latitude</th>
										<th>Longitude</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($data as $key => $value)
									<tr>
										<td>{{ $key+1 }}</td>
										<td>{{ $value->name }}</td>
										<td>{{ $value->state->name??'' }}</td>
										<td>{{ $value->country->name??'' }}</td>
										<td>{{ $value->latitude }}</td>
										<td>{{ $value->longitude }}</td>
										<td>
											<div class="d-flex">
												<span class="order-actions-primary">
													<a href="{{ route('city-edit', ['id' => $value->id]) }}" class="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Edit"><i class="bx bx-edit"></i></a>
												</span>
												@if(empty($value->deleted_at))
												<span class="order-actions-primary">
													<a href="{{ route('city-delete', ['id' => $value->id]) }}" class="ms-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Delete"><i class="bx bx-trash"></i></a>
												</span>
												@else
												<span class="order-actions-danger">
													<a href="{{ route('city-delete', ['id' => $value->id]) }}" class="ms-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Restore"><i class="bx bx-revision"></i></a>
												</span>
												@endif
											</div>
										</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
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