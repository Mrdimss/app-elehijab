@extends('layouts.admin')
@section('content')
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>All Products</h3>
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
                        <div class="text-tiny">All Products</div>
                    </li>
                </ul>
            </div>

            <div class="wg-box">
                <div class="flex items-center justify-between gap10 flex-wrap">
                    <div class="wg-filter flex-grow">
                        <form class="form-search">
                            <fieldset class="name">
                                <input type="text" placeholder="Search here..." class="" id="search" name="search"
                                    tabindex="2" value="" aria-required="true" required="" autocomplete="off">
                            </fieldset>
                            <div class="button-submit">
                                <button class="" type="submit"><i class="icon-search"></i></button>
                            </div>
                        </form>
                    </div>
                    <a class="tf-button style-1 w208" href="{{route('admin.product.add')}}"><i class="icon-plus"></i>Add
                        new</a>
                </div>
                <div class="wg-table table-all-product">
                    <div class="table-responsive">
                        @if(Session::has('status'))
                            <p class="alert alert-success">{{Session::get('status')}}</p>
                        @endif
                        <table class="table table-striped table-hover table-product">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Sale Price</th>
                                    <th>SKU</th>
                                    <th>Category</th>
                                    <th>Brand</th>
                                    <th>Featured</th>
                                    <th>Stock</th>
                                    <th>Quantity</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="table-body">
                                @foreach ($products as $key => $product)
                                    <tr>
                                        <th>{{$product->id}}</th>
                                        <td class="pname">
                                            <div class="image">
                                                <img src="{{asset('uploads/products/thumbnails')}}/{{$product->image}}"
                                                    alt="{{$product->name}}" class="image">
                                            </div>
                                            <div class="name">
                                                <a href="#" class="body-title-2">{{$product->name}}</a>
                                                <div class="text-tiny mt-3">{{$product->slug}}</div>
                                            </div>
                                        </td>
                                        <td>{{formatRupiah($product->regular_price)}}</td>
                                        <td>{{ formatRupiah($product->sale_price) }}</td>
                                        <td>{{$product->SKU}}</td>
                                        <td>{{$product->category->name}}</td>
                                        <td>{{$product->brand->name}}</td>
                                        <td>{{$product->featured == 0 ? "No" : "Yes"}}</td>
                                        <td>{{$product->stock_status}}</td>
                                        <td>{{$product->quantity}}</td>
                                        <td>
                                            <div class="list-icon-function">
                                                <a href="#" target="_blank">
                                                    <div class="item eye">
                                                        <i class="icon-eye"></i>
                                                    </div>
                                                </a>
                                                <a href="{{route('admin.product.edit', ['id' => $product->id])}}">
                                                    <div class="item edit">
                                                        <i class="icon-edit-3"></i>
                                                    </div>
                                                </a>
                                                <form action="{{route('admin.product.delete', ['id' => $product->id])}}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="item text-danger delete">
                                                        <i class="icon-trash-2"></i>
                                                    </div>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="divider"></div>
                    <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                        {{$products->links('pagination::bootstrap-5')}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function () {
            $('.delete').on('click', function (e) {
                e.preventDefault();
                var form = $(this).closest('form');
                swal({
                    title: "Are you Sure?",
                    text: "You want to delete this record?",
                    type: "warning",
                    buttons: ["No", "Yes"],
                    confirmButtonColor: '#dc3545'
                }).then(function (result) {
                    if (result) {
                        form.submit();
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function () {
            // STOP form submit agar tidak reload
            // $('.form-search').on('submit', function (e) {
            //     e.preventDefault();
            // });

            $('#search').on('keyup', function () {
                let search = $(this).val();

                // SEMBUNYIKAN PAGINATION SAAT SEARCH
                if (search.length > 0) {
                    $('.wgp-pagination').hide();
                } else {
                    $('.wgp-pagination').show();
                }

                $.ajax({
                    url: "{{ route('admin.product.search') }}",
                    type: "GET",
                    data: { search: search },
                    success: function (data) {

                        let rows = "";

                        if (data.length === 0) {
                            rows = `<tr><td colspan="6" class="text-center">No product found for "<b>${search}</b>"</td></tr>`;
                        } else {
                            data.forEach((item, index) => {
                                rows += `
                                    <tr>
                                        <th>${item.id}</th>
                                        <td class="pname">
                                            <div class="image">
                                                <img src="{{asset('uploads/products/thumbnails')}}/${item.image}"
                                                    alt="${item.name}" class="image">
                                            </div>
                                            <div class="name">
                                                <a href="#" class="body-title-2">${item.name}</a>
                                                <div class="text-tiny mt-3">${item.slug}</div>
                                            </div>
                                        </td>
                                        <td>IDR ${item.regular_price}</td>
                                        <td>IDR ${item.sale_price}</td>
                                        <td>${item.SKU}</td>
                                        <td>${item.category ? item.category.name : '-'}</td>
                                        <td>${item.brand ? item.brand.name : '-'}</td>
                                        <td>${item.featured == 0 ? "No": "Yes"}</td>
                                        <td>${item.stock_status}</td>
                                        <td>${item.quantity}</td>
                                        <td>
                                            <div class="list-icon-function">
                                                <a href="#" target="_blank">
                                                    <div class="item eye">
                                                        <i class="icon-eye"></i>
                                                    </div>
                                                </a>
                                                <a href="/admin/product/${item.id}/edit">
                                                    <div class="item edit">
                                                        <i class="icon-edit-3"></i>
                                                    </div>
                                                </a>
                                                <form action="/admin/product/${item.id}/delete"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="item text-danger delete">
                                                        <i class="icon-trash-2"></i>
                                                    </div>
                                                </form>
                                            </div>
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