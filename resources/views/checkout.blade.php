@extends('layouts.app')

@section('content')
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="shop-checkout container">
            <h2 class="page-title">Shipping and Checkout</h2>
            <div class="checkout-steps">
                <a href="{{ route('cart.index') }}" class="checkout-steps__item active">
                    <span class="checkout-steps__item-number">01</span>
                    <span class="checkout-steps__item-title">
                        <span>Shopping Bag</span>
                        <em>Manage Your Items List</em>
                    </span>
                </a>
                <a href="javascript:void(0)" class="checkout-steps__item active">
                    <span class="checkout-steps__item-number">02</span>
                    <span class="checkout-steps__item-title">
                        <span>Shipping and Checkout</span>
                        <em>Checkout Your Items List</em>
                    </span>
                </a>
                <a href="javascript:void(0)" class="checkout-steps__item">
                    <span class="checkout-steps__item-number">03</span>
                    <span class="checkout-steps__item-title">
                        <span>Confirmation</span>
                        <em>Review And Submit Your Order</em>
                    </span>
                </a>
            </div>
            <form name="checkout-form" action="{{route('cart.place.an.order')}}" method="POST">
                @csrf
                <div class="checkout-form">
                    <div class="billing-info__wrapper">
                        <div class="row">
                            <div class="col-6">
                                <h4>SHIPPING DETAILS</h4>
                            </div>
                            <div class="col-6 text-end">
                                @if($addresses->count() > 0)
                                    <a href="{{ route('user.addresses') }}" class="btn btn-sm btn-outline-primary">Manage Addresses</a>
                                @endif
                            </div>
                        </div>

                        @if ($addresses->count() > 0)
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <h5 class="mb-3">Select Shipping Address</h5>
                                    <div class="my-account__address-list">
                                        @foreach($addresses as $addr)
                                            <div class="my-account__address-list-item mb-3" style="border: 2px solid {{ $defaultAddress && $defaultAddress->id == $addr->id ? '#007bff' : '#e0e0e0' }}; padding: 15px; border-radius: 5px; cursor: pointer;" onclick="selectAddress({{ $addr->id }})">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="address_id" id="address_{{ $addr->id }}" value="{{ $addr->id }}" {{ $defaultAddress && $defaultAddress->id == $addr->id ? 'checked' : '' }}>
                                                    <label class="form-check-label w-100" for="address_{{ $addr->id }}">
                                                        <div class="my-account__address-item-detail">
                                                            <div class="d-flex gap-2 mb-2">
                                                                @if($addr->isdefault)
                                                                    <span class="badge bg-primary">Default</span>
                                                                @endif
                                                                <span class="badge bg-secondary">{{ ucfirst($addr->type) }}</span>
                                                            </div>
                                                            <p><strong>{{ $addr->name }}</strong></p>
                                                            <p>{{ $addr->address }}</p>
                                                            <p>{{ $addr->locality }}</p>
                                                            @if($addr->landmark)
                                                                <p>{{ $addr->landmark }}</p>
                                                            @endif
                                                            <p>{{ $addr->city }}, {{ $addr->state }}, {{ $addr->country }}</p>
                                                            <p>Post Code: {{ $addr->zip }}</p>
                                                            <p>Phone: {{ $addr->phone }}</p>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="mt-3">
                                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="showNewAddressForm()">Add New Address</button>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3" id="new-address-form" style="display: none;">
                                <div class="col-md-12">
                                    <h5 class="mb-3">Add New Address</h5>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control new-address-field" name="name" value="{{ old('name') }}">
                                        <label for="name">Full Name *</label>
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control new-address-field" name="phone" value="{{ old('phone') }}">
                                        <label for="phone">Phone Number *</label>
                                        @error('phone')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control new-address-field" name="zip" value="{{ old('zip') }}">
                                        <label for="zip">Post Code *</label>
                                        @error('zip')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating mt-3 mb-3">
                                        <input type="text" class="form-control new-address-field" name="state" value="{{ old('state') }}">
                                        <label for="state">State *</label>
                                        @error('state')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control new-address-field" name="city" value="{{ old('city') }}">
                                        <label for="city">Town / City *</label>
                                        @error('city')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control new-address-field" name="address" value="{{ old('address') }}">
                                        <label for="address">House no, Building Name *</label>
                                        @error('address')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control new-address-field" name="locality" value="{{ old('locality') }}">
                                        <label for="locality">Road Name, Area, Colony *</label>
                                        @error('locality')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control new-address-field" name="landmark" value="{{ old('landmark') }}">
                                        <label for="landmark">Landmark</label>
                                        @error('landmark')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        @else
                            {{-- Show address form when user has no saved addresses --}}
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <h5 class="mb-3">Shipping Address</h5>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control" name="name" required value="{{ old('name') }}">
                                        <label for="name">Full Name *</label>
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control" name="phone" required value="{{ old('phone') }}">
                                        <label for="phone">Phone Number *</label>
                                        @error('phone')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control" name="zip" required value="{{ old('zip') }}">
                                        <label for="zip">Post Code *</label>
                                        @error('zip')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating mt-3 mb-3">
                                        <input type="text" class="form-control" name="state" required value="{{ old('state') }}">
                                        <label for="state">State *</label>
                                        @error('state')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control" name="city" required value="{{ old('city') }}">
                                        <label for="city">Town / City *</label>
                                        @error('city')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control" name="address" required value="{{ old('address') }}">
                                        <label for="address">House no, Building Name *</label>
                                        @error('address')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control" name="locality" required value="{{ old('locality') }}">
                                        <label for="locality">Area *</label>
                                        @error('locality')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control" name="landmark" value="{{ old('landmark') }}">
                                        <label for="landmark">Landmark</label>
                                        @error('landmark')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="checkout__totals-wrapper">
                        <div class="sticky-content">
                            <div class="checkout__totals">
                                <h3>Your Order</h3>
                                <table class="checkout-cart-items">
                                    <thead>
                                        <tr>
                                            <th>PRODUCT</th>
                                            <th align="right">SUBTOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach (Cart::instance('cart') as $item)
                                            <tr>
                                                <td>
                                                    {{ $item->name }} x {{ $item->qty }}
                                                </td>
                                                <td align="right">
                                                    IDR {{ $item->subtotal() }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @if (Session::has('discounts'))
                                    <table class="checkout-totals">
                                        <tbody>
                                            <tr>
                                                <th>Subtotal</th>
                                                <td class="text-right">Rp {{Cart::instance('cart')->subtotal()}}</td>
                                            </tr>
                                            <tr>
                                                <th>Discount {{ Session::get('coupon')['code'] }}</th>
                                                <td class="text-right">{{ formatRupiah(Session::get('discounts')['discount']) }}</td>
                                            </tr>
                                            <tr>
                                                <th>Subtotal After Discount</th>
                                                <td class="text-right">{{ formatRupiah(Session::get('discounts')['subtotal']) }}</td>
                                            </tr>
                                            <tr>
                                                <th>Shipping</th>
                                                <td class="text-right">Free</td>
                                            </tr>
                                            <tr>
                                                <th>TAX</th>
                                                <td class="text-right">{{ formatRupiah(Session::get('discounts')['tax']) }}</td>
                                            </tr>
                                            <tr>
                                                <th>Total</th>
                                                <td class="text-right">{{ formatRupiah(Session::get('discounts')['total']) }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                @else
                                    <table class="checkout-totals">
                                        <tbody>
                                            <tr>
                                                <th>Subtotal</th>
                                                <td class="text-right">Rp {{ Cart::instance('cart')->subtotal() }}</td>
                                            </tr>
                                            <tr>
                                                <th>Shipping</th>
                                                <td class="text-right">Free shipping</td>
                                            </tr>
                                            <tr>
                                                <th>TAX</th>
                                                <td class="text-right">Rp {{ Cart::instance('cart')->tax() }}</td>
                                            </tr>
                                            <tr>
                                                <th>Total</th>
                                                <td class="text-right">Rp {{ Cart::instance('cart')->total() }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                            <div class="checkout__payment-methods">
                                <div class="form-check">
                                    <input class="form-check-input form-check-input_fill" type="radio" name="mode" id="mode1" value="card">
                                    <label class="form-check-label" for="mode1">
                                        Debit or Credit Card
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input form-check-input_fill" type="radio" name="mode" id="mode2" value="paypal">
                                    <label class="form-check-label" for="mode2">
                                        Paypal
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input form-check-input_fill" type="radio" name="mode" id="mode3" value="cod">
                                    <label class="form-check-label" for="mode3">
                                        Cash on delivery
                                    </label>
                                </div>
                                <div class="policy-text">
                                    Your personal data will be used to process your order, support your experience
                                    throughout this
                                    website, and for other purposes described in our <a href="terms.html"
                                        target="_blank">privacy
                                        policy</a>.
                                </div>
                            </div>
                            <button class="btn btn-primary btn-checkout">PLACE ORDER</button>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </main>

    <script>
        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            const addressIdSelected = document.querySelector('input[name="address_id"]:checked');
            if (addressIdSelected) {
                // Remove required from new address fields if address is already selected
                document.querySelectorAll('.new-address-field').forEach(field => {
                    field.removeAttribute('required');
                });
            } else {
                // If no addresses exist, ensure all address fields are required
                const newAddressForm = document.getElementById('new-address-form');
                if (!newAddressForm || newAddressForm.style.display === 'none') {
                    // User has no addresses, form fields should already have required attribute
                }
            }
        });

        function selectAddress(addressId) {
            document.getElementById('address_' + addressId).checked = true;
            document.getElementById('new-address-form').style.display = 'none';
            // Remove required from new address fields
            document.querySelectorAll('.new-address-field').forEach(field => {
                field.removeAttribute('required');
            });
        }

        function showNewAddressForm() {
            document.getElementById('new-address-form').style.display = 'block';
            // Uncheck all address radios
            document.querySelectorAll('input[name="address_id"]').forEach(radio => {
                radio.checked = false;
            });
            // Add required to new address fields
            document.querySelectorAll('.new-address-field').forEach(field => {
                if (field.name !== 'landmark') {
                    field.setAttribute('required', 'required');
                }
            });
        }

        // Handle form submission
        document.querySelector('form[name="checkout-form"]').addEventListener('submit', function(e) {
            const addressIdSelected = document.querySelector('input[name="address_id"]:checked');
            const newAddressFormVisible = document.getElementById('new-address-form') && 
                                         document.getElementById('new-address-form').style.display !== 'none';
            
            if (addressIdSelected) {
                // Remove required from new address fields when existing address is selected
                document.querySelectorAll('.new-address-field').forEach(field => {
                    field.removeAttribute('required');
                });
            } else if (newAddressFormVisible) {
                // Ensure new address fields are required when form is visible
                document.querySelectorAll('.new-address-field').forEach(field => {
                    if (field.name !== 'landmark') {
                        field.setAttribute('required', 'required');
                    }
                });
                // Clear any address_id value to ensure new address is used
                document.querySelectorAll('input[name="address_id"]').forEach(radio => {
                    radio.checked = false;
                });
            }
        });
    </script>
@endsection