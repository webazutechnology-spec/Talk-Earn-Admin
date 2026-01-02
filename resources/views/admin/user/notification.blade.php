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
										<form action="" method="POST" class="row g-3" enctype="multipart/form-data">
											@csrf

											<div class="col-md-3">
												<label for="created_at_from">From Date</label>
												<input type="date" name="created_at_from" id="created_at_from" class="form-control" value="{{ request()->created_at_from }}">
											</div>
										
											<div class="col-md-3">
												<label for="created_at_to">To Date</label>
												<input type="date" name="created_at_to" id="created_at_to" class="form-control" value="{{ request()->created_at_to }}">
											</div>
											<hr>
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
                                <h5 class="mb-0 text-primary">Notifications</h5>
                            </div>
							<div>
                            </div>
                        </div>
                        <hr>
						<div class="table-responsive">
							<table id="example" class="table table-striped table-bordered" style="width:100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>Title</th>
										<th>Message</th>
										<th>Created At</th>
									</tr>
								</thead>
								<tbody>
									@foreach($data as $log)
									<tr>
										<td>{{ $log->id }}</td>
										<td>{{ $log->title }}</td>
										<td>{{ $log->message }}</td>
										<td>{{ $log->created_at }}</td>
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