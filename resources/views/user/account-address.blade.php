@extends('layouts.app')

@section('content')
    <style>
    .text-success {
      color: #278c04 !important;
    }

    .text-danger .coupon-remove {
      color: rgb(212, 0, 0) !important;
    }
  </style>
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="my-account container">
            <h2 class="page-title">Addresses</h2>
            <div class="row">
                <div class="col-lg-3">
                    @include('user.account-nav')
                </div>
                <div class="col-lg-9">
                    <div class="page-content my-account__address">
                        @if(session('status'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('status') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        <div class="row">
                        <div class="col-6">
                            <h4>Your Addresses</h4>
                            <p class="notice">The following addresses will be used on the checkout page by default.</p>
                        </div>
                        <div class="col-6 text-right">
                            <a href="{{ route('user.addresses.create') }}"><button class="btn btn-sm btn-primary">Add New</button></a>
                        </div>
                        </div>

                        @if($addresses->count() > 0)
                            <div class="my-account__address-list row">
                                @foreach($addresses as $address)
                                    <div class="my-account__address-item col-md-6 {{ $address->isdefault ? 'default-address' : '' }}">
                                        <div class="d-flex gap-2 mb-2">
                                                @if($address->isdefault)
                                                    <span class="badge bg-primary">Default Address</span>
                                                @endif
                                                <span class="badge bg-secondary">{{ ucfirst($address->type) }}</span>
                                            </div>
                                        <div class="my-account__address-item__title">
                                            <h5>{{ $address->name }} <i class="fa fa-check-circle text-success"></i></h5>
                                            <div class="d-flex gap-1">
                                                <a href="{{ route('user.addresses.edit', $address->id) }}" class="text-decoration-none">
                                                    <button class="btn btn-sm btn-success">Edit</button>
                                                </a>
                                                @if(!$address->isdefault)
                                                    <form action="{{ route('user.addresses.set-default', $address->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-outline-secondary">Set as Default</button>
                                                    </form>
                                                @endif
                                                <form action="{{ route('user.addresses.destroy', $address->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this address?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                </form>
                                            </div>
                                            
                                        </div>
                                        <div class="my-account__address-item__detail">
                                            <p>{{ $address->state }}, {{ $address->address }}, {{ $address->city }}</p>
                                            <p>{{ $address->locality }}, {{ $address->landmark }}</p>
                                            <p>{{ $address->country }}</p>
                                            <p>Post Code: {{ $address->zip }}</p>
                                            <br>
                                            <p>Phone: {{ $address->phone }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <p class="text-muted">No addresses found. Add your first address to get started.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

