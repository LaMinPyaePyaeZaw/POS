@extends('user.layouts.master')

@section('content')
    <!-- Modal Search Start -->
    <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Search by keyword</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex align-items-center">
                    <div class="input-group w-75 mx-auto d-flex">
                        <input type="search" class="form-control p-3" placeholder="keywords"
                            aria-describedby="search-icon-1">
                        <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Search End -->


    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Payment</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Pages</a></li>
            <li class="breadcrumb-item active text-white">Payment</li>
        </ol>
    </div>
    <!-- Single Page Header End -->


    <!-- Cart Page Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="row mt-2">
                <div class="card col-10 offset-1 shadow-sm">
                    <div class="card-body">


                        <div class="row">
                            <div class="col-5">
                                <h5 class="mb-5">Payment Account Info</h5>

                                @foreach ($payment as $item)
                                    <div class="">{{ $item->type }}( {{ $item->account_name }})</div>
                                    Account : {{ $item->account_number }}
                                    <hr>
                                @endforeach
                            </div>
                            <div class="col-7">
                                <div class="container">
                                    <form action="{{ route('orderProduct') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-25">
                                                <label for="fname">Name</label>
                                            </div>
                                            <div class="col-75">
                                                <input type="text " id="fname" class="payment-form" name="name" value="{{old('name')}}">
                                                <br>
                                                @error('name')
                                                    <small class=" text-danger">Name is required</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-25">
                                                <label for="lname">Phone</label>
                                            </div>
                                            <div class="col-75">
                                                <input type="text" class="payment-form" id="lname" name="phone" value="{{old('phone')}}">
                                                <br>
                                                @error('phone')
                                                    <small class=" text-danger">Phone is required</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-25">
                                                <label for="lname">Order Code</label>
                                            </div>
                                            <div class="col-75">
                                                <input type="hidden" name="orderCode"
                                                    value="{{ $orderProduct[0]['order_code'] }}">
                                                <label for="">{{ $orderProduct[0]['order_code'] }}</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-25">
                                                <label for="lname">Total Amount</label>
                                            </div>
                                            <div class="col-75">
                                                <input type="hidden" name="totalAmount" value="{{ $total + 3000 }}">
                                                <label for="">{{ $total + 3000 }} MMK</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-25">
                                                <label for="country">Payment Method</label>
                                            </div>
                                            <div class="col-75">
                                                <select id="country" name="paymentMethod" class="payment-form">
                                                  <option value="">Choose Payment</option>
                                                    @foreach ($payment as $item)
                                                        <option value="{{ $item->id }}" @if (old('paymentMethod') == $item->id) selected @endif>{{ $item->type }}</option>
                                                    @endforeach
                                                </select>
                                                @error('paymentMethod')
                                                    <small class=" text-danger">Payment-method is required</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-25">
                                                <label for="lname">Payment Screenshot</label>
                                            </div>
                                            <div class="col-75">
                                                <input type="file" class="payment-form" id="lname"
                                                    name="payslipImage">
                                                @error('payslipImage')
                                                    <small class=" text-danger">Payment Screenshot is required</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <br>
                                        <div class="row">
                                            <input type="submit" class="submit-btn" value="Order Prodcuts">
                                        </div>
                                    </form>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart Page End -->
@endsection
