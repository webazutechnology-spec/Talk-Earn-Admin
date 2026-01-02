@extends('admin.layouts.app')

@section('content')
    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
        <div class="col">
            <div class="card radius-15">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Total Clients</p>
                            <h4 class="my-1">{{ number_format($total) }}</h4>
                        </div>
                        <div class="widgets-icons bg-light-success text-success ms-auto"><i class="bx bxs-group"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-15">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Active Clients</p>
                            <h4 class="my-1">{{ number_format($notDeleted) }}</h4>
                        </div>
                        <div class="widgets-icons bg-light-info text-info ms-auto"><i class='bx bxs-user-check'></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-15">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Inactive Clients</p>
                            <h4 class="my-1">{{ number_format($deleted) }}</h4>
                        </div>
                        <div class="widgets-icons bg-light-danger text-danger ms-auto"><i class='bx bxs-user-x'></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-15">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">New Clients</p>
                            <h4 class="my-1">{{ number_format($thisMonth) }}</h4>
                        </div>
                        <div class="widgets-icons bg-light-warning text-warning ms-auto"><i class='bx bxs-user-plus'></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card border-top border-0 border-4 border-primary">
        <div class="card-body">
            
            <div class="card-title d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="bx bxs-file me-1 font-22 text-primary"></i>
                    <h5 class="mb-0 text-primary">Clients</h5>
                </div>
                <div>
                    @include('admin._partial.table_buttons');
                </div>
            </div>
            <hr>
            <div class="table-responsive">
                @php
                    $profile = 'images/user-1.svg';
                @endphp
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sn.</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Role</th>
                            <th>Gender</th>
                            <th>DOB</th>
                            <th>Updated At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $value)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('images/profile/' . $value->image) }}" onerror="this.onerror=null;this.src='{{ asset($profile) }}';" class="product-img-2" alt="product img" style="margin-right: 8px;"> 
                                    <span>{{ $value->name }}<p class="m-0"><small>{{ $value->code }}</small></p></span>
                                </div>
                            </td>
                            <td>{{ $value->email }}</td>
                            <td>{{ $value->phone_number }}</td>
                            <td>{{ $value->roles->name }}</td>
                            <td>{{ $value->gender }}</td>
                            <td>{{ $value->dob }}</td>
                            <td>{{ $value->updated_at }}</td>
                            <td>
                                <div class="d-flex">
                                    <span class="order-actions-primary">
                                        <a href="{{ route('client-edit', ['id' => $value->id]) }}" class="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Edit"><i class="bx bx-edit"></i></a>
                                    </span>
                                    @if(empty($value->deleted_at))
                                    <span class="order-actions-primary">
                                        <a href="{{ route('client-delete', ['id' => $value->id]) }}" class="ms-1" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Delete"><i class="bx bx-trash"></i></a>
                                    </span>
                                    @else
                                    <span class="order-actions-danger">
                                        <a href="{{ route('client-delete', ['id' => $value->id]) }}" class="ms-1" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Restore"><i class="bx bx-revision"></i></a>
                                    </span>
                                    @endif
                                    <span class="order-actions-danger">
                                        <a href="javascript:;" class="ms-1 changePassBtn" data-userid="{{ $value->id }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Change Password"><i class="bx bx-key"></i></a>
                                    </span>
                                    <span class="order-actions-danger">
                                        <a href="" class="ms-1" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Impersonate"><i class="bx bx-mask"></i></a>
                                    </span>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="chnagePassword" tabindex="-1" data-bs-backdrop="static" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Change Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="changePasswordForm" action="{{ route('client-chnage-password') }}" method="POST">
                        @csrf
                        <input type="hidden" id="user_id" name="user_id">
                        <div class="mb-3">
                            <label for="password" class="form-label">Enter New Password</label>
                            <div class="input-group" id="show_hide_password">
                                <input type="password" class="form-control border-end-0" id="password" name="password" value="{{ old('user_id') }}" required placeholder="Enter Password"> 
                                <a href="javascript:;" class="input-group-text bg-transparent"><i class="bx bx-hide"></i></a>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Enter Confirm Password</label>
                            <div class="input-group" id="show_hide_password">
                                <input type="password" class="form-control border-end-0" id="confirm_password" name="confirm_password" required placeholder="Enter Password"> 
                                <a href="javascript:;" class="input-group-text bg-transparent"><i class="bx bx-hide"></i></a>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary"><i class="bx bx-lock"></i> changes Password</button>
                        </div>
                    </form>
                </div>

               
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
		
        var table = $('#example').DataTable( {
            lengthChange: true,
            buttons: [ 'copy', 'excel', 'csv', 'pdf', 'print'],
        });

		table.buttons().container().hide();
        // table.buttons().container().appendTo( '#example_wrapper .col-md-6:eq(0)' );

		$('.buttons-copys').on('click', () => table.button('.buttons-copy').trigger());
		$('.buttons-excels').on('click', () => table.button('.buttons-excel').trigger());
		$('.buttons-pdfs').on('click', () => table.button('.buttons-pdf').trigger());
		$('.buttons-csvs').on('click', () => table.button('.buttons-csv').trigger());
		$('.buttons-prints').on('click', () => table.button('.buttons-print').trigger());
    });

    $('.changePassBtn').on('click', function () {
        var userId = $(this).data('userid'); 
        $('#user_id').val(userId);
        $('#chnagePassword').modal('show');
    });
</script>
@if ($errors->any())
<script>
    $(document).ready(function() {
        var userId = "{{ old('user_id') }}"; 
        if(userId){
            $('#user_id').val(userId);
            $('#chnagePassword').modal('show');
        }
    });
</script>
@endif
@endpush