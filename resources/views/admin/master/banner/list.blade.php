@extends('admin.layouts.app')

@section('content')
				<div class="card border-top border-0 border-4 border-primary">
					<div class="card-body">
                        
						<div class="card-title d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <i class="bx bxs-file me-1 font-22 text-primary"></i>
                                <h5 class="mb-0 text-primary">Banners</h5>
                            </div>
							<div>
                                <a href="{{ route('banner-add') }}" class="btn btn-primary"><i class="bx bx-plus"></i> Add Banner</a>
                            </div>
                        </div>
                        <hr>
						<div class="table-responsive">
							<table id="example" class="table table-striped table-bordered" style="width:100%">
								<thead>
									<tr>
										<th>Sn.</th>
										<th>For</th>
										<th>Type</th>
										<th>Name</th>
										<th>Title</th>
										<th>Image/URL</th>
		                                 <th>Status</th>
										<th>Description</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($data as $key => $value)
									<tr>
										<td>{{ $key+1 }}</td>
										<td>{{ $value->for }}</td>
										<td>{{ $value->type }}</td>
										<td>{{ $value->name }}</td>
										<td>{{ $value->title }}</td>
										<td>@if($value->file_type =='image')
											  <img  src="{{ asset('images/banner/' . $value->image) }}" onerror="this.onerror=null;this.src='{{ asset('images/missing-image.png') }}';" class="product-img-2" alt="product img" style="margin-right: 8px; height:100px; width:100px;">
											 @else
											<iframe height="100" width="100" src="{{$value->url}}" frameborder="0"></iframe>
											
										@endif</td>
										{{-- <td><iframe height="100" width="100" src="{{$value->url}}" frameborder="0"></iframe></td> --}}
										{{-- <td>
                                           <img src="{{ asset('images/banner/' . $value->image) }}" onerror="this.onerror=null;this.src='{{ asset('images/missing-image.png') }}';" class="product-img-2" alt="product img" style="margin-right: 8px;">
                                        </td> --}}
                                        <td>{{$value->status}}</td>
                                        <td>{{$value->desc}}</td>
                                        <td>
                                            <div class="d-flex">
												<span class="order-actions-primary">
													<a href="{{ route('banner-edit', ['id' => $value->id]) }}" class="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Edit"><i class="bx bx-edit"></i></a>
												</span>
												@if(empty($value->deleted_at))
												<span class="order-actions-primary">
													<a href="{{ route('banner-delete', ['id' => $value->id]) }}" class="ms-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Delete"><i class="bx bx-trash"></i></a>
												</span>
												@else
												<span class="order-actions-danger">
													<a href="{{ route('banner-delete', ['id' => $value->id]) }}" class="ms-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Restore"><i class="bx bx-revision"></i></a>
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
@endpush