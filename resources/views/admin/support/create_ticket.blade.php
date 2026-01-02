@extends('admin.layouts.app')

@section('content')

    <div class="card border-top border-0 border-4 border-primary">
        <div class="card-body">
            
            <div class="card-title d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="bx bx-file me-1 font-22 text-primary"></i>
                    <h5 class="mb-0 text-primary">Create Ticket</h5>
                </div>
                <div>
                    <a href="{{ route('tickets') }}" class="btn btn-primary"><i class="bx bx-list-ol"></i> Open Ticket  List</a> 
                </div>
            </div>
            <hr>
            
            <form action="{{ route('ticket-store') }}" method="POST" class="row g-3" enctype="multipart/form-data">
                @csrf

                <div class="col-md-4">
                    <label for="request_for" class="form-label"> Request For<code>*</code></label>
                    <select name="request_for" class="form-select @error('request_for') is-invalid @enderror" id="request_for">
                        <option selected disabled value="">Choose...</option>
                         <option value="Account Related" @selected('Account Related' == old('request_for'))>Account Related</option>
                        <option value="Transaction Related" @selected('Transaction Related' == old('request_for'))>Transaction Related</option>
                        <option value="User Role Related" @selected('User Role Related' == old('request_for'))>User Role Related</option>
                        <option value="Other" @selected('Other' == old('request_for'))>Other</option>
    
                    </select>
                    @error('request_for')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="subject" class="form-label">Subject<code>*</code></label>
                    <input type="text" name="subject" class="form-control @error('subject') is-invalid @enderror" id="subject" placeholder="Enter Subject" value="{{ old('subject') }}">
                    @error('subject')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="file" class="form-label">File</label>
                    <input type="file" name="file" class="form-control @error('file') is-invalid @enderror" id="file" placeholder="Add file" value="{{ old('file') }}">
                    @error('file')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>


                <div class="col-md-12">
                    <label for="description" class="form-label">Description<code>*</code></label>
                    <textarea id="editor" class="form-control @error('description') is-invalid @enderror" name="description">{!! old('description') !!}</textarea>
                    @error('description')
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
