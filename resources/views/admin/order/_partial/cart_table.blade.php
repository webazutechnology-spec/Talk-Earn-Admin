@php
    $products = $cart ? json_decode($cart->product_json, true) : [];
@endphp	
@foreach ($products as $item)
<tr data-productid="{{$item['id']}}" class="row-total">
    <td>
        <img src="{{asset('images/product/'.$item['image'])}}" onerror="this.onerror=null;this.src='{{ asset('images/missing-image.png') }}';" class="product-img-2" height="40">
    </td>
    <td>
        <span style="text-wrap: auto;">{{$item['name']}}</span>
    </td>
    <td>
        <input type="number" name="price" class="form-control form-control-sm discounted_price" value="{{$item['disc_price']}}">
    </td>
    <td>
        <div class="input-group">
            <button class="btn btn-sm btn-white btn-minus">−</button>
            <input type="text" class="form-control form-control-sm qty" value="{{$item['quantity']}}">
            <button class="btn btn-sm btn-white btn-plus">+</button>
        </div>
    </td>
    <td>
        <span class="order-actions-primary">
            <a href="javascript:;" class="delete-cart" data-id="{{ $item['id']}}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Remove"><i class="bx bx-trash"></i></a>
        </span>
    </td>
</tr>
@endforeach