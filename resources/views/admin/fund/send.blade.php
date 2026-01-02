@extends('admin.layouts.app')

@section('content')

    <div class="card border-top border-0 border-4 border-primary">
        <div class="card-body">
            <div class="card-title d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="bx bx-file me-1 font-22 text-primary"></i>
                    <h5 class="mb-0 text-primary">Send Fund</h5>
                </div>
                <div>
                    <a href="{{ route('fund-transfers') }}" class="btn btn-primary"><i class="bx bx-list-ol"></i> Fund Transfer List</a> 
                </div>
            </div>
            <hr>

            <div class="row">
                
                <div class="col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary">
                            <h5 class="mb-0 text-white">Fund Transfer (Credit/Debit)</h5>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ route('fund-send-store') }}" id="submit-form" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <div class="form-group">
                                        <label for="wallet_type">Ledger Type <code>*</code></label>
                                        <select class="form-control select2 @error('ledger_type') is-invalid @enderror" name="ledger_type" id="ledger_type">
                                            <option value="">Select Ledger Type</option>
                                            <option value="1" {{old('ledger_type') == '1'? 'selected':''}}>Transfer</option>
                                            <option value="2" {{old('ledger_type') == '2'? 'selected':''}}>Deduct</option>
                                        </select>
                                        @error('ledger_type')
                                            <span  class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>  
                                <div class="mb-3" hidden>
                                    <div class="form-group">
                                        <label for="wallet_type">Balance Type <code>*</code></label>
                                        <select class="form-control select2 @error('wallet_type') is-invalid @enderror" name="wallet_type" id="wallet_type">
                                            {{-- <option value="">Select Balance Type</option> --}}
                                            {{-- <option value="DMT" {{old('wallet_type') == 'DMT'? 'selected':''}}>Points</option> --}}
                                            <option value="MAIN" {{old('wallet_type') == 'MAIN'? 'selected':'selected'}}>Main</option>
                                        </select>
                                        @error('wallet_type')
                                            <span  class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>        
                                <div class="mb-3">
                                    <div class="form-group">
                                    <label class="control-label" for="phone_number">Phone Number<code>*</code></label>
                                    <input type="number" id="phone_number" name="phone_number" class="form-control form-control-sm @error('phone_number') is-invalid @enderror" placeholder="Enter Phone Number." value="{{ old('phone_number') }}" onblur="getUserByPhone(this.value)" required>
                                    @error('phone_number')
                                            <span  class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                    </div>
                                </div> 
                                <div class="mb-3">
                                    <div class="form-group">
                                    <label class="control-label" for="amount">Amount <code>Min: 1 - Max: 1000000000</code></label>
                                    <input type="number" id="amount" name="amount" class="form-control form-control-sm @error('amount') is-invalid @enderror" placeholder="Enter Amount." value="{{old('amount')}}" min="1" max="1000000000">
                                    @error('amount')
                                            <span  class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    Amount in words -: <span id="amount_in_words"></span>
                                </div>
                                <div class="mb-3">
                                    <div class="form-group">
                                    <label class="control-label" for="remark">Remark</label>
                                    <input type="text" id="remark" name="remark" class="form-control form-control-sm @error('remark') is-invalid @enderror" placeholder="Enter Remark." value="{{old('remark')}}">
                                    @error('remark')
                                            <span  class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <span id="errors"></span>
                                </div>
                                <button type="submit" class="btn btn-warning w-100">Transfer Now</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card border-warning" id="userInfoCard" style="display:none;">
                        <div class="card-header bg-transparent text-center">
                            <strong>Receiver Details</strong>
                        </div>
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <div class="rounded-circle bg-secondary text-white d-flex justify-content-center align-items-center mx-auto" 
                                    style="width: 60px; height: 60px; font-size: 24px;">
                                    <span id="userInitial">U</span>
                                </div>
                            </div>
                            
                            <h5 class="card-title"><span id="show_name">...</span></h5>
                            <p class="text-muted mb-1">Code : <span id="show_code">...</span></p>
                            <p class="text-muted mb-1">Email : <span id="show_email">...</span></p>
                            <p class="text-muted mb-1">Phone No. : <span id="show_phone">...</span></p>
                            <p class="text-muted mb-1">Main Balance : <span id="main_balance">...</span></p>
                            <span class="badge bg-success">Active User</span>
                        </div>
                    </div>
                    <div class="card border-warning" id="defaultInfo">
                        <div class="alert alert-info m-3">
                            Enter a phone number to see the user details here.
                        </div>
                    </div>
                </div>

            </div>

  
        </div>
    </div>
@endsection
@push('scripts')
<script>
function getUserByPhone(phone) {
    if (!phone) return;
    $('#errors').text('');
    const findUserRoute = "{{ route('find-user-name') }}";
    let infoCard = $('#userInfoCard');
    let defaultInfo = $('#defaultInfo');

    fetch(`${findUserRoute}?phone=${phone}`)
        .then(res => res.json())
        .then(data => {
            console.log(data.user.phone_number);
            if (data.status === 'success') {
                $('#userInitial').text(data.user.name.charAt(0)); 
                $('#show_name').text(data.user.name);
                $('#show_email').text(data.user.email);
                $('#show_phone').text(data.user.phone_number);
                $('#show_code').text(data.user.code);
                // $('#points').text(Number(data.wallet.bonus_balance ?? 0).toFixed(2));
                $('#main_balance').text(Number(data.wallet.main_balance ?? 0).toFixed(2));
                infoCard.show();    // Show the info card
                defaultInfo.hide(); // Hide the default info
            } else {
                $('#errors').text('User not found');
                infoCard.hide();    // Hide the info card
                defaultInfo.show(); // Show the default info
            }
        })
        .catch(err => {
            console.log(err);
            $('#errors').text('Error fetching user');
            infoCard.hide();    // Hide the info card
            defaultInfo.show(); // Show the default info
        });
}
</script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const amountInput = document.getElementById('amount');
    const amountInWords = document.getElementById('amount_in_words');

    amountInput.addEventListener('keydown', function (e) {
      if (['e', 'E', '+', '-'].includes(e.key)) {
        e.preventDefault();
      }
    });

    amountInput.addEventListener('input', function () {
      const value = this.value;
      const [wholePart, decimalPart] = value.split('.');

      let num = parseInt(wholePart);
      const min = parseInt(this.min);
      const max = parseInt(this.max);

      if (isNaN(num)) {
        amountInWords.textContent = '';
        return;
      }

      if (num < min) {
        this.value = min;
        num = min;
      } else if (num > max) {
        this.value = max;
        num = max;
      }

      let wholePartInWords = numberToWords(num);
      let decimalPartInWords = '';

      if (decimalPart) {
        decimalPartInWords = ' Point ' + decimalToWords(decimalPart);
      }

      amountInWords.textContent = wholePartInWords + decimalPartInWords;
    });

    function numberToWords(num) {
      const a = [
        '', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine', 'Ten',
        'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen',
        'Seventeen', 'Eighteen', 'Nineteen'
      ];
      const b = ['', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'];

      function inWords(n) {
        if (n < 20) return a[n];
        if (n < 100) return b[Math.floor(n / 10)] + (n % 10 ? ' ' + a[n % 10] : '');
        if (n < 1000) return a[Math.floor(n / 100)] + ' Hundred' + (n % 100 ? ' ' + inWords(n % 100) : '');
        if (n < 100000) return inWords(Math.floor(n / 1000)) + ' Thousand' + (n % 1000 ? ' ' + inWords(n % 1000) : '');
        if (n < 10000000) return inWords(Math.floor(n / 100000)) + ' Lakh' + (n % 100000 ? ' ' + inWords(n % 100000) : '');
        return inWords(Math.floor(n / 10000000)) + ' Crore' + (n % 10000000 ? ' ' + inWords(n % 10000000) : '');
      }

      return inWords(num);
    }

    function decimalToWords(decimalStr) {
      const digits = ['Zero', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine'];
      return Array.from(decimalStr).map(digit => digits[parseInt(digit)]).join(' ');
    }
  });
</script>
@endpush