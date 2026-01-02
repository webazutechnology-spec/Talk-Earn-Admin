@extends('admin.layouts.app')

@section('content')

    <div class="card border-top border-0 border-4 border-primary">
        <div class="card-body">
            <div class="card-title d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="bx bx-file me-1 font-22 text-primary"></i>
                    <h5 class="mb-0 text-primary">Add Fund</h5>
                </div>
                <div>
                    <a href="{{ route('fund-requests') }}" class="btn btn-primary"><i class="bx bx-list-ol"></i> Fund Request List</a> 
                </div>
            </div>
            <hr>

            <div class="row">
                
                <div class="col-md-8">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary">
                            <h5 class="mb-0 text-white">Fund Request (Deposit)</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('fund-add-store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                
                                <div class="mb-3">
                                    <label class="form-label">Select Bank to Pay<code>*</code></label>
                                    <select name="bank_id" id="bankSelect" class="form-select @error('bank_id') is-invalid @enderror" onchange="updateBankDetails()" required>
                                        <option value="" selected disabled>-- Choose Bank --</option>
                                        @foreach ($banks as $bank)
                                        <option value="{{ $bank->id }}" 
                                            data-name="{{ $bank->bank->name }}" 
                                            data-acc-name="{{ $bank->account_name }}" 
                                            data-acc-no="{{ $bank->account_no }}" 
                                            data-ifsc="{{ $bank->ifsc_code }}"
                                            data-qr="{{ asset('images/company_bank/'.$bank->qr_code) }}">
                                            {{ $bank->display_name }}
                                        </option>  
                                        @endforeach
                                    </select>
                                    @error('bank_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Amount<code>*</code></label>
                                        <input type="number" name="amount" class="form-control @error('amount') is-invalid @enderror" placeholder="0.00" required>
                                        @error('amount')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Payment Mode<code>*</code></label>
                                        <select name="payment_mode" class="form-select @error('payment_mode') is-invalid @enderror">
                                            <option value="Bank Transfer">Bank Transfer</option>
                                            <option value="NEFT / RTGS">NEFT / RTGS</option>
                                            <option value="IMPS">IMPS</option>
                                            <option value="UPI">UPI</option>
                                            <option value="QR">QR</option>
                                            <option value="Cheque">Cheque</option>
                                            <option value="Cash">Cash</option>
                                        </select>
                                        @error('payment_mode')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">UTR / Transaction No<code>*</code></label>
                                        <input type="text" name="utr_no" class="form-control @error('utr_no') is-invalid @enderror" required>
                                        @error('utr_no')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Upload Screenshot<code>*</code></label>
                                        <input type="file" name="utr_img" class="form-control @error('utr_img') is-invalid @enderror" accept="image/*" required>
                                        @error('utr_img')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Description / Remarks</label>
                                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="2"></textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-success">Submit Request</button>
                            </form>
                        </div>
                    </div>
                </div>

        
                <div class="col-md-4">
                    <div class="card bg-light border-primary" id="bankInfoCard" style="display:none;">
                        <div class="card-body text-center">
                            <h5 class="card-title text-primary" id="display_bank_name">Bank Name</h5>
                            <p class="text-muted small">Please deposit amount to below account</p>
                            <hr>
                            <div class="text-start ps-3">
                                <p><strong>Acc Name:</strong> <span id="display_acc_name">...</span></p>
                                <p><strong>Acc No:</strong> <span id="display_acc_no" class="fs-5 text-dark">...</span></p>
                                <p><strong>IFSC:</strong> <span id="display_ifsc">...</span></p>
                            </div>
                            <hr>
                            <div class="text-center">
                                <img id="display_qr" src="" alt="QR Code" class="img-thumbnail" style="max-width: 150px;">
                                <p class="mt-2 small text-success fw-bold">Scan to Pay</p>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-secondary text-center" id="emptyState">
                        <i class="bi bi-bank fs-1"></i><br>
                        Please select a bank from the left to view payment details.
                    </div>
                </div>

            </div>

  
        </div>
    </div>
@endsection
@push('scripts')
<script>
    function updateBankDetails() {
        var select = document.getElementById('bankSelect');
        var selectedOption = select.options[select.selectedIndex];
        var infoCard = document.getElementById('bankInfoCard');
        var emptyState = document.getElementById('emptyState');

        if (select.value) {
            infoCard.style.display = 'block';
            emptyState.style.display = 'none';

            document.getElementById('display_bank_name').innerText = selectedOption.getAttribute('data-name');
            document.getElementById('display_acc_name').innerText = selectedOption.getAttribute('data-acc-name');
            document.getElementById('display_acc_no').innerText = selectedOption.getAttribute('data-acc-no');
            document.getElementById('display_ifsc').innerText = selectedOption.getAttribute('data-ifsc');
            
            document.getElementById('display_qr').src = selectedOption.getAttribute('data-qr');
        } else {
            infoCard.style.display = 'none';
            emptyState.style.display = 'block';
        }
    }
</script>
@endpush