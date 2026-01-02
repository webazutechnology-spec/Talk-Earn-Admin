@extends('admin.layouts.app')

@section('content')

    <div class="card border-top border-0 border-4 border-primary">
        <div class="card-body">
            
            <div class="card-title d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="bx bx-file me-1 font-22 text-primary"></i>
                    <h5 class="mb-0 text-primary">Update Role</h5>
                </div>
                <div>
                    <a href="{{ route('roles') }}" class="btn btn-primary"><i class="bx bx-list-ol"></i> Role List</a> 
                </div>
            </div>
            <hr>
            <form action="{{ route('role-update', ['id' => $data->id]) }}" method="POST" class="row g-3" enctype="multipart/form-data">
                @csrf
                <div class="col-md-3">
                    <label for="type" class="form-label">Type <code>*</code></label>
                    <select name="type" class="form-select @error('type') is-invalid @enderror" id="type" required>
                        <option selected disabled value="">Choose...</option>
                        <option value="Employee" @selected('Employee' == old('type', $data->type))>Employee</option>
                        <option value="User" @selected('User' == old('type', $data->type))>User</option>
                    </select>
                    @error('type')
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
                    <label for="order_by" class="form-label">Order By <code>*</code></label>
                    <input type="number" name="order_by" class="form-control @error('order_by') is-invalid @enderror" placeholder="Order By Name" id="order_by" value="{{ old('order_by', $data->order_by) }}">
                    @error('order_by')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3">
                    <label for="show" class="form-label">Show <code>*</code></label>
                    <select name="show" class="form-select @error('show') is-invalid @enderror" id="show" required>
                        <option selected disabled value="">Choose...</option>
                        <option value="Yes" @selected('Yes' == old('show', $data->show))>Yes</option>
                        <option value="No" @selected('No' == old('show', $data->show))>No</option>
                    </select>
                    @error('show')
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