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
                        <input type="search" class="form-control p-3" placeholder="keywords" aria-describedby="search-icon-1">
                        <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Search End -->


    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Order List</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="{{route('customerDashboard')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('shopList')}}">Shop</a></li>
            <li class="breadcrumb-item active text-white">Orders</li>
        </ol>
    </div>
    <!-- Single Page Header End -->


    <!-- Cart Page Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="table-responsive">
                <table class="table" id="dataTable">
                    <thead>
                      <tr>
                        <th scope="col">Order Code</th>
                        <th scope="col">Date</th>
                        <th scope="col">Price</th>
                        <th scope="col">Order Status</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($order as $item)
                        <tr>
                                <td><p class="mb-0 mt-4"><a href="{{ route('orderDetails',$item->order_code)}}">{{$item->order_code }}</a></p></td>
                                <td><p class="mb-0 mt-4">{{$item->created_at->format('j-F-Y')}}</p></td>
                                <td><p class="mb-0 mt-4">{{$item->total_price}}</p></td>
                                <td>
                                    @if ($item->status == 0)
                                        <p class="text-warning mt-4">Pending</p>
                                    @elseif($item->status == 1)
                                        <p class="text-success mt-4">Success</p>
                                    @elseif($item->status == 2)
                                        <p class="text-danger mt-4">Reject</p>
                                    @endif
                                </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Cart Page End -->
@endsection

