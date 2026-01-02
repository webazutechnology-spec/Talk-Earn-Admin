@extends('admin.layouts.app')
@section('content')
@php
    $profile = 'images/user-1.svg';
@endphp
<div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
    <div class="col">
        <div class="card radius-15 border-start border-0 border-3 bg-gradient-cosmic">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <div>
                    <p class="mb-0 text-white">Total O</p>
                    <h4 class="my-1 text-white">{{ $orderCount }}</h4>
                    <p class="mb-0 font-13 text-white">{{ $orderLastCount }} from last week</p>
                </div>
                <div class="widgets-icons-2 rounded-circle text-white ms-auto bg-gradient-cosmic"><i class='bx bxs-cart'></i>
                </div>
            </div>
        </div>
        </div>
    </div>
    <div class="col">
    <div class="card radius-15 border-start border-0 border-3 bg-gradient-ibiza">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <div>
                    <p class="mb-0 text-white">Total Revenue</p>
                    <h4 class="my-1 text-white">{{config('app.currency_symbol')}}{{number_format($totalRevenue,2)}}</h4>
                    <p class="mb-0 font-13 text-white">{{config('app.currency_symbol')}}{{number_format($totalRevenueLast,2)}} from last week</p>
                </div>
                <div class="widgets-icons-2 rounded-circle bg-gradient-ibiza text-white ms-auto"><i class='bx bxs-wallet'></i>
                </div>
            </div>
        </div>
    </div>
    </div>
    <div class="col">
    <div class="card radius-15 border-start border-0 border-3 bg-gradient-ohhappiness">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <div>
                    <p class="mb-0 text-white">Commission</p>
                    <h4 class="my-1 text-white">{{config('app.currency_symbol')}}{{number_format('0',2)}}</h4>
                    <p class="mb-0 font-13 text-white">{{config('app.currency_symbol')}}{{number_format('0',2)}} from last week</p>
                </div>
                <div class="widgets-icons-2 rounded-circle bg-gradient-ohhappiness text-white ms-auto"><i class='bx bxs-bar-chart-alt-2' ></i>
                </div>
            </div>
        </div>
    </div>
    </div>
    <div class="col">
    <div class="card radius-15 border-start border-0 border-3 bg-gradient-kyoto">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <div>
                    <p class="mb-0 text-white">Wallet Balance</p>
                    <h4 class="my-1 text-white">{{config('app.currency_symbol')}}{{number_format($main_balance,2)}}</h4>
                    <p class="mb-0 font-13 text-white">.</p>
                </div>
                <div class="widgets-icons-2 rounded-circle bg-gradient-kyoto text-white ms-auto"><i class='bx bxs-group'></i>
                </div>
            </div>
        </div>
    </div>
    </div> 
</div><!--end row-->

<div class="row">
    <div class="col-12 col-lg-3">
        <div class="card radius-15">
            <div class="card-body">
            <div class="d-flex align-items-center">
                <div>
                    <h6 class="mb-0">Fund Requests</h6>
                </div>
       <!--          <div class="dropdown ms-auto">
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="javascript:;">Action</a>
                        </li>
                        <li><a class="dropdown-item" href="javascript:;">Another action</a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="javascript:;">Something else here</a>
                        </li>
                    </ul>
                </div> -->
            </div>
            <div class="chart-container-2 mt-4">
                <canvas id="chart-fund-requests"></canvas>
                </div>
            </div>
            <ul class="list-group list-group-flush">
            <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Pending <span class="badge bg-warning rounded-pill">{{$fundRequestCount->Pending??0}}</span>
            </li>
            <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Approved <span class="badge bg-success rounded-pill">{{$fundRequestCount->Approved??0}}</span>
            </li>
            <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Rejected <span class="badge bg-danger rounded-pill">{{$fundRequestCount->Rejected??0}}</span>
            </li>
            <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">. <span class="badge bg-warning text-dark rounded-pill"></span>
            </li>
        </ul>
        </div>
    </div>
    @if(auth()->user()->role_id == 1)
    <div class="col-12 col-lg-3">
        <div class="card radius-15">
            <div class="card-body">
            <div class="d-flex align-items-center">
                <div>
                    <h6 class="mb-0">Teams</h6>
                </div>
              <!--   <div class="dropdown ms-auto">
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="javascript:;">Action</a>
                        </li>
                        <li><a class="dropdown-item" href="javascript:;">Another action</a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="javascript:;">Something else here</a>
                        </li>
                    </ul>
                </div> -->
            </div>
            <div class="chart-container-2 mt-4">
                <canvas id="chart-teams"></canvas>
                </div>
            </div>
            <ul class="list-group list-group-flush">
            <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Sales <span class="badge bg-success rounded-pill">{{$userCount->Sales}}</span>
            </li>
            <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Support <span class="badge bg-danger rounded-pill">{{$userCount->Support}}</span>
            </li>
            <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Associate <span class="badge bg-info rounded-pill">{{$userCount->Associate}}</span>
            </li>
            <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">. <span class="badge bg-warning text-dark rounded-pill"></span>
            </li>
        </ul>
        </div>
    </div>
    @endif
    <div class="col-12 col-lg-3">
        <div class="card radius-15">
            <div class="card-body">
            <div class="d-flex align-items-center">
                <div>
                    <h6 class="mb-0">CRM</h6>
                </div>
                <div class="dropdown ms-auto">
   <!--                  <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="javascript:;">Action</a>
                        </li>
                        <li><a class="dropdown-item" href="javascript:;">Another action</a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="javascript:;">Something else here</a>
                        </li>
                    </ul> -->
                </div>
            </div>
            <div class="chart-container-2 mt-4">
                <canvas id="chart-crm"></canvas>
                </div>
            </div>

            <ul class="list-group list-group-flush">
            <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Pending <span class="badge bg-warning rounded-pill">{{$leadCount->Pending}}</span>
            </li>
            <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Prospecting <span class="badge bg-info rounded-pill">{{$leadCount->Prospecting}}</span>
            </li>
            <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Converted <span class="badge bg-primary rounded-pill">{{$leadCount->Converted}}</span>
            </li>
            <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Closed <span class="badge bg-warning text-dark rounded-pill">{{$leadCount->Closed}}</span>
            </li>
        </ul>
        </div>
    </div>
    <div class="col-12 col-lg-3">
        <div class="card radius-15">
            <div class="card-body">
            <div class="d-flex align-items-center">
                <div>
                    <h6 class="mb-0">O</h6>
                </div>
                <div class="dropdown ms-auto">
            <!--         <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="javascript:;">Action</a>
                        </li>
                        <li><a class="dropdown-item" href="javascript:;">Another action</a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="javascript:;">Something else here</a>
                        </li>
                    </ul> -->
                </div>
            </div>
            <div class="chart-container-2 mt-4">
                <canvas id="chart-orderes"></canvas>
                </div>
            </div>
            <ul class="list-group list-group-flush">
            <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Pending <span class="badge bg-danger rounded-pill">{{$orderStatusCount->Pending??0}}</span>
            </li> 
            <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Confirm <span class="badge bg-warning rounded-pill">{{$orderStatusCount->Confirm??0}}</span>
            </li>
            <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Processing <span class="badge bg-info rounded-pill">{{($orderStatusCount->VisitVerification??0)+($orderStatusCount->Documentation??0)+($orderStatusCount->PartsDelivered??0)+($orderStatusCount->Installation??0)+($orderStatusCount->Netmeeting??0)}}</span>
            </li>
            <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Completed <span class="badge bg-success rounded-pill">{{$orderStatusCount->Completed??0}}</span>
            </li>
        </ul>
        </div>
    </div>
</div><!--end row-->


<div class="row">
    <!-- <div class="col-12 col-lg-7 col-xl-8 d-flex"> -->
    {{-- <div class="col-12 d-flex">
        <div class="card radius-15 w-100">
        <div class="card-header bg-transparent">
            <div class="d-flex align-items-center">
                <div>
                    <h6 class="mb-0">Recent Orders</h6>
                </div>
            </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                            <th>SKU ID</th>
                            <th>User</th>
                            <th>Status</th>
                            <th>Payment</th>
                            <th>Final Amount</th>
                            <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                            <tr>
                                <td>#{{ $order->code }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('images/profile/' .($order->user->image ?? '') ) }}" onerror="this.onerror=null;this.src='{{ asset($profile) }}';" class="product-img-2" alt="product img" style="margin-right: 8px;"> 
                                        <span>{{ $order->user->name??'' }}<p class="m-0"><small>{{ $order->user->code??'' }}</small></p></span>
                                    </div>
                                </td>
                                <td>
                                    @php
                                        $hex = ltrim($order->status->color, '#');

                                        [$r, $g, $b] = [
                                            hexdec(substr($hex, 0, 2)),
                                            hexdec(substr($hex, 2, 2)),
                                            hexdec(substr($hex, 4, 2)),
                                        ];
                                    @endphp

                                    <div class="badge rounded-pill p-2 text-uppercase px-3"
                                        style="color: {{ $order->status->color }};
                                                background-color: rgba({{ $r }}, {{ $g }}, {{ $b }}, 0.18);">
                                        <i class="bx bxs-circle align-middle me-1"></i>
                                        {{ $order->status->name ?? '' }}
                                    </div>
                                </td>
                                <td>
                                    @php
                                        $hex = ltrim($order->payment->color, '#');

                                        [$r, $g, $b] = [
                                            hexdec(substr($hex, 0, 2)),
                                            hexdec(substr($hex, 2, 2)),
                                            hexdec(substr($hex, 4, 2)),
                                        ];
                                    @endphp

                                    <div class="badge rounded-pill p-2 text-uppercase px-3"
                                        style="color: {{ $order->payment->color }};
                                                background-color: rgba({{ $r }}, {{ $g }}, {{ $b }}, 0.18);">
                                        <i class="bx bxs-circle align-middle me-1"></i>
                                        {{ $order->payment->name ?? '' }}
                                    </div>
                                </td>
                                <td>{{ config('app.currency_symbol')}} {{ number_format($order->final_amount_with_tax) }}</td>
                                <td>{{ $order->created_at }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> --}}
<!--     <div class="col-12 col-lg-5 col-xl-4 d-flex">
        <div class="card w-100 radius-15">
            <div class="card-body">
            <div class="card radius-15 border shadow-none">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0 text-secondary">Total Likes</p>
                        <h4 class="my-1">45.6M</h4>
                        <p class="mb-0 font-13">+6.2% from last week</p>
                    </div>
                    <div class="widgets-icons-2 bg-gradient-cosmic text-white ms-auto"><i class='bx bxs-heart-circle'></i>
                    </div>
                </div>
            </div>
            </div>
            <div class="card radius-15 border shadow-none">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0 text-secondary">Comments</p>
                        <h4 class="my-1">25.6K</h4>
                        <p class="mb-0 font-13">+3.7% from last week</p>
                    </div>
                    <div class="widgets-icons-2 bg-gradient-ibiza text-white ms-auto"><i class='bx bxs-comment-detail'></i>
                    </div>
                </div>
            </div>
            </div>
            <div class="card radius-15 mb-0 border shadow-none">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0 text-secondary">Total Shares</p>
                        <h4 class="my-1">85.4M</h4>
                        <p class="mb-0 font-13">+4.6% from last week</p>
                    </div>
                    <div class="widgets-icons-2 bg-gradient-moonlit text-white ms-auto"><i class='bx bxs-share-alt'></i>
                    </div>
                </div>
            </div>
            </div>
            </div>

        </div>

    </div> -->
</div><!--end row-->
@endsection
@push('scripts')
<script>
    
function createDoughnutChart(canvasId, labels, data) {
    var ctx = document.getElementById(canvasId).getContext("2d");

    // Gradients
    var gradient1 = ctx.createLinearGradient(0, 0, 0, 300);
    gradient1.addColorStop(0, '#fc4a1a');
    gradient1.addColorStop(1, '#f7b733');

    var gradient2 = ctx.createLinearGradient(0, 0, 0, 300);
    gradient2.addColorStop(0, '#4776e6');
    gradient2.addColorStop(1, '#8e54e9');

    var gradient3 = ctx.createLinearGradient(0, 0, 0, 300);
    gradient3.addColorStop(0, '#ee0979');
    gradient3.addColorStop(1, '#ff6a00');

    var gradient4 = ctx.createLinearGradient(0, 0, 0, 300);
    gradient4.addColorStop(0, '#42e695');
    gradient4.addColorStop(1, '#3bb2b8');

    var gradients = [gradient1, gradient2, gradient3, gradient4];

    new Chart(ctx, {
        type: "doughnut",
        data: {
            labels: labels,
            datasets: [{
                backgroundColor: gradients,
                hoverBackgroundColor: gradients,
                borderWidth: 1,
                data: data
            }]
        },
        options: {
            maintainAspectRatio: false,
            cutoutPercentage: 75,
            legend: {
                display: false
            },
            tooltips: {
                displayColors: false
            }
        }
    });
}

createDoughnutChart("chart-fund-requests", ["Pending", "Approved", "Rejected"], ['{{$fundRequestCount->Pending??0}}', '{{$fundRequestCount->Approved??0}}', '{{$fundRequestCount->Rejected??0}}']);

createDoughnutChart("chart-teams", ["Sales", "Support", "Associate"], ['{{$userCount->Sales}}', '{{$userCount->Support}}', '{{$userCount->Associate}}']);

createDoughnutChart("chart-crm", ["Pending", "Prospecting", "Converted", "Closed"], ['{{$leadCount->Pending??0}}', '{{$leadCount->Prospecting??0}}', '{{$leadCount->Converted??0}}', '{{$leadCount->Closed??0}}']);



createDoughnutChart("chart-orderes", ["Pending", "Confirm", "Processing", "Completed"], ['{{$orderStatusCount->Pending??0}}', '{{$orderStatusCount->Confirm??0}}', '{{($orderStatusCount->VisitVerification??0)+($orderStatusCount->Documentation??0)+($orderStatusCount->PartsDelivered??0)+($orderStatusCount->Installation??0)+($orderStatusCount->Netmeeting??0)}}', '{{$orderStatusCount->Completed??0}}']);

      

	  
</script>
@endpush