@extends('admin.layouts.app')

@section('content')

    <div class="card border-top border-0 border-4 border-primary">
        <div class="card-body">
            
            <div class="card-title d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="bx bx-file me-1 font-22 text-primary"></i>
                    <h5 class="mb-0 text-primary">Update State</h5>
                </div>
                <div>
                    <a href="{{ route('states') }}" class="btn btn-primary"><i class="bx bx-list-ol"></i> State List</a> 
                </div>
            </div>
            <hr>
            
            <form action="{{ route('state-update', ['id' => $data->id]) }}" method="POST" class="row g-3" enctype="multipart/form-data">
                @csrf

                <div class="col-md-3">
                    <label for="country_id" class="form-label">country</label>
                    <select name="country_id" class="single-select @error('country_id') is-invalid @enderror" id="country_id">
                        <option selected disabled value="">Choose...</option>
                        @foreach ($countrie as $country)
                        <option value="{{ $country->id }}" @selected($country->id == old('country_id', $data->country_id))>{{ $country->name }}</option>
                        @endforeach
                    </select>
                    @error('country_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label for="name" class="form-label">Name <code>*</code></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Enter Name" value="{{ old('name', $data->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3">
                    <label for="iso2" class="form-label">Iso 2 <code>*</code></label>
                    <input type="text" name="iso2" class="form-control @error('iso2') is-invalid @enderror" id="iso2" placeholder="Enter iso 2" value="{{ old('iso2', $data->iso2) }}" required>
                    @error('iso2')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3">
                    <label for="latitude" class="form-label">Latitude <code>*</code></label>
                    <input type="text" name="latitude" class="form-control @error('latitude') is-invalid @enderror" placeholder="Enter latitude" id="latitude" value="{{ old('latitude', $data->latitude) }}">
                    @error('latitude')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3">
                    <label for="longitude" class="form-label">Longitude <code>*</code></label>
                    <input type="text" name="longitude" class="form-control @error('longitude') is-invalid @enderror" placeholder="Enter longitude" id="longitude" value="{{ old('longitude', $data->longitude) }}">
                    @error('longitude')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>


                <hr>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary"><i class="bx bx-send"></i> Update</button>
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