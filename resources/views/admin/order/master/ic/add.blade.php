@extends('admin.layouts.app')

@section('content')

    <div class="card border-top border-0 border-4 border-primary">
        <div class="card-body">
            
            <div class="card-title d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="bx bx-file me-1 font-22 text-primary"></i>
                    <h5 class="mb-0 text-primary">Add I&C</h5>
                </div>
                <div>
                    <a href="{{ route('iac') }}" class="btn btn-primary"><i class="bx bx-list-ol"></i> I&C List</a> 
                </div>
            </div>
            <hr>
            
            <form action="{{ route('iac-add') }}" method="POST" class="row g-3" enctype="multipart/form-data">
                @csrf
                <div class="col-md-3">
                    <label for="name" class="form-label">Name <code>*</code></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Enter Name" value="{{ old('name') }}">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label for="price" class="form-label">Amount <code>*</code></label>
                    <input type="number" name="amount" step=".01" class="form-control @error('amount') is-invalid @enderror" id="amount" placeholder="Enter Amount" value="{{ old('amount') }}" required>
                    @error('amount')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary"><i class="bx bx-send"></i> Save</button>
                </div>
            </form>

        </div>
    </div>
@endsection


