@extends('admin.layouts.app')

@section('content')

    <div class="card border-top border-0 border-4 border-primary">
        <div class="card-body">
            
            <div class="card-title d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="bx bx-file me-1 font-22 text-primary"></i>
                    <h5 class="mb-0 text-primary">Add Client</h5>
                </div>
                <div>
                    <a href="{{ route('clients') }}" class="btn btn-primary"><i class="bx bx-list-ol"></i> Client List</a> 
                </div>
            </div>
            <hr>
            <form action="{{ route('client-store') }}" method="POST" class="row g-3" enctype="multipart/form-data">
            @csrf

            <div class="col-md-3">
                <label for="name" class="form-label">Name <code>*</code></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Enter Name" value="{{ old('name') }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-3">
                <label for="father_name" class="form-label">Father name</label>
                <input type="text" name="father_name" class="form-control @error('father_name') is-invalid @enderror" placeholder="Enter Father Name" id="father_name" value="{{ old('father_name') }}">
                @error('father_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-3">
                <label for="mother_name" class="form-label">Mother Name</label>
                <input type="text" name="mother_name" class="form-control @error('mother_name') is-invalid @enderror" placeholder="Enter Mother Name" id="mother_name" value="{{ old('mother_name') }}">
                @error('mother_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-3">
                <label for="dob" class="form-label">Date Of Birth</label>
                <input type="date" name="dob" class="form-control @error('dob') is-invalid @enderror" id="dob" value="{{ old('dob') }}">
                @error('dob')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-3">
                <label for="gender" class="form-label">Gender <code>*</code></label>
                <select name="gender" class="form-select @error('gender') is-invalid @enderror" id="gender" required>
                    <option selected disabled value="">Choose...</option>
                    <option value="Male" @selected('Male' == old('gender'))>Male</option>
                    <option value="Female" @selected('Female' == old('gender'))>Female</option>
                    <option value="Other" @selected('Other' == old('gender'))>Other</option>
                </select>
                @error('gender')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-3">
                <label for="role_id" class="form-label">Role <code>*</code></label>
                <select name="role_id" class="form-select @error('role_id') is-invalid @enderror" id="role_id" required>
                    {{-- <option selected disabled value="">Choose...</option> --}}
                    @foreach ($roles as $role)
                    <option value="{{ $role->id }}" @selected($role->id == old('role_id'))>{{ $role->name }}</option>
                    @endforeach
                </select>
                @error('role_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="col-md-3">
                <label for="email" class="form-label">Email <code>*</code></label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" value="{{ old('email') }}" placeholder="Enter Email Address" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="col-md-3">
                <label for="phone_number" class="form-label">Phone Number <code>*</code></label>
                <input type="number" name="phone_number" class="form-control @error('phone_number') is-invalid @enderror" placeholder="Enter Phone Number" id="phone_number" value="{{ old('phone_number') }}" required>
                @error('phone_number')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <hr>
            <h6 class="mt-0">Address Details</h6>
            <div class="col-12">
                <label for="full_address" class="form-label">Address</label>
                <textarea class="form-control" id="full_address" name="full_address" placeholder="Address..." rows="3">{{old('full_address')}}</textarea>
            </div>

            
            <div class="col-md-3">
                <label for="country" class="form-label">country</label>
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

            <div class="col-md-3">
                <label for="state" class="form-label">State</label>
                <select name="state" class="single-select @error('state') is-invalid @enderror" id="state" onchange="getCities(this.value)">
                    <option selected disabled value="">Choose...</option>
                </select>
                @error('state')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-3">
                <label for="city" class="form-label">City</label>
                <select name="city" class="single-select @error('city') is-invalid @enderror" id="city">
                    <option selected disabled value="">Choose...</option>
                </select>
                @error('city')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-3">
                <label for="zip" class="form-label">Zip</label>
                <input type="text" name="zip" class="form-control @error('zip') is-invalid @enderror" id="zip" placeholder="Enter Zip" value="{{ old('zip') }}">
                @error('zip')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <hr>
            <h6 class="mt-0">Documents</h6>
            <div class="col-md-3">
                <h6>Upload Profile Image</h6>
                <input type="file" id="profile_image" name="profile_image" accept="image/*" hidden>
                <div class="upload-card" id="profile_imageCard">
                    <i class='bx bxs-cloud-upload icon'></i>
                    <p>Click to upload Profile<br><small>Max: 5MB</small></p>
                </div>
                <img src="" id="profile_imagePreview" class="upload-card preview-img" />
            </div>
            <div class="col-md-3">
                <h6>Upload Aadhar Front</h6>
                <input type="file" id="aadhar_image_front" name="aadhar_image_front" accept="image/*" hidden>
                <div class="upload-card" id="aadhar_image_frontCard">
                    <i class='bx bxs-cloud-upload icon'></i>
                    <p>Click to upload Aadhar Front<br><small>Max: 5MB</small></p>
                </div>
                <img src="" id="aadhar_image_frontPreview" class="upload-card preview-img" />
            </div>
            <div class="col-md-3">
                <h6>Upload Aadhar Back</h6>
                <input type="file" id="aadhar_image_back" name="aadhar_image_back" accept="image/*" hidden>
                <div class="upload-card" id="aadhar_image_backCard">
                    <i class='bx bxs-cloud-upload icon'></i>
                    <p>Click to upload Aadhar Back<br><small>Max: 5MB</small></p>
                </div>
                <img src="" id="aadhar_image_backPreview" class="upload-card preview-img" />
            </div>
            <div class="col-md-3">
                <h6>Upload Pan Card</h6>
                <input type="file" id="pan_image" name="pan_image" accept="image/*" hidden>
                <div class="upload-card" id="pan_imageCard">
                    <i class='bx bxs-cloud-upload icon'></i>
                    <p>Click to upload Pan Card<br><small>Max: 5MB</small></p>
                </div>
                <img src="" id="pan_imagePreview" class="upload-card preview-img" />
            </div>
            <div class="col-md-3">
                <label for="password" class="form-label">Password<code>*</code></label>
                <input type="text" name="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Enter Password" value="{{ old('password') }}" required>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>         
            <div class="col-md-3">
                <label for="password_confirmation" class="form-label">Password Confirm<code>*</code></label>
                <input type="text" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" placeholder="Enter Password Confirm" value="{{ old('password_confirmation') }}" required>
                @error('password_confirmation')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-3">
                <label for="aadhar_number" class="form-label">Aadhar Number</label>
                <input type="text" name="aadhar_number" class="form-control @error('aadhar_number') is-invalid @enderror" id="aadhar_number" placeholder="Enter Aadhar Number" value="{{ old('aadhar_number') }}">
                @error('aadhar_number')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-3">
                <label for="pan_number" class="form-label">Pan Number</label>
                <input type="text" name="pan_number" class="form-control @error('pan_number') is-invalid @enderror" id="pan_number" placeholder="Enter Pan Number" value="{{ old('pan_number') }}">
                @error('pan_number')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12">
                <div class="form-check">
                    <input class="form-check-input @error('terms') is-invalid @enderror" type="checkbox" name="terms" id="terms" {{ 'on' == old('terms') ? 'checked':'' }} required>
                    <label class="form-check-label" for="terms">Agree to terms and conditions</label>
                    @error('terms')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Submit form</button>
                </div>
            </form>

        </div>
    </div>
@endsection
@push('scripts')
    @if ($errors->any() || session('error'))
        <script>
            $(document).ready(function() {
                getCities('{{ old('state') }}', '{{ old('city') }}');
            });
        </script>
    @endif
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
		// $('.multiple-select').select2({
		// 	theme: 'bootstrap4',
		// 	width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
		// 	placeholder: $(this).data('placeholder'),
		// 	allowClear: Boolean($(this).data('allow-clear')),
		// });
	</script>
@endpush