@extends('admin.layouts.app')

@section('content')

    <div class="card border-top border-0 border-4 border-primary">
        <div class="card-body">
            
            <div class="card-title d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="bx bx-file me-1 font-22 text-primary"></i>
                    <h5 class="mb-0 text-primary">Add Lead</h5>
                </div>
                <div>
                    <a href="{{ route('leads') }}" class="btn btn-primary"><i class="bx bx-list-ol"></i> Lead List</a> 
                </div>
            </div>
            <hr>
            <form action="{{ route('lead-update',['id' => $data->id]) }}" method="POST">
                @csrf

                {{-- Basic Fields --}}
                <div class="row mb-3">
                    <div class="col-md-4 mb-3">
                        <label for="user_name" class="form-label">Client Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('user_name') is-invalid @enderror" 
                               id="user_name" name="user_name" value="{{ old('user_name', $data->user_name) }}" required>
                        @error('user_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="company_name" class="form-label">Company Name</label>
                        <input type="text" class="form-control" id="company_name" name="company_name" value="{{ old('company_name', $data->company_name) }}">
                    </div>
     
                    <div class="col-md-4 mb-3">
                        <label for="phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                               id="phone" name="phone" value="{{ old('phone', $data->phone) }}" required>
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $data->email) }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="source" class="form-label">Lead Source <span class="text-danger">*</span></label>
                        <select class="form-select" id="source" name="source">
                            <option value="Website" @selected('Website' == old('source', $data->source))>Website</option>
                            <option value="Referral" @selected('Referral' == old('source', $data->source))>Referral</option>
                            <option value="Social Media" @selected('Social Media' == old('source', $data->source))>Social Media</option>
                            <option value="Other" @selected('Other' == old('source', $data->source))>Other</option>
                        </select>
                    </div>                    
                    @if(auth()->user()->role_id == 1 || auth()->user()->role_id == 2)
                    <div class="col-md-4 mb-3">
                        <label for="lead_price" class="form-label">Lead Price</label>
                        <input type="number" class="form-control" id="lead_price" name="lead_price" value="{{ old('lead_price', $data->lead_price) }}">
                    </div>
                    @endif
                    </div>
                    <div class="row mb-3">
                    <div class="col-md-3">
                        <label for="country" class="form-label">country <span class="text-danger">*</span></label>
                        <select name="country" class="single-select @error('country') is-invalid @enderror" id="country" onchange="getStates(this.value)">
                            <option selected disabled value="">Choose...</option>
                            @foreach ($countrie as $country)
                            <option value="{{ $country->id }}" @selected($country->id == old('country', $country_id))>{{ $country->name }}</option>
                            @endforeach
                        </select>
                        @error('country')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label for="state" class="form-label">State <span class="text-danger">*</span></label>
                        <select name="state" class="single-select @error('state') is-invalid @enderror" id="state" onchange="getCities(this.value)">
                            <option selected disabled value="">Choose...</option>                    
                            @foreach ($states as $state)
                            <option value="{{ $state->id }}" @selected($state->id == old('state', $data->state_id))>{{ $state->name }}</option>
                            @endforeach
                        </select>
                        @error('state')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label for="city" class="form-label">City</label>
                        <select name="city" class="single-select @error('city') is-invalid @enderror" id="city">
                            <option selected disabled value="">Choose...</option>
                            @foreach ($cities as $city)
                            <option value="{{ $city->id }}" @selected($city->id == old('city', $data->city_id))>{{ $city->name }}</option>
                            @endforeach
                        </select>
                        @error('city')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label for="zip" class="form-label">Zip</label>
                        <input type="text" name="zip" class="form-control @error('zip') is-invalid @enderror" id="zip" placeholder="Enter Zip" value="{{ old('zip', $data->zip_code) }}">
                        @error('zip')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

  
                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <textarea class="form-control" id="address" name="address" rows="2">{{ old('address', $data->address) }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="source_description" class="form-label">Source Description / Notes</label>
                    <textarea class="form-control" id="source_description" name="source_description" rows="2" placeholder="Any extra details about where this lead came from">{{ old('source_description', $data->source_description) }}</textarea>
                </div>
                
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary">Update Lead</button>
                </div>

                </div>

            </form>

        </div>
    </div>
@endsection
@push('scripts')
<script>
    $('.single-select').select2({
        theme: 'bootstrap4',
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        placeholder: $(this).data('placeholder'),
        allowClear: Boolean($(this).data('allow-clear')),
    });
</script>
@endpush