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
							<form action="{{ route('fund-transfers') }}" method="POST" class="row g-3" enctype="multipart/form-data">
								@csrf
                                @if(auth()->user()->roles->type == 'Admin')
								<div class="col-md-3">
									<label for="number" class="form-label">Phone Number</label>
                                     <input type="number" class="form-control" name="phone_number" value="">
								</div>
                                @endif
								<div class="col-md-3">
									<label for="from_date" class="form-label">From Date</label>
                                     <input type="date" class="form-control" name="from_date" value="{{ $defaultFrom }}">
								</div>
								<div class="col-md-3">
									<label for="to_date" class="form-label">To Date</label>
                                    <input type="date" class="form-control" name="to_date" value="{{ $defaultTo }}">
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
					<h5 class="mb-0 text-primary">Fund Transfers</h5>
				</div>
				<div>
				</div>
			</div>
			<hr>
			<div class="table-responsive">
				<table id="example" class="table table-striped table-bordered" style="width:100%">
					<thead>
						<tr>
                            <th>Sn.</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Role</th>
                            <th>Image</th>
                            <th>Amount</th>
                            <th>Remark</th>
                            <th>Date</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($data as $key => $value)
						<tr>
                            <td>{{$key+1}}</td>
							<td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('images/profile/' . $value->users->image) }}" onerror="this.onerror=null;this.src='{{ asset($profile) }}';" class="product-img-2" alt="product img" style="margin-right: 8px;"> 
                                    <span>{{ $value->users->name }}<p class="m-0"><small>{{ $value->users->code }}</small></p></span>
                                </div>
                            </td>
                            <td>{{$value->users->email}}</td>
                            <td>{{$value->users->phone_number}}</td>
                            <td>{{$value->users->roles->name}}</td>
                            <td>{{$value->bal_type=='DMT'?'Points':'Main'}}</td>
                            <td>
                            @if($value->cramount > 0)
                                <span class="text-success">+{{number_format($value->cramount,2)}}</span>
                            @else
                                <span class="text-danger">-{{number_format($value->dramount,2)}}</span>
                            @endif
                            <td>{{$value->description}}</td>
                            <td>{{$value->created_at}}</td>
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