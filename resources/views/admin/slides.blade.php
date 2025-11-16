@extends('layouts.admin')

@section('content')
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Slides</h3>
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
                        <div class="text-tiny">Slides</div>
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
                                <button class="" type="submit"><i class="icon-search"></i></button>
                            </div>
                        </form>
                    </div>
                    <a class="tf-button style-1 w208" href="{{ route('admin.slide.add') }}"><i class="icon-plus"></i>Add
                        new</a>
                </div>
                <div class="wg-table table-all-slide">
                    <div class="table-responsie">
                        @if(Session::has('status'))
                            <p class="alert alert-success">{{Session::get('status')}}</p>
                        @endif
                        <table class="table table-striped table-hover table-slide">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Image</th>
                                    <th>Tagline</th>
                                    <th>Title</th>
                                    <th>Subtitle</th>
                                    <th>Link</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="table-body">
                                @foreach ($slides as $key => $slide)
                                    <tr>
                                        <th>{{ $slide->id }}</th>
                                        <td class="pname">
                                            <div class="image">
                                                <img src="{{ asset('uploads/slides') }}/{{ $slide->image }}"
                                                    alt="{{ $slide->title }}" class="image">
                                            </div>
                                        </td>
                                        <td>{{ $slide->tagline }}</td>
                                        <td>{{ $slide->title }}</td>
                                        <td>{{ $slide->subtitle }}</td>
                                        <td>{{ $slide->link }}</td>
                                        <td>
                                            <div class="list-icon-function">
                                                <a href="{{ route('admin.slide.edit', ['id' => $slide->id]) }}">
                                                    <div class="item edit">
                                                        <i class="icon-edit-3"></i>
                                                    </div>
                                                </a>
                                                <form action="{{ route('admin.slide.delete', ['id' => $slide->id]) }}"
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
                </div>
                <div class="divider"></div>
                <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                    {{ $slides->links('pagination::bootstrap-5') }}
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
                    text: "You want to delete this slide?",
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
            $('#search').on('keyup', function () {
                let search = $(this).val();

                $.ajax({
                    url: "{{ route('admin.slide.search') }}",
                    type: "GET",
                    data: { search: search },
                    success: function (data) {
                        let rows = '';

                        if (data.length === 0) {
                            rows = `<tr><td colspan="6" class="text-center">No slide found for "<b>${search}</b>"</td></tr>`;
                        } else {
                            data.forEach((item, index) => {
                                rows += `
                                    <tr>
                                        <th>${item.id}</th>
                                        <td class="pname">
                                            <div class="image">
                                                <img src="{{ asset('uploads/slides') }}/${item.image}"
                                                    alt="${item.title}" class="image">
                                            </div>
                                        </td>
                                        <td>${item.tagline}</td>
                                        <td>${item.title}</td>
                                        <td>${item.subtitle}</td>
                                        <td>${item.link}</td>
                                        <td>
                                            <div class="list-icon-function">
                                                <a href="/admin/slide/${item.id}/edit">
                                                    <div class="item edit">
                                                        <i class="icon-edit-3"></i>
                                                    </div>
                                                </a>
                                                <form action="/admin/slide/${item.id}/delete"
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