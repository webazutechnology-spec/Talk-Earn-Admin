@extends('admin.layouts.app')

@section('content')

	<div class="card border-top border-0 border-4 border-primary">
		<div class="card-body">
            <div class="card-title d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="bx bxs-file me-1 font-22 text-primary"></i>
                    <h5 class="mb-0 text-primary">Menu List ({{ $role->name }})</h5>
                </div>
                <div style="display: flex;align-items: center;">
                    <select name="role_id" class="form-select @error('role_id') is-invalid @enderror me-2" id="roleSelect">
                        @foreach ($roles as $rvalue) 
                        <option value="{{ $rvalue->id }}" @selected($rvalue->id == $role_id)>{{ $rvalue->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <hr>
            <div class="table-responsive">
                <table class="table table-sm mb-0" style="width:100%">
                    <thead>
                        <tr>
                            <th>Menu</th>
                            <th>Sub Menu</th>
                            <th>Order By</th>
                            <th>View</th>
                            <th>Create</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $module)

                            <tr>
                                <td><h6 class="m-0">{{ $module->name }}</h6></td>
                                <td>-</td>
                                <td><input class="form-control form-control-sm" type="number" value="{{ $module->order }}" style="width: 50px;text-align: center;"></td>
                                @if($module->sub_modules->count())
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                @else
                                    @php
                                        $viewIds   = $module->role_id_view   ? explode(',', $module->role_id_view)   : [];
                                        $addIds    = $module->role_id_add    ? explode(',', $module->role_id_add)    : [];
                                        $updateIds = $module->role_id_update ? explode(',', $module->role_id_update) : [];
                                        $deleteIds = $module->role_id_delete ? explode(',', $module->role_id_delete) : [];
                                    @endphp
                                    <td>
                                        <div class="form-check form-switch m-0">
                                            <input type="checkbox" class="form-check-input"
                                                @disabled(empty($module->view_url) || $module->view_url == 'javascript:void(0)')
                                                @checked(in_array($role_id, $viewIds))
                                                onclick="acmSave('{{ $role_id }}','{{ $module->id }}','view',this)">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check form-switch m-0">
                                            <input type="checkbox" class="form-check-input"
                                                @disabled(empty($module->add_url) || $module->add_url == 'javascript:void(0)')
                                                @checked(in_array($role_id, $addIds))
                                                onclick="acmSave('{{ $role_id }}','{{ $module->id }}','add',this)">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check form-switch m-0">
                                            <input type="checkbox" class="form-check-input"
                                                @disabled(empty($module->update_url) || $module->update_url == 'javascript:void(0)')
                                                @checked(in_array($role_id, $updateIds))
                                                onclick="acmSave('{{ $role_id }}','{{ $module->id }}','update',this)">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check form-switch m-0">
                                            <input type="checkbox" class="form-check-input"
                                                @disabled(empty($module->delete_url) || $module->delete_url == 'javascript:void(0)')
                                                @checked(in_array($role_id, $deleteIds))
                                                onclick="acmSave('{{ $role_id }}','{{ $module->id }}','delete',this)">
                                        </div>
                                    </td>
                                @endif
                            </tr>
                            @foreach ($module->sub_modules as $subModule)
                                @php
                                    $viewIds   = $subModule->role_id_view   ? explode(',', $subModule->role_id_view)   : [];
                                    $addIds    = $subModule->role_id_add    ? explode(',', $subModule->role_id_add)    : [];
                                    $updateIds = $subModule->role_id_update ? explode(',', $subModule->role_id_update) : [];
                                    $deleteIds = $subModule->role_id_delete ? explode(',', $subModule->role_id_delete) : [];
                                @endphp

                                <tr>
                                    <td>
                                        <h6 class="m-0">-</h6>
                                    </td>
                                    <td>
                                        <h6 class="m-0">{{ $subModule->name }}</h6>
                                    </td>
                                    <td><input class="form-control form-control-sm" type="number" value="{{ $subModule->order }}" style="width: 50px;text-align: center;"></td>
                                    <td>
                                        <div class="form-check form-switch m-0">
                                            <input type="checkbox" class="form-check-input"
                                                @disabled(empty($subModule->view_url) || $subModule->view_url == 'javascript:void(0)')
                                                @checked(in_array($role_id, $viewIds))
                                                onclick="acmSave('{{ $role_id }}','{{ $subModule->id }}','view',this)">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check form-switch m-0">
                                            <input type="checkbox" class="form-check-input"
                                                @disabled(empty($subModule->add_url) || $subModule->add_url == 'javascript:void(0)')
                                                @checked(in_array($role_id, $addIds))
                                                onclick="acmSave('{{ $role_id }}','{{ $subModule->id }}','add',this)">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check form-switch m-0">
                                            <input type="checkbox" class="form-check-input"
                                                @disabled(empty($subModule->update_url) || $subModule->update_url == 'javascript:void(0)')
                                                @checked(in_array($role_id, $updateIds))
                                                onclick="acmSave('{{ $role_id }}','{{ $subModule->id }}','update',this)">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check form-switch m-0">
                                            <input type="checkbox" class="form-check-input"
                                                @disabled(empty($subModule->delete_url) || $subModule->delete_url == 'javascript:void(0)')
                                                @checked(in_array($role_id, $deleteIds))
                                                onclick="acmSave('{{ $role_id }}','{{ $subModule->id }}','delete',this)">
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
		</div>
	</div>


@endsection
@push('scripts')
<script>
    $(document).on('change', '#roleSelect', function () {
        let roleId = $(this).val();
        window.location.href = "{{ route('acm') }}?role_id=" + roleId;
    });
 
    function acmSave(roleId, moduleId, type, checkbox) {
        const isChecked = checkbox.checked; // simpler than jQuery .is(':checked')
        $.ajax({
            url: "{{ route('acm-save') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                role_id: roleId,
                module_id: moduleId,
                permission_type: type,
                isChecked: isChecked
            },
            success: function(response) {
                // Optional: show a small success toast instead of console.log
                if (response.status === 'success') {
                
                    Lobibox.notify('success', {
                        pauseDelayOnHover: true,
                        size: 'mini',
                        rounded: true,
                        delayIndicator: false,
                        icon: 'bx bx-check-circle',
                        continueDelayOnInactiveTab: false,
                        position: 'top right',
                        msg: response.message
                    });

                } else {
                    Lobibox.notify('error', {
                        pauseDelayOnHover: true,
                        size: 'mini',
                        rounded: true,
                        delayIndicator: false,
                        icon: 'bx bx-x-circle',
                        continueDelayOnInactiveTab: false,
                        position: 'top right',
                        msg: response.message
                    });
                }
            },
            error: function(xhr) {
                // console.error("AJAX Error:", xhr.responseText);
                Lobibox.notify('error', {
                    pauseDelayOnHover: true,
                    size: 'mini',
                    rounded: true,
                    delayIndicator: false,
                    icon: 'bx bx-x-circle',
                    continueDelayOnInactiveTab: false,
                    position: 'top right',
                    msg: "Failed to update permission. Please try again!"
                });
            }
        });
    }
</script>
<script>

    // $(document).ready(function() {
		
    //     var table = $('#example').DataTable( {
    //         lengthChange: true,
    //         buttons: [ 'copy', 'excel', 'csv', 'pdf', 'print'],
    //     });

	// 	table.buttons().container().hide();

	// 	$('.buttons-copys').on('click', () => table.button('.buttons-copy').trigger());
	// 	$('.buttons-excels').on('click', () => table.button('.buttons-excel').trigger());
	// 	$('.buttons-pdfs').on('click', () => table.button('.buttons-pdf').trigger());
	// 	$('.buttons-csvs').on('click', () => table.button('.buttons-csv').trigger());
	// 	$('.buttons-prints').on('click', () => table.button('.buttons-print').trigger());
    // });
		
	
	// $('.single-select').select2({
	// 	theme: 'bootstrap4',
	// 	width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
	// 	placeholder: $(this).data('placeholder'),
	// 	allowClear: Boolean($(this).data('allow-clear')),
	// });
</script>
@endpush