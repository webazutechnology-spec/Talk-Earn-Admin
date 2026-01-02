@extends('admin.layouts.app')

@section('content')
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <a href="{{ route('app-config') }}" type="button" class="btn {{ request()->route()->getName() == 'app-config' ? 'btn-primary':'btn-outline-primary' }} px-2 mr-2 me-3"><i class="bx bx-cog mr-1"></i>Config</a>
        <a href="{{ route('app-config-image') }}" type="button" class="btn {{ request()->route()->getName() == 'app-config-image' ? 'btn-primary':'btn-outline-primary' }} px-2"><i class="bx bx-image mr-1"></i>Image</a>
    </div>

    <div class="card border-top border-0 border-4 border-primary">
        <div class="card-body">
            <div class="card-title d-flex align-items-center">
                <div><i class="bx bxs-cog me-1 font-22 text-primary"></i>
                </div>
                <h5 class="mb-0 text-primary">Configuration Settings</h5>
            </div>
            <hr>
            <form class="row g-3" method="POST" action="{{ route('update-config') }}" enctype="multipart/form-data">
                @csrf
                @foreach ($data as $value)
                <div class="col-sm-3">
                    <div class="mb-6">
                        
                        <input  type="hidden" class="form-control" name="config_type" value="{{ request()->route()->getName() == 'app-config' ? 'data':'image' }}" />

                        @switch($value->value_type)
                            @case('text')
                            @case('email')
                            @case('password')
                            @case('url')
                            @case('time')
                            @case('date')
                            @case('month')
                            @case('color')
                            @case('range')
                            @case('hidden')
                                <label class="form-label" for="{{ $value->name }}"> {{ $value->title }} @if ($value->is_required ?? false) <span class="text-danger">*</span> @endif </label>
                                <input  type="{{ $value->value_type }}" class="form-control" id="{{ $value->name }}" name="{{ $value->name }}" placeholder="Enter {{ $value->title }}" value="{{ $value->value }}" />
                            @break
                            @case('textarea')
                                <label class="form-label" for="{{ $value->name }}"> {{ $value->title }} @if ($value->is_required ?? false) <span class="text-danger">*</span> @endif </label>
                                <textarea class="form-control" id="{{ $value->name }}" name="{{ $value->name }}" rows="2" placeholder="Enter {{ $value->title }}">{{ $value->value }}</textarea>
                            @break
                            @case('dropdown')
                                @php
                                    $options = json_decode($value->json_data ?? '[]', true);
                                @endphp
                                <label class="form-label" for="{{ $value->name }}"> {{ $value->title }} @if ($value->is_required ?? false) <span class="text-danger">*</span> @endif </label>
                                <select class="form-select" id="{{ $value->name }}" name="{{ $value->name }}">
                                    <option value="">Select {{ $value->title }}</option>
                                    @foreach ($options as $option)
                                        <option value="{{ $option }}" @selected($option == $value->value) > {{ $option }} </option>
                                    @endforeach
                                </select>
                            @break
                            @case('checkbox')
                                <input type="checkbox" id="{{ $value->name }}" name="{{ $value->name }}" value="1" @checked($value->value == 1)>
                                <label for="{{ $value->name }}"> {{ $value->title }} </label>
                            @break
                            @case('file')
                                <h6>Upload {{ $value->title }}</h6>
                                <input type="file" id="{{ str_replace('.', '_', $value->name) }}" name="{{ str_replace('.', '_', $value->name) }}" accept="image/*" hidden>
                                <div class="upload-card" id="{{ str_replace('.', '_', $value->name) }}Card" style="{{ !empty($value->value)?'display: none;':'' }}">
                                    <i class='bx bxs-cloud-upload icon'></i>
                                    <p>Click to upload {{ $value->title }}<br><small>Max: 5MB</small></p>
                                </div>
                                <img src="{{ asset('images/config/'.$value->value) }}" id="{{ str_replace('.', '_', $value->name) }}Preview" style="{{ !empty($value->value)?'display: block;':'' }}" class="upload-card preview-img" />
                            @break
                        @endswitch

                    </div>
                </div>
                @endforeach

                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-primary px-3"><i class="bx bx-save mr-1"></i> Update</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('scripts')

<script>
$(document).ready(function () {
    @foreach ($data as $value)
        @if($value->value_type == 'file')
            setupImageUpload("{{ str_replace('.', '_', $value->name) }}", "{{ str_replace('.', '_', $value->name) }}Card", "{{ str_replace('.', '_', $value->name) }}Preview");
        @endif
    @endforeach
});
</script>
@endpush