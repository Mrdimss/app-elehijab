@extends('layouts.app')

@section('content')
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="my-account container">
            <h2 class="page-title">{{ isset($address) ? 'Edit Address' : 'Add New Address' }}</h2>
            <div class="row">
                <div class="col-lg-3">
                    @include('user.account-nav')
                </div>
                <div class="col-lg-9">
                    <div class="page-content my-account__edit">
                        <div class="my-account__edit-form">
                            <form action="{{ isset($address) ? route('user.addresses.update', $address->id) : route('user.addresses.store') }}" method="POST" class="needs-validation" novalidate>
                                @csrf
                                @if(isset($address))
                                    @method('PUT')
                                @endif

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-floating my-3">
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                                placeholder="Full Name" name="name" 
                                                value="{{ old('name', isset($address) ? $address->name : '') }}" required>
                                            <label for="name">Full Name *</label>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating my-3">
                                            <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                                placeholder="Phone Number" name="phone" 
                                                value="{{ old('phone', isset($address) ? $address->phone : '') }}" required>
                                            <label for="phone">Phone Number *</label>
                                            @error('phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating my-3">
                                            <input type="text" class="form-control @error('zip') is-invalid @enderror" 
                                                placeholder="Pincode" name="zip" 
                                                value="{{ old('zip', isset($address) ? $address->zip : '') }}" required>
                                            <label for="zip">Post Code *</label>
                                            @error('zip')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating my-3">
                                            <input type="text" class="form-control @error('state') is-invalid @enderror" 
                                                placeholder="State" name="state" 
                                                value="{{ old('state', isset($address) ? $address->state : '') }}" required>
                                            <label for="state">State *</label>
                                            @error('state')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating my-3">
                                            <input type="text" class="form-control @error('city') is-invalid @enderror" 
                                                placeholder="City" name="city" 
                                                value="{{ old('city', isset($address) ? $address->city : '') }}" required>
                                            <label for="city">Town / City *</label>
                                            @error('city')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating my-3">
                                            <input type="text" class="form-control @error('address') is-invalid @enderror" 
                                                placeholder="House no, Building Name" name="address" 
                                                value="{{ old('address', isset($address) ? $address->address : '') }}" required>
                                            <label for="address">House no, Building Name *</label>
                                            @error('address')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating my-3">
                                            <input type="text" class="form-control @error('locality') is-invalid @enderror" 
                                                placeholder="Road Name, Area, Colony" name="locality" 
                                                value="{{ old('locality', isset($address) ? $address->locality : '') }}" required>
                                            <label for="locality">Road Name, Area, Colony *</label>
                                            @error('locality')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-floating my-3">
                                            <input type="text" class="form-control @error('landmark') is-invalid @enderror" 
                                                placeholder="Landmark" name="landmark" 
                                                value="{{ old('landmark', isset($address) ? $address->landmark : '') }}">
                                            <label for="landmark">Landmark</label>
                                            @error('landmark')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="my-3">
                                            <label for="type" class="form-label">Address Type</label>
                                            <select class="form-select @error('type') is-invalid @enderror" name="type" id="type" style="height: 58px;">
                                                <option value="home" {{ old('type', isset($address) ? $address->type : 'home') == 'home' ? 'selected' : '' }}>Home</option>
                                                <option value="work" {{ old('type', isset($address) ? $address->type : '') == 'work' ? 'selected' : '' }}>Work</option>
                                                <option value="other" {{ old('type', isset($address) ? $address->type : '') == 'other' ? 'selected' : '' }}>Other</option>
                                            </select>
                                            @error('type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check my-3 pt-4">
                                            <input class="form-check-input" type="checkbox" name="isdefault" value="1" 
                                                id="isdefault" {{ old('isdefault', isset($address) ? $address->isdefault : false) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="isdefault">
                                                Set as default address
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row align-items-end">
                                        <div class="my-2 col">
                                            <a href="{{ route('user.addresses') }}" class="btn btn-secondary">Cancel</a>
                                        </div>
                                        <div class="my-2 col text-end">
                                            <button type="submit" class="btn btn-primary rounded-3">
                                                {{ isset($address) ? 'Update Address' : 'Save Address' }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

