@extends('admin.layouts.app')

@section('content')
@php
	$profile = 'images/user-1.svg';
@endphp
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
							<form action="{{ route('blogs') }}" method="POST" class="row g-3" enctype="multipart/form-data">
								@csrf

								<div class="col-md-3">
									<label for="category_id" class="form-label">Category</label>
									<select name="category_id" class="single-select @error('category_id') is-invalid @enderror" id="category_id">
										<option selected disabled value="">Choose...</option>
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

	<div class="card border-top border-0 border-4 border-primary">
		<div class="card-body">
			
			<div class="card-title d-flex align-items-center justify-content-between">
				<div class="d-flex align-items-center">
					<i class="bx bxs-file me-1 font-22 text-primary"></i>
					<h5 class="mb-0 text-primary">Leads</h5>
				</div>
				<div>
					<a href="{{ route('lead-add') }}" class="btn btn-primary"><i class="bx bx-plus"></i> Add Lead</a>
				</div>
			</div>
			<hr>
			<div class="table-responsive">
				<table id="example" class="table table-striped table-bordered" style="width:100%">
					<thead>
						<tr>
							<th>Sn.</th>
							<th>Client</th>
							<th>Email</th>
							<th>Phone</th>
							<th>Company Name</th>
							<th>Source</th>
							<th>Remark</th>
							<th>Lead Price</th>
							<th>Status</th>
							<th>Assigned</th>
							<th>Associate</th>
							<th>Address</th>
							<th>Quotation</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($data as $key => $value)
						<tr>
							<td>{{ $key+1 }}</td>
							<td>{{ $value->user_name }}</td>
							<td>{{ $value->email }}</td>
							<td>{{ $value->phone }}</td>
							<td>{{ $value->company_name }}</td>
							<td>{{ $value->source }}</td>
							<td>{{ $value->source_description }}</td>
							<td>{{config('app.currency_symbol')}}{{ number_format($value->lead_price,2) }}</td>
							<td><div class="badge rounded-pill {{ $value->status == 'Converted'?'text-success bg-light-success':($value->status == 'Prospecting'?'text-info bg-light-info':'text-danger bg-light-danger') }} p-2 text-uppercase px-3"><i class="bx bxs-circle me-1"></i>{{ $value->status }}</div></td>
							<td>
								@if(!empty($value->assignedAgent->name))
								<div class="d-flex align-items-center">
									<img src="{{ asset('images/profile/' .($value->assignedAgent->image ?? '') ) }}" onerror="this.onerror=null;this.src='{{ asset($profile) }}';" class="product-img-2" alt="product img" style="margin-right: 8px;"> 
									<span>{{ $value->assignedAgent->name??'' }}<p class="m-0"><small>{{ $value->assignedAgent->code??'' }}</small></p></span>
								</div>
								@else
								--
								@endif
							</td>
							<td>
								@if(!empty($value->associate->name))
								<div class="d-flex align-items-center">
									<img src="{{ asset('images/profile/' .($value->associate->image ?? '') ) }}" onerror="this.onerror=null;this.src='{{ asset($profile) }}';" class="product-img-2" alt="product img" style="margin-right: 8px;"> 
									<span>{{ $value->associate->name??'' }}<p class="m-0"><small>{{ $value->associate->code??'' }}</small></p></span>
								</div>
								@else
								--
								@endif
							</td>
							<td>{{ $value->address }}</td>
							<td>@if(!empty($value->quotation))
								<span class="order-actions-primary">
                                  <a href="{{ url('images/quotation/'.$value->quotation) }}" 
                                      target="_blank" data-bs-original-title="View Quotation">
                                       <i class="bx bx-show"></i>
                                   </a>
								</span>   
                                @else
                                 <span class="text-muted">NA</span>
                                @endif
                            </td>
							<td>
								<div class="d-flex">
									<span class="order-actions-primary">
										<a href="javascript:;" class="openAssignEmployee" data-id="{{ $value->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Assign Employee" ><i class="bx bx-share-alt"></i></a>
									</span>
									<span class="order-actions-primary">
										<a href="{{ route('lead-follow-up', ['id' => $value->id]) }}" class="ms-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Follow Up"><i class="bx bx-conversation"></i></a>
									</span>
									<span class="order-actions-primary"s>
										<a href="javascript:;" class="ms-2 openChangeStatus" data-id="{{ $value->id }}" data-status="{{ $value->status }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Change Status"><i class="bx bx-message-square-edit"></i></a>
									</span>
									<span class="order-actions-primary">
										<a href="javascript:;" class="ms-2 openAddQuotation"data-id="{{$value->id}}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Add Quotation"><i class="bx bx-message-square-add"></i></a>
									</span>
									<span class="order-actions-primary">
										<a href="{{ route('lead-edit', ['id' => $value->id]) }}" class="ms-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Edit"><i class="bx bx-edit"></i></a>
									</span>
									@if(empty($value->deleted_at))
									<span class="order-actions-primary">
										<a href="{{ route('lead-delete', ['id' => $value->id]) }}" class="ms-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Delete"><i class="bx bx-trash"></i></a>
									</span>
									@else
									<span class="order-actions-danger">
										<a href="{{ route('lead-delete', ['id' => $value->id]) }}" class="ms-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Restore"><i class="bx bx-revision"></i></a>
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

	
	<div class="modal fade" id="changeStatus" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Change Status</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
							
					<form action="" method="POST" class="row g-3" enctype="multipart/form-data">
						@csrf

                    	<input type="hidden" name="id" class="form-control" id="ids" required>

						<div class="col-md-12">
							<label for="status" class="form-label">Status</label>
							<select name="status" class="form-select @error('status') is-invalid @enderror" id="status_model">
								<option value="Pending">Pending</option>
								<option value="Open">Open</option>
								<option value="Closed">Closed</option>
							</select>
							@error('status')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
						
						<div class="col-12 text-center">
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-primary"> Chnage</button>
						</div>
					</form>

				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="assignEmployee" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Assign Employee</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<form action="{{ route('lead-assign-employee') }}" method="POST" class="row g-3" enctype="multipart/form-data">
						@csrf
						
                    	<input type="hidden" name="id" class="form-control" id="id" required>

						<div class="col-md-12">
							<label for="employee" class="form-label">Employee</label>
							<select name="employee" class="single-select single-selects @error('employee') is-invalid @enderror" id="employee">
								<option selected disabled value="">Choose...</option>
								@foreach ($employees as $employee)
								<option value="{{ $employee->id }}">{{ $employee->name }} - {{ $employee->code }} ({{ $employee->roles->name }})</option>
								@endforeach
							</select>
							@error('employee')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
						<div class="col-12 text-center">
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-primary">Assign</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="addQuotation" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Add Quotaion</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
							
					<form action="{{route('add-quotation')}}" method="POST" class="row g-3" enctype="multipart/form-data">
						@csrf
						<input type="hidden" name="id" class="form-control" id="qid" required>
                 
						<div class="col-md-12">
							<label for="quotation" class="form-label">Add Quotation  (type-pdf)</label>
							<input type="file" name="quotation" class="form-control @error('quotation') is-invalid @enderror" required>
							@error('quotation')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
						
						<div class="col-12 text-center">
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-primary">Add</button>
						</div>
					</form>

				</div>
			</div>
		</div>
	</div>
@endsection
@push('scripts')
<script>
	$(document).on("click", ".openAssignEmployee", function () {
    	let id = $(this).data("id"); // get clicked button id
    	$("#id").val(id); // set value inside modal input
		$("#assignEmployee").modal("show");
	});

	$('#assignEmployee').on('shown.bs.modal', function () {

		$('.single-selects').select2('destroy'); // reset

		$('.single-selects').select2({
			theme: 'bootstrap4',
			dropdownParent: $('#assignEmployee'),
			width: '100%',
			placeholder: $(this).data('placeholder'),
			allowClear: true
		});

	});

	$(document).on("click", ".openChangeStatus", function () {

		let id = $(this).data("id");
		let status = $(this).data("status");

		$("#ids").val(id);
		$("#status_model").val(status).trigger('change');

		$("#changeStatus").modal("show");
	});

	$(document).on("click",".openAddQuotation",function(){
		let id= $(this).data("id");
         $("#qid").val(id);

        $("#addQuotation").modal("show");
	});


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