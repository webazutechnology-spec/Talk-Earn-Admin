@foreach ($products as $pvalue)
    <div class="col-12">
        <div class="card mb-3">
            <div class="card-body">
                <div class="d-flex">
                    <img src="{{asset('images/product/'.$pvalue->image)}}" onerror="this.onerror=null;this.src='{{ asset('images/missing-image.png') }}';" class="product-img-2 me-2" alt="..." style="width: 56px; height: 56px;">
                    <p class="normal card-title cursor-pointer text-dark"><b>#{{$pvalue->sku}}</b> <br> {{$pvalue->name}}</p>
                </div>
                <div class="d-flex justify-content-between">
                    <p class="mb-0 float-start">CP:{{$pvalue->capacity}}</p>
                    <p class="mb-0 float-start">TYP: {{$pvalue->type}}</p>
                    <p class="mb-0 float-start">V: {{$pvalue->voltage}}</p>
                </div>
                <div class="d-flex justify-content-between mt-2">
                    <p class="mb-0 float-start"> Price: {{$pvalue->price}}</p>
                    <p class="mb-0 float-start"> Discount: {{$pvalue->disc_price}}</p>
                    <p class="mb-0 float-end fw-bold">
                        <button class=" position-absolute top-0 end-0 m-2 btn btn-success btn-sm border rounded-circle add-product" data-pro_id="{{ $pvalue->id }}">+</button>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endforeach
@if(count($products) == 0)
    <p class="text-center text-danger">No product found for this category.</p>
@endif
