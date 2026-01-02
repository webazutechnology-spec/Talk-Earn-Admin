@extends('admin.layouts.app')

@section('content')
    <div class="card border-top border-0 border-4 border-primary">
        <div class="card-body">
            
            <div class="card-title d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="bx bxs-file me-1 font-22 text-primary"></i>
                    <h5 class="mb-0 text-primary">Whatsapp Templates</h5>
                </div>
                <div>
                    <a href="{{ route('whatsapp-template-add') }}" class="btn btn-primary"><i class="bx bx-plus"></i> Add Templates</a>
                </div>
            </div>
            <hr>
            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Slug (Your Code)</th>
                            <th>Template</th>
                            <th>Mappings</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $value)
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td>
                                {{ $value->slug }}
                            </td>
                            <td>
                                {{ $value->template_name }} <span class="text-xs text-gray-400">({{ $value->language }})</span>
                            </td>
                            <td>
                                <button type="button" 
                                        class="btn btn-sm btn-outline-primary" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#viewMappingsModal"
                                        data-slug="{{ $value->slug }}"
                                        data-mappings="{{ json_encode($value->variable_mapping) }}">
                                    ({{ count($value->variable_mapping ?? []) }}) Vars
                                </button>
                            </td>
                            <td>
                                <div class="d-flex">
                                    <span class="order-actions-primary">
                                        <a href="{{ route('whatsapp-template-edit', ['id' => $value->id]) }}" class="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Edit"><i class="bx bx-edit"></i></a>
                                    </span>
                                    @if(empty($value->deleted_at))
                                    <span class="order-actions-primary">
                                        <a href="{{ route('whatsapp-template-delete', ['id' => $value->id]) }}" class="ms-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Delete"><i class="bx bx-trash"></i></a>
                                    </span>
                                    @else
                                    <span class="order-actions-danger">
                                        <a href="{{ route('whatsapp-template-delete', ['id' => $value->id]) }}" class="ms-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Restore"><i class="bx bx-revision"></i></a>
                                    </span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Shared View Mappings Modal --}}
    <div class="modal fade" id="viewMappingsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Mappings for <span id="modalTemplateSlug" class="text-primary"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-secondary small mb-3">
                        These define how your data is sent to the WhatsApp API.
                    </div>
                    <ul class="list-group" id="modalMappingsList">
                        {{-- JS will populate this --}}
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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

		$('.buttons-copys').on('click', () => table.button('.buttons-copy').trigger());
		$('.buttons-excels').on('click', () => table.button('.buttons-excel').trigger());
		$('.buttons-pdfs').on('click', () => table.button('.buttons-pdf').trigger());
		$('.buttons-csvs').on('click', () => table.button('.buttons-csv').trigger());
		$('.buttons-prints').on('click', () => table.button('.buttons-print').trigger());
    } );
</script>
<script>
    // Script to populate the modal dynamically when a button is clicked
    var viewMappingsModal = document.getElementById('viewMappingsModal')
    viewMappingsModal.addEventListener('show.bs.modal', function (event) {
        // Button that triggered the modal
        var button = event.relatedTarget
        
        // Extract info from data-* attributes
        var slug = button.getAttribute('data-slug')
        var mappings = JSON.parse(button.getAttribute('data-mappings'))
        
        // Update the modal's content
        var modalTitle = viewMappingsModal.querySelector('#modalTemplateSlug')
        var modalList = viewMappingsModal.querySelector('#modalMappingsList')
        
        modalTitle.textContent = slug
        modalList.innerHTML = '' // Clear previous content

        if (!mappings || Object.keys(mappings).length === 0) {
            modalList.innerHTML = '<li class="list-group-item text-center text-muted">No mappings defined.</li>'
        } else {
            for (const [apiKey, dataKey] of Object.entries(mappings)) {
                var listItem = document.createElement('li')
                listItem.className = 'list-group-item d-flex justify-content-between align-items-center'
                listItem.innerHTML = `
                    <span class="font-monospace text-muted">${apiKey}</span>
                    <span class="mx-2">&rarr;</span>
                    <span class="fw-bold text-dark">${dataKey}</span>
                `
                modalList.appendChild(listItem)
            }
        }
    })
</script>
@endpush