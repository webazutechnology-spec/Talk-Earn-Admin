@extends('admin.layouts.app')

@section('content')

    <div class="card border-top border-0 border-4 border-primary">
        <div class="card-body">
            
            <div class="card-title d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="bx bx-file me-1 font-22 text-primary"></i>
                    <h5 class="mb-0 text-primary">Edit Template</h5>
                </div>
                <div>
                    <a href="{{ route('whatsapp-templates') }}" class="btn btn-primary"><i class="bx bx-list-ol"></i> Template List</a> 
                </div>
            </div>
            <hr>
                <form action="{{ route('whatsapp-template-update', $whatsappTemplate->id) }}" method="POST">
                @csrf
                {{-- Basic Fields --}}
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Template Name<code>*</code></label>
                        <input type="text" name="template_name" value="{{ $whatsappTemplate->template_name }}" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Language Code<code>*</code></label>
                        <input type="text" name="language" value="en" class="form-control" required>
                    </div>
                </div>

                {{-- Dynamic Mapping Section --}}
                <div class="mb-4 border-top pt-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3 class="h5 mb-0 font-weight-bold">Variable Mappings</h3>
                        <button type="button" onclick="addMappingRow()" class="btn btn-secondary btn-sm">+ Add Field</button>
                    </div>
                    <div class="alert alert-info py-2 px-3 mb-3 small">
                        <p class="mb-1"><strong>Logic:</strong> Map the <em>API Field</em> (what FlexGo needs) to your <em>Data Key</em> (what you pass in the array).</p>
                        <p class="mb-0">Example: API Field "field_1" maps to Data Key "otp"</p>
                        <p><strong>Dynamic Variables:</strong>{title} {name} {code} {number} {email} {otp} {message} {date} {link} {trans_id} {other}</p>
                    </div>
                    <div id="mapping-container">
                        <div class="row mb-2 mapping-row align-items-center">
                            <div class="col-6">
                                <label class="form-label fw-bold">API Params<code>*</code></label>
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-bold">Input Name<code>*</code></label>
                            </div>
                        </div>
                        @php $i = 0; @endphp
                        @if($whatsappTemplate->variable_mapping)
                            @foreach($whatsappTemplate->variable_mapping as $apiKey => $dataKey)
                                <div class="row mb-2 mapping-row align-items-center">
                                    <div class="col-6">
                                        <input type="text" name="mappings[{{ $i }}][api_key]" value="{{ $apiKey }}" placeholder="API Field" class="form-control" required>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group">
                                            <input type="text" name="mappings[{{ $i }}][data_key]" value="{{ $dataKey }}" placeholder="Data Key" class="form-control" required>
                                            <button type="button" onclick="removeRow(this)" class="btn btn-outline-danger">X</button>
                                        </div>
                                    </div>
                                </div>
                                @php $i++; @endphp
                            @endforeach
                        @else 
                             {{-- Empty row fallback --}}
                             <div class="row mb-2 mapping-row align-items-center">
                                <div class="col-6">
                                    <input type="text" name="mappings[0][api_key]" placeholder="API Field" class="form-control">
                                </div>
                                <div class="col-6">
                                    <div class="input-group">
                                        <input type="text" name="mappings[0][data_key]" placeholder="Data Key" class="form-control">
                                        <button type="button" onclick="removeRow(this)" class="btn btn-outline-danger">X</button>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Update Template</button>
                </div>
            </form>

        </div>
    </div>
@endsection
@push('scripts')
<script>
    let rowId = {{ $i + 1 }};
    function addMappingRow() {
        const container = document.getElementById('mapping-container');
        const html = `
            <div class="row mb-2 mapping-row align-items-center">
                <div class="col-6">
                    <input type="text" name="mappings[${rowId}][api_key]" placeholder="API Field (e.g. field_1)" class="form-control" required>
                </div>
                <div class="col-6">
                    <div class="input-group">
                        <input type="text" name="mappings[${rowId}][data_key]" placeholder="Your Data Key" class="form-control" required>
                        <button type="button" onclick="removeRow(this)" class="btn btn-outline-danger">X</button>
                    </div>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
        rowId++;
    }

    function removeRow(btn) {
        btn.closest('.mapping-row').remove();
    }
</script>
@endpush