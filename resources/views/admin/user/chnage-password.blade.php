@extends('admin.layouts.app')

@section('content')
<div class="card radius-15">
    <div class="card-body">
        <div class="mb-4">
            <h4>Security Settings</h4>
            <p class="text-muted">These settings help you keep your account secure.</p>
        </div>
    </div>

    <div class="card-body border-bottom">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <h6 class="mb-1">Save my Activity Logs</h6>
                <p class="text-muted mb-0">You can save all your activity logs including unusual activity detected.</p>
            </div>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" checked id="activity-log">
                <label class="form-check-label" for="activity-log"></label>
            </div>
        </div>
    </div>

    <div class="card-body border-bottom">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <h6 class="mb-1">Change Password</h6>
                <p class="text-muted mb-0">Set a unique password to protect your account.</p>
            </div>
            <div class="d-flex align-items-center gap-3">
                <a href="#" class="btn btn-primary">Change Password</a>
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <h6 class="mb-1">
                    2 Factor Auth 
                    <span class="badge bg-success">Enabled</span>
                </h6>
                <p class="text-muted mb-0">
                    Secure your account with 2FA. When activated you will need to enter a special code using your mobile app.
                </p>
            </div>
            <a href="#" class="btn btn-primary">Disable</a>
        </div>
    </div>

</div>

<div class="card radius-15">
    <div class="card-body">
        <div class="d-flex align-items-center">
            <div>
                <h6 class="mb-0">Recent Orders</h6>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table" style="width:100%">
                <thead>
                    <tr>
                        <th>Sn.</th>
                        <th>Device</th>
                        <th>Browser</th>
                        <th>Operating System</th>
                        <th>IP Address</th>
                        <th>Last Active</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sessions as $key => $s)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>
                                @if($s['is_desktop'])
                                    <i class="bx bx-desktop text-primary"></i>
                                    Desktop
                                @elseif($s['is_phone'])
                                    <i class="bx bx-mobile-alt text-success"></i>
                                    Phone
                                @else
                                    <i class="bx bx-devices"></i>
                                    Device
                                @endif
                                <br>
                                <small class="text-muted">{{ $s['device'] ?: 'Unknown' }}</small>
                            </td>

                            <td>
                                <i class="bx bxl-chrome text-warning"></i>
                                {{ $s['browser'] }} {{ $s['browser_ver'] }}
                            </td>

                            <td>
                                <i class="bx bx-chip text-info"></i>
                                {{ $s['os'] }} {{ $s['os_ver'] }}
                            </td>

                            <td>{{ $s['ip'] }}</td>

                            <td>
                                <span class="text-muted">
                                    {{ $s['last_active'] }}
                                </span>
                            </td>

                            <td class="text-end">
                                @if ($s['is_current'])
                                    <span class="btn btn-sm btn-success"><i class="bx bx-log-in-circle"></i></span>
                                @else
                                    <a href="{{ route('session-destroy', $s['id']) }}" class="btn btn-sm btn-danger"  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Logout">
                                        <i class="bx bx-log-out-circle"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@push('scripts')
@endpush