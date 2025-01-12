@extends('store.base')

@section('bodyContent')
    <div class="container mt-5">
        <h1 class="mb-4">My Account</h1>

        <!-- Tabs Navigation -->
        <ul class="nav nav-tabs" id="accountTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="account-details-tab" data-bs-toggle="tab" data-bs-target="#account-details" type="button" role="tab" aria-controls="account-details" aria-selected="true">
                    Account Details
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="addresses-tab" data-bs-toggle="tab" data-bs-target="#addresses" type="button" role="tab" aria-controls="addresses" aria-selected="false">
                    Addresses
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="orders-tab" data-bs-toggle="tab" data-bs-target="#orders" type="button" role="tab" aria-controls="orders" aria-selected="false">
                    Orders
                </button>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content mt-3" id="accountTabsContent">
            <!-- Account Details Tab -->
            <div class="tab-pane fade show active" id="account-details" role="tabpanel" aria-labelledby="account-details-tab">
                <h4>Account Details</h4>
                <form method="POST">
                    @csrf
                    <!-- Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" id="name" name="name" class="form-control" value="{{ auth()->user()->name }}" required>
                    </div>
                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-control" value="{{ auth()->user()->email }}" required>
                    </div>
                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">New Password</label>
                        <input type="password" id="password" name="password" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>

            <!-- Addresses Tab -->
            <div class="tab-pane fade" id="addresses" role="tabpanel" aria-labelledby="addresses-tab">
                <h4>Addresses</h4>
                @if($addresses->isEmpty())
                    <p>You have no saved addresses.</p>
                @else
                    <ul class="list-group">
                        @foreach($addresses as $address)
                            <li class="list-group-item">
                                {{ $address->street }}, {{ $address->city }}, {{ $address->state }} - {{ $address->postal_code }}
                            </li>
                        @endforeach
                    </ul>
                @endif
{{--                <a href="{{ route('addresses.add') }}" class="btn btn-secondary mt-3">Add New Address</a>--}}
            </div>

            <!-- Orders Tab -->
            <div class="tab-pane fade" id="orders" role="tabpanel" aria-labelledby="orders-tab">
                <h4>Orders</h4>
                @if($orders->isEmpty())
                    <p>You have no orders yet.</p>
                @else
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->created_at->format('d M Y') }}</td>
                                <td>{{ $order->status }}</td>
                                <td>${{ number_format($order->total, 2) }}</td>
                                <td>
                                    <a href="{{ route('orders.view', $order->id) }}" class="btn btn-sm btn-info">View</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
@endsection
