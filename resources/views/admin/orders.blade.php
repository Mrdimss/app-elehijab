@extends('layouts.admin')
@section('content')
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Orders</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{route('admin.index')}}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">Orders</div>
                    </li>
                </ul>
            </div>

            <div class="wg-box">
                <div class="flex items-center justify-between gap10 flex-wrap">
                    <div class="wg-filter flex-grow">
                        <form class="form-search">
                            <fieldset class="name">
                                <input type="text" placeholder="Search here..." class="" id="search" name="name" tabindex="2" value=""
                                    aria-required="true" required="" autocomplete="off">
                            </fieldset>
                            <div class="button-submit">
                                <button class="" type="submit">
                                    <i class="icon-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="wg-table table-all-order">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-order">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Subtotal</th>
                                    <th>Tax</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Order Date</th>
                                    <th>Items</th>
                                    <th>Delivered On</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="table-body">
                                @foreach ($orders as $key => $order)
                                    <tr>
                                        <th>{{$order->id}}</th>
                                        <td>{{$order->name}}</td>
                                        <td>{{$order->phone}}</td>
                                        <td>IDR {{$order->subtotal}}</td>
                                        <td>IDR {{$order->tax}}</td>
                                        <td>IDR {{$order->total}}</td>
                                        <td>
                                            @if($order->status == 'delivered')
                                                <span class="badge bg-success">Delivered</span>
                                            @elseif($order->status == 'canceled')
                                                <span class="badge bg-danger">Canceled</span>
                                            @else
                                                <span class="badge bg-warning">Ordered</span>
                                            @endif
                                        </td>
                                        <td>{{$order->created_at}}</td>
                                        <td>{{$order->orderItems->count()}}</td>
                                        <td>
                                            @if ($order->status == 'delivered')
                                                {{$order->delivered_date}}
                                            @else
                                                -                                            
                                            @endif
                                        </td>
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

                <div class="divider"></div>
                <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                    {{$orders->links('pagination::bootstrap-5')}}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
$(document).ready(function () {

    $('#search').on('keyup', function () {
        let search = $(this).val();

        $.ajax({
            url: "{{ route('admin.order.search') }}",
            type: "GET",
            data: { search: search },
            success: function (data) {
                let rows = '';

                if (data.length === 0) {
                    rows = `
                        <tr>
                            <td colspan="11" class="text-center">
                                No orders found for "<b>${search}</b>"
                            </td>
                        </tr>`;
                } else {
                    data.forEach(item => {

                        // status badge
                        let statusBadge =
                            item.status === 'delivered'
                                ? `<span class="badge bg-success">Delivered</span>`
                                : item.status === 'canceled'
                                    ? `<span class="badge bg-danger">Canceled</span>`
                                    : `<span class="badge bg-warning">Ordered</span>`;

                        // count order items (pastikan controller return orderItems)
                        let itemCount = item.orderItems ? item.orderItems.length : 0;

                        rows += `
                            <tr>
                                <th>${item.id}</th>
                                <td>${item.name}</td>
                                <td>${item.phone}</td>
                                <td>IDR ${item.subtotal}</td>
                                <td>IDR ${item.tax}</td>
                                <td>IDR ${item.total}</td>

                                <td>${statusBadge}</td>

                                <td>${item.created_at}</td>
                                <td>${itemCount}</td>
                                <td>${item.delivered_date ?? '-'}</td>

                                <td>
                                    <a href="/admin/order/${item.id}/details">
                                        <div class="list-icon-function">
                                            <div class="item eye">
                                                <i class="icon-eye"></i>
                                            </div>
                                        </div>
                                    </a>
                                </td>
                            </tr>
                        `;
                    });
                }
                $('#table-body').html(rows);
            }
        });
    });

});
</script>

@endpush