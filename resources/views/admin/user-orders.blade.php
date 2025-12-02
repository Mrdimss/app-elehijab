@extends('layouts.admin')
@section('content')
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>{{ $user->name }}'s Orders</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{route('admin.users')}}">
                            <div class="text-tiny">Users</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">User Orders</div>
                    </li>
                </ul>
            </div>

            <div class="wg-box">
                <div class="flex items-center justify-between gap10 flex-wrap">
                    <div class="wg-filter flex-grow">
                        {{-- <form class="form-search">
                            <fieldset class="name">
                                <input type="text" placeholder="Search here..." class="" id="search" name="name"
                                    tabindex="2" value="" aria-required="true" required="" autocomplete="off">
                            </fieldset>
                            <div class="button-submit">
                                <button class="" type="submit">
                                    <i class="icon-search"></i>
                                </button>
                            </div>
                        </form> --}}
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
                                    <th>Items</th>
                                    <th>Delivered On</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="table-body">
                                @foreach ($orders as $order)
                                    @if ($order->user_id = $user->id)
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
                                    @endif
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