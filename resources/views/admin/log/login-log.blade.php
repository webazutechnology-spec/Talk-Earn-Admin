@extends('admin.layouts.app')

@section('content')
	<div class="card border-top border-0 border-4 border-primary">
		<div class="card-body p-0">
			<div class="accordion" id="accordionExample">
				<div class="accordion-item">
					<h2 class="accordion-header" id="headingOne">
						<button class="accordion-button text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
							<i class="bx bx-filter-alt font-18 text-primary me-1"></i> Filter
						</button>
					</h2>
					<div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
						<div class="accordion-body">	
							<form action="" method="POST" class="row g-3" enctype="multipart/form-data">
								@csrf

								<div class="col-md-3">
									<label for="created_at_from">From Date</label>
									<input type="date" name="created_at_from" id="created_at_from" class="form-control" value="{{ request()->created_at_from }}">
								</div>
							

								<div class="col-md-3">
									<label for="created_at_to">To Date</label>
									<input type="date" name="created_at_to" id="created_at_to" class="form-control" value="{{ request()->created_at_to }}">
								</div>
								<hr>
								<div class="col-12 text-center">
									<button type="submit" class="btn btn-primary"><i class="bx bx-search"></i> Filter</button>
								</div>
							</form>
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
					<h5 class="mb-0 text-primary">Login Log</h5>
				</div>
				<div>
				</div>
			</div>
			<hr>
			<div class="table-responsive">
				<table id="example" class="table table-striped table-bordered" style="width:100%">
					<thead>
						<tr>
							<th>ID</th>
							<th>User Info</th>
							<th>Device</th>
							<th>Browser</th>
							<th>Operating System</th>
							<th>Request Info</th>
							<th>IP Address</th>
							<th>Location</th>
							<th>Created At</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($data as $key => $log)
							@php
								$profile = 'images/user-1.svg';
								if ($log['user_gender'] == 'Female') {
									$profile = 'images/user-2.svg';
								}
							@endphp
							<tr>
								<td>{{ $key+1 }}</td>
								<td>
									<div class="d-flex align-items-center">
										<img src="{{ asset('images/profile/' . $log['user_image']) }}" onerror="this.onerror=null;this.src='{{ asset($profile) }}';" class="product-img-2" alt="product img" style="margin-right: 8px;"> 
										<span>{{ $log['user_name'] }}<p class="m-0"><small>{{ $log['user_code'] }}</small></p></span>
									</div>
								</td>
								<td>
									@if($log['is_desktop'])
										<i class="bx bx-desktop text-primary"></i>
										Desktop
									@elseif($log['is_phone'])
										<i class="bx bx-mobile-alt text-success"></i>
										Phone
									@else
										<i class="bx bx-devices"></i>
										Device
									@endif
									<br>
									<small class="text-muted">{{ $log['device'] ?: 'Unknown' }}</small>
								</td>
								<td>
									<i class="bx bxl-chrome text-warning"></i>
									{{ $log['browser'] }} {{ $log['browser_ver'] }}
								</td>
								<td>
									<i class="bx bx-chip text-info"></i>
									{{ $log['os'] }} {{ $log['os_ver'] }}
								</td>
								<td>
									<button class="btn btn-sm showLogData" data-old='{{ $log['server'] }}' data-form='{{ $log['request'] }}'>
										<i class="bx bx-show-alt"></i>
									</button>
								</td>
								<td>{{ $log['ip'] }}</td>
								<td>{{ $log['location']}}</td>
								<td>{{ $log['created_at'] }}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<div class="modal fade" id="logDataModal" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">

				<div class="modal-header">
					<h5 class="modal-title">Log Details</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
				</div>

				<div class="modal-body">

					<h6><b>Old Data</b></h6>
					<pre id="oldDataBox" class="bg-light p-3 rounded"></pre>

					<hr>

					<h6><b>Form Data</b></h6>
					<pre id="formDataBox" class="bg-light p-3 rounded"></pre>

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
    });
		
</script>
<script>
function convertToReadable(json) {
    let obj = {};
    try { obj = JSON.parse(json); } catch(e) { return json; }

    let output = "";

    Object.entries(obj).forEach(([key, value]) => {
        if(key === "_token") return;
        let label = key.replace(/_/g," ").replace(/\b\w/g, c => c.toUpperCase());
        output += `${label}: ${value}\n`;
    });

    return output.trim();
}

document.addEventListener('click', function (e) {
    if (e.target.closest('.showLogData')) {

        let btn = e.target.closest('.showLogData');

        let oldData = convertToReadable(btn.dataset.old);
        let formData = convertToReadable(btn.dataset.form);

        document.getElementById('oldDataBox').textContent = oldData;
        document.getElementById('formDataBox').textContent = formData;

        new bootstrap.Modal(document.getElementById('logDataModal')).show();
    }
});
</script>
@endpush