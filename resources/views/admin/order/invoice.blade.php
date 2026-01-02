@extends('admin.layouts.app')
@section('content')
@php
    $order->address = json_decode($order->address);
    $order->product_details = json_decode($order->product_details);
@endphp
<div class="card">
    <div class="card-body">
        <div id="invoice">
            {{-- <div class="toolbar hidden-print">
                <div class="text-end">
                    <button type="button" class="btn btn-dark" onclick="printInvoice()"><i class="fa fa-print"></i> Print</button>
                </div>
                <hr>
            </div> --}}
            <div class="invoice overflow-auto" id="invoice">
                <div style="min-width: 600px">
                    <header>
                        <div class="row">
                            <div class="col">
                                <a href="javascript:;">
                                    <img src="{{ asset('images/config/'.config('app.logo')) }}" width="250" alt="">
                                </a>
                            </div>
                            <div class="col invoice-details">
                                <h1 class="invoice-id">INVOICE - 0{{$order->id}}</h1>
                                <div class="date">Date - {{ now()->format('d M Y, h:i A') }}</div>
                            </div>
                        </div>
                    </header>
                    <main>
                        <div class="row contacts">
                            <div class="col invoice-to">
                                <div class="text-gray-light">INVOICE TO:</div>
                                <h2 class="to">{{$order->user->name}}</h2>
                                <div class="address">{{ $order->address->type}}
                                    {{ $order->address->street}},
                                    {{ $order->address->city_name}},
                                    {{ $order->address->state_name}},
                                    {{ $order->address->country_name}},
                                    {{ $order->address->zip}}
                                </div>
                                <div class="email">{{$order->user->email}}</div>
                                <div class="email">{{$order->user->phone_number}}</div>
                            </div>
                            <div class="col company-details d-flex align-items-end flex-column">
                                <h2 class="name">
                                <a target="_blank" href="javascript:;">{{ config('app.name') }}</a></h2>
                                <div class="w-50">{{ config('app.address') }}</div>
                                <div>{{ config('app.contact_us') }}</div>
                                <div>{{ config('app.email_account') }}</div>
                            </div>
                        </div>
                        <table>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th class="text-left">Description</th>
                                    <th class="text-right">Price</th>
                                    <th class="text-right">Discount</th>
                                    <th class="text-right">QTY</th>
                                    <th class="text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->product_details as $index => $product)
                                    <tr>
                                        <td class="no">#{{ $index + 1 }}</td>
                                        <td class="text-left"><h3>#{{ $product->sku}}</h3>{{ $product->name}}<br><small>{{ $product->category_name}}</small></td>
                                        <td class="unit">{{config('app.currency_symbol')}}{{ number_format($product->price, 2) }}</td>
                                        <td class="unit">{{config('app.currency_symbol')}}{{ number_format($product->price-$product->disc_price, 2) }}</td>
                                        <td class="qty">{{ $product->quantity}}</td>
                                        <td class="total">{{config('app.currency_symbol')}}{{number_format(($product->disc_price* $product->quantity) ,2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4"></td>
                                    <td colspan="1">Subtotal</td>
                                    <td>{{config('app.currency_symbol')}}{{ number_format($order->total_amount) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="4"></td>
                                    <td colspan="1">A&C</td>
                                    <td>{{config('app.currency_symbol')}}{{ number_format($order->anc_amount) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="4"></td>
                                    <td colspan="1">Net Metering</td>
                                    <td>{{config('app.currency_symbol')}}{{ number_format($order->net_metering_amount) }}</td>
                                </tr>
                           <!--      <tr>
                                    <td colspan="4"></td>
                                    <td colspan="1">{{ config('loan.tax') }}% {{ $order->tax_type }}</td>
                                    <td>{{$order->order_tax}}</td>
                                </tr> -->
                                <tr>
                                    <td colspan="4"></td>
                                    <td colspan="1">Grand Total</td>
                                    <td>{{$order->final_amount_with_tax}}</td>
                                </tr>
                            </tfoot>
                        </table>
                        <div class="thanks">Thank you!</div>
                        <div class="notices">
                            <div>NOTICE:The applicable {{$order->tax_type}} rate of 18% is included in the invoice.</div>
                        </div>
                    </main>
                    <footer>Invoice was created on a computer and is valid without the signature and seal.</footer>
                </div>
                <!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->
                <div></div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
function printInvoice() {
    // Get the invoice content
    var invoiceContent = document.getElementById('invoice').innerHTML;

    // Open a new window
    var printWindow = window.open('', '', 'height=600,width=800');

    // Write invoice content to the new window
    printWindow.document.write('<html><head><title>Invoice</title>');
    printWindow.document.write('</head><body >');
    printWindow.document.write(invoiceContent);
    printWindow.document.write('</body></html>');

    printWindow.document.close();
    printWindow.print();
}
</script>
@endpush

