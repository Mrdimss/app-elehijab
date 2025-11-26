@extends('layouts.admin')
@section('content')
    <style>
        .table-transaction>tbody>tr:nth-of-type(odd) {
            --bs-table-accent-bg: #fff !important;
        }
    </style>
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Order Details</h3>
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
                        <div class="text-tiny">Order Details</div>
                    </li>
                </ul>
            </div>

            <div class="wg-box">
                <div class="flex items-center justify-between gap10 flex-wrap">
                    <div class="wg-filter flex-grow">
                        <h5>Ordered Details</h5>
                    </div>
                    <a class="tf-button style-1 w208" href="{{route('admin.orders')}}">Back</a>
                </div>

                <div class="table-responsive">
                    @if (Session::has('status'))
                        <p class="alert alert-success">{{ Session::get('status') }}</p>
                    @endif
                    <table class="table table-striped table-hover table-order-details">
                        <thead>
                            <tr>
                                <th>Order No</th>
                                <th>Mobile</th>
                                <th>Zip Code</th>
                                <th>Order Date</th>
                                <th>Delivered Date</th>
                                <th>Canceled Date</th>
                                <th>Order Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{$order->id}}</td>
                                <td>{{$order->phone}}</td>
                                <td>{{$order->zip}}</td>
                                <td>{{$order->created_at}}</td>
                                <td>{{$order->delivered_date}}</td>
                                <td>{{$order->canceled_date}}</td>
                                <td colspan="5">
                                    @if($order->status == 'delivered')
                                        <span class="badge bg-success">Delivered</span>
                                    @elseif($order->status == 'canceled')
                                        <span class="badge bg-danger">Canceled</span>
                                    @else
                                        <span class="badge bg-warning">Ordered</span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="wg-box mt-5">
                <div class="flex items-center justify-between gap10 flex-wrap">
                    <div class="wg-filter flex-grow">
                        <h5>Ordered Items</h5>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-hover table-order-items">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>SKU</th>
                                <th>Category</th>
                                <th>Brand</th>
                                <th>Options</th>
                                <th>Return Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orderItems as $item)
                                <tr>
                                    <td class="pname">
                                        <div class="image">
                                            <img src="{{asset('uploads/products/thumbnails')}}/{{$item->product->image}}"
                                                alt="{{$item->product->name}}" class="image">
                                        </div>
                                        <div class="name">
                                            <a href="{{route('shop.product.details', ['product_slug' => $item->product->slug])}}"
                                                target="_blank" class="body-title-2">{{$item->product->name}}</a>
                                        </div>
                                    </td>
                                    <td>{{formatRupiah($item->price)}}</td>
                                    <td>{{$item->quantity}}</td>
                                    <td>{{$item->product->SKU}}</td>
                                    <td>{{$item->product->category->name}}</td>
                                    <td>{{$item->product->brand->name}}</td>
                                    <td>{{$item->options}}</td>
                                    <td>{{$item->rstatus == 0 ? "No" : "Yes"}}</td>
                                    <td>
                                        <div class="list-icon-function">
                                            <div class="item eye">
                                                <i class="icon-eye"></i>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="divider"></div>
                <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                    {{$orderItems->links('pagination::bootstrap-5')}}
                </div>
            </div>

            <div class="wg-box mt-5">
                <h5>Shipping Address</h5>
                <div class="my-account__address-item col-md-6">
                    <div class="my-account__address-item__detail">
                        <p>{{$order->name}}</p>
                        <p>{{$order->address}}</p>
                        <p>{{$order->locality}}</p>
                        <p>{{$order->city}}, {{$order->country}}</p>
                        <p>{{$order->landmark}}</p>
                        <p>{{$order->zip}}</p>
                        <br>
                        <p>Mobile : {{$order->phone}}</p>
                    </div>
                </div>
            </div>

            <div class="wg-box mt-5">
                <h5>Transactions</h5>
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-transaction">
                        <thead>
                            <tr>
                                <th>Subtotal</th>
                                <th>Tax</th>
                                <th>Discount</th>
                                <th>Total</th>
                                <th>Payment Mode</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{formatRupiah($order->subtotal)}}</td>
                                <td>{{formatRupiah($order->tax)}}</td>
                                <td>{{formatRupiah($order->discount)}}</td>
                                <td>{{formatRupiah($order->total)}}</td>
                                <td>{{$transaction->mode}}</td>
                                <td>
                                    @if($transaction->status == 'approved')
                                        <span class="badge bg-success">Approved</span>
                                    @elseif($transaction->status == 'declined')
                                        <span class="badge bg-danger">Declined</span>
                                    @elseif($transaction->status == 'refunded')
                                        <span class="badge bg-secondary">Refunded</span>
                                    @else
                                        <span class="badge bg-warning">Pending</span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="wg-box mt-5">
                <h5>Update Order Status</h5>
                <form action="{{ route('admin.order.status.update') }}" method="POST">
                    @csrf
                    @method('put')
                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="select">
                                <select name="order_status" id="order_status">
                                    <option value="ordered" {{ $order->status == 'ordered' ? 'selected' : '' }}>Ordered
                                    </option>
                                    <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered
                                    </option>
                                    <option value="canceled" {{ $order->status == 'canceled' ? 'selected' : '' }}>Canceled
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary tf-button w200">Update Status</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection