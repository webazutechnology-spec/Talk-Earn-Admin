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
					<h5 class="mb-0 text-primary">Withdrawal Request</h5>
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
                            <th>Txn.</th>
                            <th>Amount</th>
                            {{-- <th>Image</th> --}}
                            <th>User Remark</th>
                            <th>Remark</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Action</th>
						</tr>
					</thead>
					<tbody>
                        @foreach($data as $key => $value)
                        <tr>
                            <td>{{$key+1}}</td>
							<td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('images/profile/' . $value->fromUser->image) }}" onerror="this.onerror=null;this.src='{{ asset($profile) }}';" class="product-img-2" alt="product img" style="margin-right: 8px;"> 
                                    <span>{{ $value->fromUser->name }}<p class="m-0"><small>{{ $value->fromUser->code }}</small></p></span>
                                </div>
                            </td>
                            <td>{{$value->fromUser->email}}</td>
                            <td>{{$value->fromUser->phone_number}}</td>
                            <td>{{$value->trans_id}}</td>
                            <td>{{$value->amount}}</td>
                            {{-- <td>
                                <img src="{{ asset('images/fund_request/' . $value->utr_img) }}"
                                height="25"
                                style="cursor: pointer;"
                                onclick="showImageModal('{{ asset('images/fund_request/' . $value->utr_img) }}')">
                            </td> --}}
                            <td>{{$value->desc}}</td>
                            <td>{{$value->remark}}</td>
                            <td>{{$value->status}}</td>
                            <td>{{$value->created_at}}</td>
                            <td>
                            @if($value->status == 'Pending')
								@php
									$urlv = route('withdraw-request-update',['type' => 'verify', 'id' => $value->id]);
									$urlr = route('withdraw-request-update',['type' => 'reject', 'id' => $value->id]);
								@endphp
								<div class="d-flex">
                                    <span class="order-actions-primary">
                                        <a href="javascript:;" class="" onclick="openModal('{{ $urlv }}', '{{ $value->fromUser->name }}', 'verify')" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Edit"><i class="bx bx-check"></i></a>
                                    </span>
                                    <span class="order-actions-danger">
                                        <a href="javascript:;"  class="ms-1" onclick="openModal('{{ $urlr }}', '{{ $value->fromUser->name }}', 'reject')" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Edit"><i class="bx bx-x"></i></a>
                                    </span>
                                </div>
                                @endif
                            </td>
                        </tr>
                        @endforeach 
					</tbody>
				</table>
			</div>
		</div>
	</div>

	
	<div class="modal fade" id="rejectModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
	<div class="modal-dialog">
		<form id="idForm" action="" method="GET" enctype="multipart/form-data">
		<div class="modal-content">
			<div class="modal-header">
			<h5 class="modal-title">withdraw request <span id="kyc-statuss"></span> </h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
			</div>
              
			<div class="modal-body">
			<p>Enter remark for <span id="kyc-status"></span> <strong id="rejectUserName"></strong>:</p>
			<input name="remarks" class="form-control"/>

			<div class="row mt-3">
				<div class="col-md-6">
					<label for="mode">Mode<code>*</code></label>
					<select name="mode" id="mode" class="form-select mt-2" required>
						<option value="" selected disabled>-- Select Mode --</option>
						<option value="ATM Transfer">ATM Transfer</option>
						<option value="CASH">CASH</option>
						<option value="CHEQUE">CHEQUE</option>
						<option value="COLLECTOR BOY">COLLECTOR BOY</option>
						<option value="UPI">UPI</option>
						<option value="DMR WALLET">DMR WALLET</option>
						<option value="IMPS">IMPS</option>
						<option value="MAIN WALLET">MAIN WALLET</option>
						<option value="NEFT / RTGS">NEFT / RTGS</option>
						<option value="SAME BANK FUND TRANSFER">SAME BANK FUND TRANSFER</option>
						<option value="Wallet">Wallet</option>
					</select>
				</div>
				<div class="col-md-6">
					<label for="utr_no">UTR No.</label>
					<input type="text" name="utr_no" id="utr_no" class="form-control mt-2" placeholder="Enter UTR No">
				</div>
			</div>
			</div>

			<div class="modal-footer">
			<button type="submit" class="btn btn-success">Save</button>
			<button type="button" data-bs-dismiss="modal" class="btn btn-danger">Close</button>
			</div>
		</div>
		</form>
	</div>
	</div>
    <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content position-relative">
            <div class="modal-body text-center p-0">
                <!-- Close Button on the right side -->
                <span type="button" data-bs-dismiss="modal" aria-label="Close" class="position-absolute top-50 end-0 me-3" style="right: 0 !important;margin-right: 0px !important;margin-top: -196px;font-size: 30px;color: #b40404;"><i class="bx bx-x"></i></span>
                <!-- Image -->
                <img id="modalImage" src="" style="max-width: 100%; max-height: 80vh;">
            </div>

            </div>
        </div>
    </div>

@endsection
@push('scripts')
<script>
	function openModal(url, userName, status) {
		$('#kyc-statuss').text(status);
		$('#kyc-status').text(status=='verify'?'Verify':'Rejecting');
		$('#rejectUserName').text(userName);
		$('#idForm').attr('action', url); 
		$('#rejectModal').modal('show');
	}

    function showImageModal(imageUrl) {
        // Set image source
        $('#modalImage').attr('src', imageUrl);

        // Show modal using jQuery and Bootstrap
        $('#imageModal').modal('show');
    }
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