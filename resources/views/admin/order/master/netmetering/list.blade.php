@extends('admin.layouts.app')

@section('content')
				{{-- <div class="card border-top border-0 border-4 border-primary">
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
										<form action="{{ route('masters') }}" method="POST" class="row g-3" enctype="multipart/form-data">
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
				</div> --}}

				<div class="card border-top border-0 border-4 border-primary">
					<div class="card-body">
                        
						<div class="card-title d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <i class="bx bxs-file me-1 font-22 text-primary"></i>
                                <h5 class="mb-0 text-primary">Net Metering</h5>
                            </div>
							<div>
                                <a href="{{ route('netmetering-add') }}" class="btn btn-primary"><i class="bx bx-plus"></i> Add Net Metering</a>
                            </div>
                        </div>
                        <hr>
						<div class="table-responsive">
							<table id="example" class="table table-striped table-bordered" style="width:100%">
								<thead>
									<tr>
										<th>Sn.</th>
										<th>Name</th>
										<th>Amount</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($data as $key => $value)
									<tr>
										<td>{{ $key+1 }}</td>
										<td>{{ $value->name }}</td>
										<td>{{ $value->amount }}</td>
										<td>
											<div class="d-flex">
												<span class="order-actions-primary">
													<a href="{{ route('netmetering-edit', ['id' => $value->id]) }}" class="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Edit"><i class="bx bx-edit"></i></a>
												</span>
												@if(empty($value->deleted_at))
												<span class="order-actions-primary">
													<a href="{{ route('netmetering-delete', ['id' => $value->id]) }}" class="ms-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Delete"><i class="bx bx-trash"></i></a>
												</span>
												@else
												<span class="order-actions-danger">
													<a href="{{ route('netmetering-delete', ['id' => $value->id]) }}" class="ms-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Restore"><i class="bx bx-revision"></i></a>
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
		

</script>
@endpush