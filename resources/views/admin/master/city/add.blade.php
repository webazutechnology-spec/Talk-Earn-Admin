@extends('admin.layouts.app')

@section('content')

    <div class="card border-top border-0 border-4 border-primary">
        <div class="card-body">
            
            <div class="card-title d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="bx bx-file me-1 font-22 text-primary"></i>
                    <h5 class="mb-0 text-primary">Add City</h5>
                </div>
                <div>
                    <a href="{{ route('cities') }}" class="btn btn-primary"><i class="bx bx-list-ol"></i> City List</a> 
                </div>
            </div>
            <hr>
            
            <form action="{{ route('city-add') }}" method="POST" class="row g-3" enctype="multipart/form-data">
                @csrf

                <div class="col-md-3">
                    <label for="country_id" class="form-label">Country</label>
                    <select name="country_id" class="single-select @error('country_id') is-invalid @enderror" id="country_id" onchange="getStates(this.value)">
                        <option selected disabled value="">Choose...</option>
                        @foreach ($countrie as $country)
                        <option value="{{ $country->id }}" @selected($country->id == old('country_id'))>{{ $country->name }}</option>
                        @endforeach
                    </select>
                    @error('country_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label for="state_id" class="form-label">State</label>
                    <select name="state_id" class="single-select @error('state_id') is-invalid @enderror" id="state">
                        <option selected disabled value="">Choose...</option>
                    </select>
                    @error('state_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label for="name" class="form-label">Name <code>*</code></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Enter Name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3">
                    <label for="latitude" class="form-label">Latitude <code>*</code></label>
                    <input type="text" name="latitude" class="form-control @error('latitude') is-invalid @enderror" placeholder="Enter latitude" id="latitude" value="{{ old('latitude') }}">
                    @error('latitude')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3">
                    <label for="longitude" class="form-label">Longitude <code>*</code></label>
                    <input type="text" name="longitude" class="form-control @error('longitude') is-invalid @enderror" placeholder="Enter longitude" id="longitude" value="{{ old('longitude') }}">
                    @error('longitude')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>


                <hr>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary"><i class="bx bx-send"></i> Save</button>
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