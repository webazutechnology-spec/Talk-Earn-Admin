@extends('admin.layouts.app')

@section('content')

    <div class="card border-top border-0 border-4 border-primary">
        <div class="card-body">
            
            <div class="card-title d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="bx bx-file me-1 font-22 text-primary"></i>
                    <h5 class="mb-0 text-primary">Add Country</h5>
                </div>
                <div>
                    <a href="{{ route('countries') }}" class="btn btn-primary"><i class="bx bx-list-ol"></i> Country List</a> 
                </div>
            </div>
            <hr>
            <form action="{{ route('country-store') }}" method="POST" class="row g-3" enctype="multipart/form-data">
                @csrf

                <div class="col-md-3">
                    <label for="name" class="form-label">Name <code>*</code></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Enter Name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3">
                    <label for="iso2" class="form-label">Iso 2 <code>*</code></label>
                    <input type="text" name="iso2" class="form-control @error('iso2') is-invalid @enderror" id="iso2" placeholder="Enter iso 2" value="{{ old('iso2') }}" required>
                    @error('iso2')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3">
                    <label for="iso3" class="form-label">Iso 3 <code>*</code></label>
                    <input type="text" name="iso3" class="form-control @error('iso3') is-invalid @enderror" placeholder="Enter iso 3" id="iso3" value="{{ old('iso3') }}">
                    @error('iso3')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3">
                    <label for="phonecode" class="form-label">Phone Code <code>*</code></label>
                    <input type="text" name="phonecode" class="form-control @error('phonecode') is-invalid @enderror" placeholder="Enter phone code" id="phonecode" value="{{ old('phonecode') }}">
                    @error('phonecode')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3">
                    <label for="capital" class="form-label">Capital <code>*</code></label>
                    <input type="text" name="capital" class="form-control @error('capital') is-invalid @enderror" placeholder="Enter capital" id="capital" value="{{ old('capital') }}">
                    @error('capital')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3">
                    <label for="currency" class="form-label">Currency <code>*</code></label>
                    <input type="text" name="currency" class="form-control @error('currency') is-invalid @enderror" placeholder="Enter currency" id="currency" value="{{ old('currency') }}">
                    @error('currency')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3">
                    <label for="currency_symbol" class="form-label">Currency Symbol <code>*</code></label>
                    <input type="text" name="currency_symbol" class="form-control @error('currency_symbol') is-invalid @enderror" placeholder="Enter currency symbol" id="currency_symbol" value="{{ old('currency_symbol') }}">
                    @error('currency_symbol')
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