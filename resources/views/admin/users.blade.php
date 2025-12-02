@extends('layouts.admin')

@section('content')
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>All Users</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">All User</div>
                    </li>
                </ul>
            </div>

            <div class="wg-box">
                <div class="flex items-center justify-between gap10 flex-wrap">
                    <div class="wg-filter flex-grow">
                        <form class="form-search">
                            <fieldset class="name">
                                <input type="text" placeholder="Search here..." class="" id="search" name="name"
                                    tabindex="2" value="" aria-required="true" required="" autocomplete="off">
                            </fieldset>
                            <div class="button-submit">
                                <button class="" type="submit"><i class="icon-search"></i></button>
                            </div>
                        </form>
                    </div>

                </div>
                <div class="wg-table table-all-users">

                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-users">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Total Orders</th>
                                    <th>Orders</th>
                                </tr>
                            </thead>
                            <tbody id="table-body">
                                @foreach ($users as $user)
                                    <tr>
                                        <th>{{ $user->id }}</th>
                                        <td class="pname">
                                            <div class="image">
                                                <img src="user-1.html" alt="" class="image">
                                            </div>
                                            <div class="name">
                                                <div class="body-title-2">{{ $user->name }}</div>
                                                <div class="text-tiny mt-3">{{ $user->utype }}</div>
                                            </div>
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->mobile }}</td>
                                        <td>
                                            @if ($user->utype == 'ADM')
                                                <p target="_blank">-</p>
                                            @else
                                                <p target="_blank">{{ $user->orders_count }}</p>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($user->utype == 'ADM')
                                                <div class="list-icon-function">
                                                </div>
                                            @else
                                                <div class="list-icon-function">
                                                    <a href="{{ route('admin.user.orders', ['user_id' => $user->id]) }}">
                                                        <div class="item eye">
                                                            <i class="icon-file-text"></i>
                                                        </div>
                                                    </a>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="divider"></div>
                <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">

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
                    url: "{{ route('admin.user.search') }}",
                    type: "GET",
                    data: { search: search },
                    success: function (data) {

                        let rows = "";

                        if (data.length === 0) {
                            rows = `
                            <tr>
                                <td colspan="6" class="text-center">
                                    No user found for "<b>${search}</b>"
                                </td>
                            </tr>`;
                        } else {

                            data.forEach(item => {

                                rows += `
                                <tr>
                                    <th>${item.id}</th>
                                    <td class="pname">
                                        <div class="image">
                                            <img src="#" class="image">
                                        </div>
                                        <div class="name">
                                            <div class="body-title-2">${item.name}</div>
                                            <div class="text-tiny mt-3">${item.utype}</div>
                                        </div>
                                    </td>

                                    <td>${item.email}</td>
                                    <td>${item.mobile ?? '-'}</td>

                                    <td>
                                        ${item.utype === 'ADM'
                                        ? '-'
                                        : (item.orders ? item.orders.length : 0)
                                    }
                                    </td>

                                    <td>
                                        ${item.utype === 'USR'
                                        ? `
                                                <div class="list-icon-function">
                                                    <a href="/admin/user/${item.id}/orders">
                                                        <div class="item eye">
                                                            <i class="icon-file-text"></i>
                                                        </div>
                                                    </a>
                                                </div>
                                            `
                                        : ''
                                    }
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