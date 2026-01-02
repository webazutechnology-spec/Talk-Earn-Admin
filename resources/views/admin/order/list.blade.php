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
						<form action="{{ route('orderes') }}" method="POST" class="row g-3" enctype="multipart/form-data">
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
				<h5 class="mb-0 text-primary">Bookings</h5>
			</div>
			<div>
				<a href="{{ route('ordere-add') }}" class="btn btn-primary"><i class="bx bx-plus"></i> Add Booking</a>
			</div>
		</div>
		<hr>
		<div class="table-responsive">
			<table id="example" class="table table-striped table-bordered" style="width:100%">
				<thead>
					<tr>
						<th>Sn.</th>
						<th>Code</th>
						<th>User Name</th>
						<th>Status</th>
						<th>Payment</th>
						<th>Total Amount</th>
						<th>A&C Charges</th>
						<th>Net Metering Charges</th>
						<th>Other Charges</th>
						<th>Received</th>
						<th>Pending Amount</th>
						<th>Commision</th>
						<th>Date</th>
						<th>Order By</th>
						<th>View Details</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($data as $key=> $value)
					@php
						$totalReceived = $value->payments()->where('trans_type', 'received')->sum('amount');
					@endphp
					<tr>
						<td>{{ $key + 1 }}</td>
						<td>{{ $value->code ?? '' }}</td>
						<td>
							<div class="d-flex align-items-center">
								<img src="{{ asset('images/profile/' .($value->user->image ?? '') ) }}" onerror="this.onerror=null;this.src='{{ asset($profile) }}';" class="product-img-2" alt="product img" style="margin-right: 8px;"> 
								<span>{{ $value->user->name??'' }}<p class="m-0"><small>{{ $value->user->code??'' }}</small></p></span>
							</div>
						</td>
						<td>
							@php
								$hex = ltrim($value->status->color, '#');

								[$r, $g, $b] = [
									hexdec(substr($hex, 0, 2)),
									hexdec(substr($hex, 2, 2)),
									hexdec(substr($hex, 4, 2)),
								];
							@endphp

							<div class="badge rounded-pill p-2 text-uppercase px-3"
								style="color: {{ $value->status->color }};
										background-color: rgba({{ $r }}, {{ $g }}, {{ $b }}, 0.18);">
								<i class="bx bxs-circle align-middle me-1"></i>
								{{ $value->status->name ?? '' }}
							</div>
						</td>
						<td>
							@php
								$hex = ltrim($value->payment->color, '#');

								[$r, $g, $b] = [
									hexdec(substr($hex, 0, 2)),
									hexdec(substr($hex, 2, 2)),
									hexdec(substr($hex, 4, 2)),
								];
							@endphp

							<div class="badge rounded-pill p-2 text-uppercase px-3"
								style="color: {{ $value->payment->color }};
										background-color: rgba({{ $r }}, {{ $g }}, {{ $b }}, 0.18);">
								<i class="bx bxs-circle align-middle me-1"></i>
								{{ $value->payment->name ?? '' }}
							</div>
						</td>
						<td>{{config('app.currency_symbol')}}{{ number_format($value->total_amount,2)}}</td>
						<td>{{config('app.currency_symbol')}}{{ number_format($value->anc_amount,2)}}</td>
						<td>{{config('app.currency_symbol')}}{{ number_format($value->net_metering_amount,2)}}</td>
						<td>{{config('app.currency_symbol')}}{{ number_format($value->other_charges,2)}}</td>
						<td>{{config('app.currency_symbol')}}{{ number_format($totalReceived,2)}}</td>
						<td>{{config('app.currency_symbol')}}{{ number_format($value->final_amount_with_tax-$totalReceived,2)}}</td>
						<td>{{config('app.currency_symbol')}}{{ number_format($value->commision,2)}}</td>
						<td>{{ $value->updated_at }}</td>
						<td>
							<div class="d-flex align-items-center">
								<img src="{{ asset('images/profile/' .($value->orderBy->image ?? '') ) }}" onerror="this.onerror=null;this.src='{{ asset($profile) }}';" class="product-img-2" alt="product img" style="margin-right: 8px;"> 
								<span>{{ $value->orderBy->name??'' }}<p class="m-0"><small>{{ $value->orderBy->code??'' }}</small></p></span>
							</div>
						</td>
						<td><a href="{{route('show-invoice',['code'=>$value->code])}}" type="button" class="btn btn-primary btn-sm radius-30 px-4">View Details</a></td>
						<td>
							<div class="d-flex">
								@if($value->order_status_id != 8 && $value->order_status_id != 9)
								<span class="order-actions-primary">
									<a href="javascript:;" class="ms-2 openStatusModel" data-id="{{ $value->id }}" data-status_id="{{ $value->order_status_id}}" data-pay_status_id="{{ $value->payment_status_id}}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Change Order Status"><i class="bx bx-edit"></i></a>
								</span>
								<span class="order-actions-primary">
									<a href="javascript:;" class="ms-2 openPaymentModel" data-id="{{ $value->id }}" data-status_id="{{ $value->order_status_id}}" data-pay_status_id="{{ $value->payment_status_id}}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Received Payment"><i class="bx bx-rupee"></i></a>
								</span>
								@endif
								@if(auth()->user()->role_id == 1)
									@if(empty($value->deleted_at))
									<span class="order-actions-primary">
										<a href="{{ route('ordere-delete', ['id' => $value->id]) }}" class="ms-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Delete"><i class="bx bx-trash"></i></a>
									</span>
									@else
									<span class="order-actions-danger">
										<a href="{{ route('ordere-delete', ['id' => $value->id]) }}" class="ms-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Restore"><i class="bx bx-revision"></i></a>
									</span>
									@endif
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


<div class="modal fade" id="paymentPay" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Received Payment</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">	
				<form action="{{route('ordere-update-paymnet')}}" method="POST" class="row g-3" enctype="multipart/form-data">
					@csrf
                	<input type="hidden" name="order_id" class="form-control" id="order_ids" required>
					<div class="mb-3">
						<label class="form-label">Amount<code>*</code></label>
						<input type="number" id="amount" name="amount" class="form-control @error('amount') is-invalid @enderror" placeholder="0.00" value="{{ old('amount') }}">
						@error('amount')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>
					<div class="mb-3">
						<label class="form-label">Payment Mode<code>*</code></label>
						<select name="payment_mode" class="form-control @error('payment_mode') is-invalid @enderror">
							
							<option value="Bank Transfer" @selected(old('payment_mode') == 'Bank Transfer')>Bank Transfer</option>
							<option value="NEFT / RTGS" @selected(old('payment_mode') == 'NEFT / RTGS')>NEFT / RTGS</option>
							<option value="IMPS" @selected(old('payment_mode') == 'IMPS')>IMPS</option>
							<option value="UPI  Transfer" @selected(old('payment_mode') == 'UPI  Transfer')>UPI  Transfer</option>
							<option value="Cheque" @selected(old('payment_mode') == 'Cheque')>Cheque</option>
							<option value="Cash" @selected(old('payment_mode') == 'Cash')>Cash</option>
						</select>
						@error('payment_mode')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>

					<div class="mb-3">
						<label class="form-label">UTR / Transaction No</label>
						<input type="text" name="utr_no" class="form-control @error('utr_no') is-invalid @enderror" value="{{ old('utr_no') }}">
						@error('utr_no')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>
					<div class="mb-3">
						<label class="form-label">Upload Screenshot</label>
						<input type="file" name="utr_img" class="form-control @error('utr_img') is-invalid @enderror" accept="image/*">
						@error('utr_img')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>

					<div class="mb-3">
						<label class="form-label">Description / Remarks</label>
						<textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="2">{{ old('description') }}</textarea>
						@error('description')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>

					<div class="text-center">
						<button type="button" class="btn btn-secondary me-3" data-bs-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Save</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="ChangeStatus" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Change Status</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
							
					<form action="{{route('ordere-update-status')}}" method="POST" class="row g-3" enctype="multipart/form-data">
					@csrf
                    	<input type="hidden" name="order_id" class="form-control" id="order_id" required>
					
						<div>
							<label for="status" class="form-label">Status</label>
							<select name="status" class="form-control @error('status') is-invalid @enderror" id="status">
							</select>
							@error('status')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
						<div>
							<label for="payment_status" class="form-label">Payment Status</label>
							<select name="payment_status" class="form-control @error('payment_status') is-invalid @enderror" id="payment_status">
								@foreach ($paymentstatus as $payment)
									<option value="{{ $payment->id }}">{{ $payment->name }}</option>
								@endforeach
							</select>
							@error('payment_status')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
						<div id="divCommision">
							<label for="commision" class="form-label">Commision<code>*</code></label>
                            <input type="number" step=".01" name="commision" class="form-control @error('commision') is-invalid @enderror" id="commision" value="{{ old('commision','0.00') }}">
							@error('commision')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
						
						{{-- <div id="divDocuments">
							<label for="documents" class="form-label">Add Document</label>
							<input type="file" name="documents[]" class="form-control @error('documents') is-invalid @enderror" id="documents" multiple>
							@error('documents')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div> --}}

						<div class="text-center">
							<button type="button" class="btn btn-secondary me-3" data-bs-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-primary">Save</button>
						</div>
					</form>

				</div>
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

 	$(document).on("click", ".openPaymentModel", function () {
		 let id = $(this).data("id");
		 $('#order_ids').val(id);
		$("#paymentPay").modal("show");
	});
    $(document).on("click", ".openStatusModel", function () {

        let id = $(this).data("id");
        let status = $(this).data("status_id");
        let pay_status = $(this).data("pay_status_id");

        $('#divCommision').hide();
        $('#divDocuments').hide();

		$.ajax({
			url: "{{ route('get-order-status') }}",
			type: "GET",
			data: { status_id: status },
			success: function (response) {
				if(response.success == true) {
					console.log(response);
					$.each(response.data, function (i, item) {
						$('#status').append($('<option>', { 
							value: item.id,
							text : item.name 
						}));
					});

					// if(status == 2){
					// 	$('#divCommision').show();
					// 	$('#status').val(status);
					// }
					// else if(status == 4){
					// 	$('#divDocuments').show();
					// 	$('#status').val(status);
					// }

					$('#status').val(status);
					$('#payment_status').val(pay_status);
					$('#order_id').val(id);
					$("#ChangeStatus").modal("show");
				}
			}
		});
    });



	$(document).on("change", "#status", function () {

        let id = $(this).val();

        $('#divCommision').hide();
        $('#divDocuments').hide();

		if(id == 2){
			$('#divCommision').show();
		} else if(id == 4){
			$('#divDocuments').show();
		}			
    });
</script>
@endpush