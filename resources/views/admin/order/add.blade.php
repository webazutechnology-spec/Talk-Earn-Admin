@extends('admin.layouts.app')
@section('content')
<style>
	.add-product {
		width: 1.5rem;
		height: 1.5rem;
		display: flex;
		align-items: center;
		justify-content: center;
	}

.cart-section {
    max-height: 820px;
    overflow-y: auto;
}

/* Chrome, Edge, Safari */
.cart-section::-webkit-scrollbar {
    width: 8px;
}

.cart-section::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.cart-section::-webkit-scrollbar-thumb {
    background: #9ca3af;
    border-radius: 10px;
}

.cart-section::-webkit-scrollbar-thumb:hover {
    background: #6b7280;
}

/* Firefox */
.cart-section {
    scrollbar-width: thin;
    scrollbar-color: #9ca3af #f1f1f1;
}
</style>
<div class="card radius-15 border-top border-0 border-3 border-primary">
	<div class="card-body p-3">
		<h5 class="card-title text-primary">Add New Booking</h5>
		<hr>
		
		<div class="row">
			<div class="col-lg-7">
				<form action="{{ route('ordere-store') }}" method="POST" enctype="multipart/form-data">
					@csrf
					<div class=" table-responsive border-top">
						<table class="table align-middle" style="width:100%">
							<thead class="table-light">
								<tr>
									<th></th>
									<th>Name</th>
									<th>Discounted Price</th>
									<th>Qyt.</th>							
									<th>Action</th>
								</tr>
							</thead>
							<tbody id="cartTableBody">
								@include('admin.order._partial.cart_table', ['cart' => $cart])
							</tbody>
							<tfoot>
							<tr>
								<td></td>
								<td><strong>Total</strong></td>
								<td><strong id="grandTotal">0.00</strong></td>
								<td class="text-center"><strong id="totalQty">0</strong></td>
								<td></td>
							</tr>
							</tfoot>
						</table>
					</div>

					<div class="row">
						<div class="col-md-6 mb-3">
							<label class="form-label">Is New Client<code>*</code></label>
							<select id="is_new_client" name="is_new_client" class="form-control @error('is_new_client') is-invalid @enderror">
								<option value="" selected disabled>-- Choose --</option>
								<option value="Yes" @selected(old('is_new_client') == "Yes")>Yes</option>
								<option value="No" @selected(old('is_new_client') == "No")>No</option>
							</select>
							@error('is_new_client')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
						<div class="col-md-6 mb-3">
							<label class="form-label">Client Name<code>*</code></label>
							<input type="text" id="client_name" name="client_name" class="form-control @error('client_name') is-invalid @enderror" placeholder="Enter Client Name" value="{{ old('client_name') }}" readonly>
							@error('client_name')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
						<div class="col-md-6 mb-3">
							<label class="form-label">Client Email<code>*</code></label>
							<input type="email" id="client_email" name="client_email" class="form-control @error('client_email') is-invalid @enderror" placeholder="Enter Client Email" value="{{ old('client_email') }}" readonly>
							@error('client_email')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
						<div class="col-md-6 mb-3">
							<label class="form-label">Client Phone<code>*</code></label>
							<input type="number" id="client_phone" name="client_phone" class="form-control @error('client_phone') is-invalid @enderror" placeholder="Enter Client Phone" value="{{ old('client_phone') }}" readonly>
							@error('client_phone')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
						
						<hr>

						<div class="col-12 mb-3">
							<label for="full_address" class="form-label">Address<code>*</code></label>
							<textarea class="form-control" id="full_address" name="full_address" placeholder="Address..." rows="3">{{old('full_address')}}</textarea>
							@error('full_address')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						
						<div class="col-md-6 mb-3">
							<label for="country" class="form-label">country<code>*</code></label>
							<select name="country" class="single-select @error('country') is-invalid @enderror" id="country" onchange="getStates(this.value)">
								{{-- <option selected disabled value="">Choose...</option> --}}
								@foreach ($countrie as $country)
								<option value="{{ $country->id }}" @selected($country->id == old('country', $country_id))>{{ $country->name }}</option>
								@endforeach
							</select>
							@error('country')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="col-md-6 mb-3">
							<label for="state" class="form-label">State<code>*</code></label>
							<select name="state" class="single-select @error('state') is-invalid @enderror" id="state" onchange="getCities(this.value)">
								<option selected disabled value="">Choose...</option>                    
								@foreach ($states as $state)
								<option value="{{ $state->id }}" @selected($state->id == old('state'))>{{ $state->name }}</option>
								@endforeach
							</select>
							@error('state')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="col-md-6 mb-3">
							<label for="city" class="form-label">City<code>*</code></label>
							<select name="city" class="single-select @error('city') is-invalid @enderror" id="city">
								<option selected disabled value="">Choose...</option>
								@foreach ($cities as $city)
								<option value="{{ $city->id }}" @selected($city->id == old('city'))>{{ $city->name }}</option>
								@endforeach
							</select>
							@error('city')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="col-md-6 mb-3">
							<label for="zip" class="form-label">Zip<code>*</code></label>
							<input type="text" name="zip" class="form-control @error('zip') is-invalid @enderror" id="zip" placeholder="Enter Zip" value="{{ old('zip') }}">
							@error('zip')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="col-md-6 mb-3">
							<label class="form-label">Total Amount<code>*</code></label>
							<input type="number" id="total_amount" name="total_amount" class="form-control @error('total_amount') is-invalid @enderror" placeholder="0.00" value="{{ old('total_amount','0.00') }}" readonly>
							@error('total_amount')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
						<div class="col-md-6 mb-3">
							<label class="form-label">Advance Payment<code>*</code></label>
							<input type="number"  id="advance_payment" name="advance_payment" class="form-control @error('advance_payment') is-invalid @enderror" placeholder="0.00" value="{{ old('advance_payment','0.00') }}">
							@error('advance_payment')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="col-md-6 mb-3">
							<label for="a_and_c_charges" class="form-label">A&C Charges<code>*</code></label>
							<select name="a_and_c_charges" class="form-select @error('a_and_c_charges') is-invalid @enderror" id="a_and_c_charges">
								<option selected value="">Choose...</option>
								@foreach ($iac as $ivalue)
								<option value="{{ $ivalue->id }}" data-amount="{{ $ivalue->amount }}" @selected($ivalue->id == old('a_and_c_charges'))>{{config('app.currency_symbol')}}{{ number_format($ivalue->amount) }} - {{ $ivalue->name }}</option>
								@endforeach
							</select>
							@error('a_and_c_charges')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="col-md-6 mb-3">
							<label for="net_metering_charges" class="form-label">Net Metering Charges<code>*</code></label>
							<select name="net_metering_charges" class="form-select @error('net_metering_charges') is-invalid @enderror" id="net_metering_charges">
								<option selected value="">Choose...</option>
								@foreach ($nm as $nmvalue)
								<option value="{{ $nmvalue->id }}" data-amount="{{ $nmvalue->amount }}" @selected($nmvalue->id == old('net_metering_charges'))> {{config('app.currency_symbol')}}{{ number_format($nmvalue->amount) }} - {{ $nmvalue->name }}</option>
								@endforeach
							</select>
							@error('net_metering_charges')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="col-md-6 mb-3">
							<label class="form-label">Other Charges<code>*</code></label>
							<input type="number" id="other_charges" name="other_charges" class="form-control @error('other_charges') is-invalid @enderror" placeholder="0.00" value="{{ old('other_charges','0.00') }}">
							@error('other_charges')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="col-md-6 mb-3">
							<label class="form-label">Remaining Amount<code>*</code></label>
							<input type="number" id="remaining_amount" name="remaining_amount" class="form-control @error('remaining_amount') is-invalid @enderror" placeholder="0.00" value="{{ old('remaining_amount','0.00') }}" readonly>
							@error('remaining_amount')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>

						<div class="col-md-6 mb-3">
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
					</div>

					<div class="row">
						<div class="col-md-6 mb-3">
							<label class="form-label">UTR / Transaction No</label>
							<input type="text" name="utr_no" class="form-control @error('utr_no') is-invalid @enderror" value="{{ old('utr_no') }}">
							@error('utr_no')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
						<div class="col-md-6 mb-3">
							<label class="form-label">Upload Screenshot</label>
							<input type="file" name="utr_img" class="form-control @error('utr_img') is-invalid @enderror" accept="image/*">
							@error('utr_img')
								<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>

					<div class="mb-3">
						<label class="form-label">Description / Remarks</label>
						<textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="2">{{ old('description') }}</textarea>
						@error('description')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>

					
					<div class="row mt-4">
						<div class="col-12 d-flex justify-content-center">
							<button type="submit" class="btn btn-primary px-4">Submit</button>
						</div>
					</div>
				</form>
			</div>

			<div class="col-lg-5">
				<div class="card">
					<div class="card-body">
						<div class="row g-3">								 
							<div class="col-12">
								<label for="category" class="form-label text-primary bold">Product Category</label>
								<select class="form-control" id="category" name="category">
									@foreach ($category as $cvalue)
										<option value="{{$cvalue->id}}" @selected($cvalue->id == request()->category)>{{$cvalue->name}}</option>
									@endforeach
								</select>
							</div>
						</div> 

						<div class="row mt-4 cart-section" id="productList">
							@include('admin.order._partial.product_list_ajax', ['products' => $products])
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>

</div>


@endsection
@push('scripts')
<script>
	function calculateCartTotal() {
		let totalQty = 0;
		let grandTotal = 0;

		$("#cartTableBody tr").each(function () {
			let qty = parseInt($(this).find(".qty").val()) || 0;
			let price = parseFloat($(this).find(".discounted_price").val()) || 0;

			totalQty += qty;
			grandTotal += qty * price;

			// row total
			$(this).find(".row-total").text((qty * price).toFixed(2));
		});

		$("#totalQty").text(totalQty);
		$("#grandTotal").text(grandTotal.toFixed(2));
		$("#total_amount").val(grandTotal.toFixed(2));
	}

	$("#category").on("change", function () {

		let category_id = $(this).val();

		$.ajax({
			url: "{{ route('get-products-by-category') }}",
			type: "GET",
			data: { category_id: category_id },
			success: function (response) {
				$("#productList").html(response);
			}
		});
	});

	$("#productList").on("click", ".add-product", function() {
		let product_id = $(this).data('pro_id');

		$.ajax({
			url: "{{ route('get-products-by-id') }}",
			type: "GET",
			data: { product_id: product_id },
			success: function (response) {
				$("#cartTableBody").html(response.cart_html);
				calculateCartTotal();
			}
		});
	});

	$(document).on("click", ".btn-plus, .btn-minus", function () {
		let row = $(this).closest("tr");
		let cart_id = row.data("productid");
		let qty = parseInt(row.find(".qty").val());

		if ($(this).hasClass("btn-plus")) qty++;
		else if (qty > 1) qty--;

		row.find(".qty").val(qty);

		updateCart(cart_id, qty, row.find(".discounted_price").val());
	});

	$(document).on("change", ".discounted_price", function () {
		let row = $(this).closest("tr");
		updateCart(row.data("productid"), row.find(".qty").val(), $(this).val());
	});

	function updateCart(cart_id, qty, disc_price) {
		$.post("{{ route('cart.update') }}", {
			_token: "{{ csrf_token() }}",
			product_id: cart_id,
			quantity: qty,
			disc_price: disc_price
		}).done(function (res) {
			if (res.success) {
				console.log("Cart updated", res);
			}
			calculateCartTotal();
		})
		.fail(function (xhr) {
			alert("Failed to update cart. Please try again.");
			console.error(xhr.responseText);
		});
	}


	$(document).on("click", ".delete-cart", function () {
		let product_id = $(this).data("id");

		if (!confirm("Are you sure you want to remove this item?")) return;

		$.ajax({
			url: "{{ route('cart.delete') }}",
			type: "POST",
			data: {
				_token: "{{ csrf_token() }}",
				product_id: product_id
			},
			success: function () {
				$("tr[data-productid='" + product_id + "']").remove();
				calculateCartTotal();
			}
		});
	});

    function calculateRemainingAmount() {
        let total = parseFloat($("#total_amount").val()) || 0;
        let advanceInput = $("input[name='advance_payment']");
        let advance = parseFloat(advanceInput.val()) || 0;

        let acCharges = parseFloat($("#a_and_c_charges option:selected").data("amount")) || 0;
    	let netMetering = parseFloat($("#net_metering_charges option:selected").data("amount")) || 0;
    	let otherCharges = parseFloat($("#other_charges").val()) || 0;

    	let subtotal = acCharges + netMetering + otherCharges + total;

        // ❌ Prevent advance > total
        if (advance > subtotal) {
            advance = subtotal;
            advanceInput.val(subtotal.toFixed(2));
        }

        let remaining = subtotal - advance;
        $("input[name='remaining_amount']").val(remaining.toFixed(2));

        // set max attribute dynamically
        advanceInput.attr("max", subtotal);
    }

    // On advance payment input
    $(document).on("input", "input[name='advance_payment']", function () {
        calculateRemainingAmount();
    });
    $(document).on("input", "input[name='other_charges']", function () {
        calculateRemainingAmount();
    });
    // When total amount changes via JS
    $(document).on("change", "#total_amount", function () {
        calculateRemainingAmount();
    });
	
	$(document).on("change", "#a_and_c_charges", function () {
        calculateRemainingAmount();
    });

	$(document).on("change", "#net_metering_charges", function () {
        calculateRemainingAmount();
    });



	calculateCartTotal();



	$("#is_new_client").on("change", function () {
        let value = $(this).val();
console.log(value);
        if (value === "Yes") {
            $("#client_name, #client_email, #client_phone").prop("readonly", false).val("");
        } else if (value === "No") {
            $("#client_phone").prop("readonly", false).val("");
            $("#client_name, #client_email").prop("readonly", true).val("");
        }
    });

    // When phone entered for existing client
    $("#client_phone").on("blur", function () {

        if ($("#is_new_client").val() !== "No") return;

        let phone = $(this).val();
        if (!phone) return;

        $.ajax({
            url: "{{ route('client.find.by.phone') }}",
            type: "GET",
            data: { phone: phone },
            success: function (res) {
                if (res.success) {
                    $("#client_name").val(res.data.name);
                    $("#client_email").val(res.data.email);
                } else {
                    alert("Client not found");
                    $("#client_name, #client_email").val("");
                }
            }
        });
    });


</script>
<script>
	$(document).ready(function() {
		getStates('{{ old('country', $country_id) }}', '{{ old('state') }}');           
		setupImageUpload("profile_image", "profile_imageCard", "profile_imagePreview");
		setupImageUpload("aadhar_image_front", "aadhar_image_frontCard", "aadhar_image_frontPreview");
		setupImageUpload("aadhar_image_back", "aadhar_image_backCard", "aadhar_image_backPreview");
		setupImageUpload("pan_image", "pan_imageCard", "pan_imagePreview");
	});

	$('.single-select').select2({
		theme: 'bootstrap4',
		width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
		placeholder: $(this).data('placeholder'),
		allowClear: Boolean($(this).data('allow-clear')),
	});
</script>
@endpush







