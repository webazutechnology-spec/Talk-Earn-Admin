@extends('admin.layouts.app')

@section('content')

<div class="row  product-grid">
					<div class="col">
						<div class="card">
							<iframe  height="500" src="{{$data->url}}" style="padding: 5px">
                               </iframe>
							<div class="card-body">
								<h6 class="card-title cursor-pointer"><b>Title :</b> {{$data->title}}</h6>
								<h6 class="small card-title cursor-pointer"><b>Category :</b>  {{$data->category->name??''}}</h6>
								<div class="card-title cursor-pointer mt-4"> {!! $data->description !!}</div>
                         
								{{-- <div class="clearfix">
									<p class="mb-0 float-start">
													<a class="btn btn-primary d-flex align-items-center" href="{{ route('training-edit', ['id' => $value->id]) }}" class="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Edit"><i class="bx bx-edit"></i><span>Edit</span></a>
												</p>
									<p class="mb-0 float-end fw-bold">
										@if(empty($value->deleted_at))
												
													<a class="btn btn-primary d-flex align-items-center" href="{{ route('training-delete', ['id' => $value->id]) }}" class="ms-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Delete"><i class="bx bx-trash"></i>Delete</a>
												
												@else
													<a class="btn btn-danger d-flex align-items-center" href="{{ route('training-delete', ['id' => $value->id]) }}" class="ms-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Restore"><i class="bx bx-revision"></i>Restore</a>
												
												@endif
									</p>
								</div> --}}
							</div>
						</div>
					</div>
					
				</div> 

@endsection