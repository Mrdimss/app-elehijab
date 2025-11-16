@extends('layouts.admin')

@section('content')
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>All Messages</h3>
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
                        <div class="text-tiny">Messages</div>
                    </li>
                </ul>
            </div>

            <div class="wg-box">
                <div class="flex items-center justify-between gap10 flex-wrap">
                    <div class="wg-filter flex-grow">
                        <form class="form-search">
                            <fieldset class="name">
                                <input type="text" placeholder="Search here..." class="" id="search" name="name" tabindex="2" value=""
                                    aria-required="true" required="">
                            </fieldset>
                            <div class="button-submit">
                                <button class="" type="submit"><i class="icon-search"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="wg-table table-all-contact">
                    <div class="table-responsive">
                        @if(Session::has('status'))
                            <p class="alert alert-success">{{Session::get('status')}}</p>
                        @endif
                        <table class="table table-striped table-hover table-contact">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Message</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="table-body">
                                @foreach ($contacts as $contact)
                                    <tr>
                                        <th>{{ $contact->id }}</th>
                                        <td>{{ $contact->name }}</td>
                                        <td>{{ $contact->email }}</td>
                                        <td>{{ $contact->phone }}</td>
                                        <td>{{ $contact->comment }}</td>
                                        <td>{{ $contact->created_at }}</td>
                                        <td>
                                            <div class="list-icon-function">
                                                <form action="{{ route('admin.contact.delete', ['id'=>$contact->id]) }}" method="POST">
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
                </div>
                <div class="divider"></div>
                <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                    {{ $contacts->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function(){
            $('.delete').on('click',function(e){
                e.preventDefault();
                var form = $(this).closest('form');
                swal({
                    title: "Are you Sure?",
                    text: "You want to delete this message?",
                    type: "warning",
                    buttons: ["No","Yes"],
                    confirmButtonColor: '#dc3545'
                }).then(function(result){
                    if(result){
                        form.submit();
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function () {
            $('#search').on('keyup', function () {
                let search = $(this).val();

                $.ajax({
                    url: "{{ route('admin.contact.search') }}",
                    type: "GET",
                    data: { search: search },
                    success: function (data) {
                        let rows = '';

                        if (data.length === 0) {
                            rows = `<tr><td colspan="6" class="text-center">No message found for "<b>${search}</b>"</td></tr>`;
                        } else {
                            data.forEach((item, index) => {
                                rows += `
                                    <tr>
                                        <th>${item.id}</th>
                                        <td>${item.name}</td>
                                        <td>${item.email}</td>
                                        <td>${item.phone}</td>
                                        <td>${item.comment}</td>
                                        <td>${item.created_at}</td>
                                        <td>
                                            <div class="list-icon-function">
                                                <form action="/admin/contact/${item.id}/delete" method="POST">
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