@extends('admin.layouts.app')

@section('content')

    <div class="card border-top border-0 border-4 border-primary">
        <div class="card-body">
            <div class="card-title d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="bx bx-file me-1 font-22 text-primary"></i>
                    <h5 class="mb-0 text-primary">Add Withdrawal</h5>
                </div>
                <div>
                    <a href="{{ route('withdraw-requests') }}" class="btn btn-primary"><i class="bx bx-list-ol"></i> Withdrawal Request List</a> 
                </div>
            </div>
            <hr>

            <div class="row">
                
                <div class="col-md-8">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary">
                            <h5 class="mb-0 text-white">Withdrawal Request</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('withdraw-add-store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                   <div class="col-md-6 mb-3">
                                    <label class="form-label">Select Bank to Pay<code>*</code></label>
                                    <select name="bank_id" id="bankSelect" class="form-select @error('bank_id') is-invalid @enderror" onchange="updateBankDetails()" required>
                                        <option value="" selected disabled>-- Choose Bank --</option>
                                        @foreach ($banks as $bank)
                                        <option value="{{ $bank->id }}" 
                                            data-name="{{ $bank->bank->name }}" 
                                            data-acc-name="{{ $bank->user_name_at_bank }}" 
                                            data-acc-no="{{ $bank->account_number }}" 
                                            data-ifsc="{{ $bank->ifscode }}"
                                            data-branch="{{ $bank->branch }}"
                                            >
                                            {{ $bank->user_name_at_bank }} - {{ $bank->bank->name }}
                                        </option>  
                                        @endforeach
                                    </select>
                                    @error('bank_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                   </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Amount<code>*</code></label>
                                        <input type="number" name="amount" class="form-control @error('amount') is-invalid @enderror" placeholder="0.00" required>
                                        @error('amount')
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
                                <p><strong>Branch:</strong> <span id="display_branch">...</span></p>
                               

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
            document.getElementById('display_branch').innerText = selectedOption.getAttribute('data-branch');
        } else {
            infoCard.style.display = 'none';
            emptyState.style.display = 'block';
        }
    }
</script>
@endpush