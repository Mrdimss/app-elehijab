@extends('layouts.admin')
@section('content')
    <div class="main-content-inner">

        <div class="main-content-wrap">
            <div class="tf-section-2 mb-30">
                <div class="flex gap20 flex-wrap-mobile">
                    <div class="w-half">

                        <div class="wg-chart-default mb-20">
                            <div class="body-text mb-2 text-center">Total Orders</div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap14">
                                    <div class="image ic-bg" style="color: #2275fc;">
                                        <i class="icon-shopping-bag"></i>
                                    </div>
                                    <div>
                                        <h4>{{ $dashboardDatas->TotalOrdered + $dashboardDatas->TotalDelivered }}</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap14">
                                    <div class="image ic-bg">
                                        <p style="color: #2275fc; font-weight: 700;">Rp</p>
                                    </div>
                                    <div>
                                        <h4>{{ rupiah($dashboardDatas->TotalOrderedAmount + $dashboardDatas->TotalDeliveredAmount) }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="wg-chart-default mb-20">
                            <div class="body-text mb-2 text-center">Pending Orders</div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap14">
                                    <div class="image ic-bg" style="color: #FB923C;">
                                        <i class="icon-shopping-bag"></i>
                                    </div>
                                    <div>
                                        <h4>{{ $dashboardDatas->TotalOrdered }}</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap14">
                                    <div class="image ic-bg">
                                        <p style="color: #FB923C; font-weight: 700;">Rp</p>
                                    </div>
                                    <div>
                                        <h4>{{ rupiah($dashboardDatas->TotalOrderedAmount) }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="w-half">
                        <div class="wg-chart-default mb-20">
                            <div class="body-text mb-2 text-center uppercase">Delivered Orders</div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap14">
                                    <div class="image ic-bg">
                                        <i class="icon-shopping-bag" style="color: #22C55E;"></i>
                                    </div>
                                    <div>
                                        <h4>{{ $dashboardDatas->TotalDelivered }}</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap14">
                                    <div class="image ic-bg">
                                        <p style="color: #22C55E; font-weight: 700">Rp</p>
                                    </div>
                                    <div>
                                        <h4>{{ rupiah($dashboardDatas->TotalDeliveredAmount) }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="wg-chart-default mb-20">
                            <div class="body-text mb-2 text-center">Canceled Orders</div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap14">
                                    <div class="image ic-bg" style="color: #EF4444;">
                                        <i class="icon-shopping-bag"></i>
                                    </div>
                                    <div>

                                        <h4>{{ $dashboardDatas->TotalCanceled }}</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap14">
                                    <div class="image ic-bg">
                                        <p style="color: #EF4444; font-weight: 700;">Rp</p>
                                    </div>
                                    <div>
                                        <h4>{{ rupiah($dashboardDatas->TotalCanceledAmount) }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="wg-box">
                    <div class="flex items-center justify-between ml-20">
                        <h5>Monthly revenue</h5>
                        <div class="dropdown default">
                            {{-- <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <span class="icon-more"><i class="icon-more-horizontal"></i></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a href="javascript:void(0);">This Week</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">Last Week</a>
                                </li>
                            </ul> --}}
                        </div>
                    </div>
                    <div class="flex flex-wrap gap40 ml-20">
                        <div>
                            <div class="mb-2">
                                <div class="block-legend">
                                    <div class="dot t1"></div>
                                    <div class="text-tiny">Total</div>
                                </div>
                            </div>
                            <div class="flex items-center gap10">
                                <p style="font-weight: 700; font-size: 1.6em;">{{ formatRupiah($totalOrderedAmount + $totalDeliveredAmount) }}</p>
                            </div>
                        </div>
                        <div>
                            <div class="mb-2">
                                <div class="block-legend">
                                    <div class="dot t2"></div>
                                    <div class="text-tiny">Pending</div>
                                </div>
                            </div>
                            <div class="flex items-center gap10">
                                <p style="font-weight: 700; font-size: 1.6em;">{{ formatRupiah($totalOrderedAmount) }}</p>
                            </div>
                        </div>
                        <div>
                            <div class="mb-2">
                                <div class="block-legend">
                                    <div class="dot t3"></div>
                                    <div class="text-tiny">Delivered</div>
                                </div>
                            </div>
                            <div class="flex items-center gap10">
                                <p style="font-weight: 700; font-size: 1.6em;">{{ formatRupiah($totalDeliveredAmount) }}</p>
                            </div>
                        </div>
                        <div>
                            <div class="mb-2">
                                <div class="block-legend">
                                    <div class="dot t4"></div>
                                    <div class="text-tiny">Canceled</div>
                                </div>
                            </div>
                            <div class="flex items-center gap10">
                                <p style="font-weight: 700; font-size: 1.6em;">{{ formatRupiah($totalCanceledAmount) }}</p>
                            </div>
                        </div>
                    </div>
                    <div id="line-chart-8"></div>
                </div>

            </div>
            <div class="tf-section mb-30">

                <div class="wg-box">
                    <div class="flex items-center justify-between">
                        <h5>Recent orders</h5>
                        <div class="dropdown default">
                            <a class="btn btn-secondary dropdown-toggle" href="{{ route('admin.orders') }}">
                                <span class="view-all">View all</span>
                            </a>
                        </div>
                    </div>
                    <div class="wg-table table-all-order">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-order">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Status</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Subtotal</th>
                                        <th>Tax</th>
                                        <th>Total</th>
                                        <th>Order Date</th>
                                        <th>Total Items</th>
                                        <th>Delivered On</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <th>{{$order->id}}</th>
                                            <td>
                                                @if($order->status == 'delivered')
                                                    <span class="badge bg-success">Delivered</span>
                                                @elseif($order->status == 'canceled')
                                                    <span class="badge bg-danger">Canceled</span>
                                                @else
                                                    <span class="badge bg-warning">Ordered</span>
                                                @endif
                                            </td>
                                            <td>{{$order->name}}</td>
                                            <td>{{$order->phone}}</td>
                                            <td>{{formatRupiah($order->subtotal)}}</td>
                                            <td>{{formatRupiah($order->tax)}}</td>
                                            <td>{{formatRupiah($order->total)}}</td>
                                            <td>{{$order->created_at}}</td>
                                            <td>{{$order->orderItems->count()}}</td>
                                            <td>{{$order->delivered_date}}</td>
                                            <td>
                                                <a href="{{route('admin.order.details', ['order_id' => $order->id])}}">
                                                    <div class="list-icon-function">
                                                        <div class="item eye">
                                                            <i class="icon-eye"></i>
                                                        </div>
                                                    </div>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        (function ($) {

            var tfLineChart = (function () {

                var chartBar = function () {

                    var options = {
                        series: [{
                            name: 'Total',
                            data: [{{ $amountM }}]
                        }, {
                            name: 'Pending',
                            data: [{{ $orderedAmountM }}]
                        },
                        {
                            name: 'Delivered',
                            data: [{{ $deliveredAmountM }}]
                        }, {
                            name: 'Canceled',
                            data: [{{ $canceledAmountM }}]
                        }],
                        chart: {
                            type: 'bar',
                            height: 325,
                            toolbar: {
                                show: false,
                            },
                        },
                        plotOptions: {
                            bar: {
                                horizontal: false,
                                columnWidth: '10px',
                                endingShape: 'rounded'
                            },
                        },
                        dataLabels: {
                            enabled: false
                        },
                        legend: {
                            show: false,
                        },
                        colors: ['#2377FC', '#FFA500', '#078407', '#FF0000'],
                        stroke: {
                            show: false,
                        },
                        xaxis: {
                            labels: {
                                style: {
                                    colors: '#212529',
                                },
                            },
                            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                        },
                        yaxis: {
                            show: false,
                        },
                        fill: {
                            opacity: 1
                        },
                        tooltip: {
                            y: {
                                formatter: function (val) {
                                    return "Rp " + val.toLocaleString("id-ID");
                                }
                            }
                        }
                    };

                    chart = new ApexCharts(
                        document.querySelector("#line-chart-8"),
                        options
                    );
                    if ($("#line-chart-8").length > 0) {
                        chart.render();
                    }
                };

                /* Function ============ */
                return {
                    init: function () { },

                    load: function () {
                        chartBar();
                    },
                    resize: function () { },
                };
            })();

            jQuery(document).ready(function () { });

            jQuery(window).on("load", function () {
                tfLineChart.load();
            });

            jQuery(window).on("resize", function () { });
        })(jQuery);
    </script>
@endpush