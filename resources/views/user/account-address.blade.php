@extends('layouts.app')

@section('content')
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

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4>Your Addresses</h4>
                            <a href="{{ route('user.addresses.create') }}" class="btn btn-primary">Add New Address</a>
                        </div>

                        @if($addresses->count() > 0)
                            <div class="my-account__address-list">
                                @foreach($addresses as $address)
                                    <div class="my-account__address-list-item {{ $address->isdefault ? 'default-address' : '' }}">
                                        <div class="my-account__address-item-detail">
                                            <div class="d-flex gap-2 mb-2">
                                                @if($address->isdefault)
                                                    <span class="badge bg-primary">Default Address</span>
                                                @endif
                                                <span class="badge bg-secondary">{{ ucfirst($address->type) }}</span>
                                            </div>
                                            <p><strong>{{ $address->name }}</strong></p>
                                            <p>{{ $address->address }}</p>
                                            <p>{{ $address->locality }}</p>
                                            @if($address->landmark)
                                                <p>{{ $address->landmark }}</p>
                                            @endif
                                            <p>{{ $address->city }}, {{ $address->state }}, {{ $address->country }}</p>
                                            <p>Post Code: {{ $address->zip }}</p>
                                            <p>Phone: {{ $address->phone }}</p>
                                        </div>
                                        <div class="my-account__address-item-actions">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('user.addresses.edit', $address->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                                @if(!$address->isdefault)
                                                    <form action="{{ route('user.addresses.set-default', $address->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-outline-secondary">Set as Default</button>
                                                    </form>
                                                @endif
                                                <form action="{{ route('user.addresses.destroy', $address->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this address?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                                </form>
                                            </div>
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

