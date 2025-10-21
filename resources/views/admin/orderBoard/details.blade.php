@extends('admin.layouts.master')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <a href="{{ route('userOrderList')}}" class=" text-black m-3"><i class="fa-solid fa-arrow-left"></i>Back</a>
        <!-- DataTales Example -->

        <div class="row">
            <div class="card col-5 shadow-sm m-4">
            
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-5"> Name : </div>
                        <div class="col-7">{{$order[0]->customer_name}}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5"> Phone : </div>
                        <div class="col-7">{{$order[0]->user_phone}}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5"> Order Code : </div>
                        <div class="col-7">{{$order[0]->order_code}}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5"> Order Date : </div>
                        <div class="col-7">{{$order[0]->created_at->format("j-F-Y")}}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5"> Total Price : </div>
                        <div class="col-7">
                            {{$total + 3000}}<br>
                            <small class=" text-danger ms-1"> ( Contain Delivery Fee )</small>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="card col-5 shadow-sm m-4">
            
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-5"> Payslip Contact Phone : </div>
                        <div class="col-7">{{$payslipData->phone}}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5"> Payment Method : </div>
                        <div class="col-7">{{$payslipData->payment_type}}</div>
                    </div>
                    <div class="row mb-3">
                        <img style="width: 150px" src="{{asset('payslipRecords/'.$payslipData->payslip_image)}}" class=" img-thumbnail">
                    </div>
                </div>
            </div>
        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="d-flex justify-content-between">
                    <div class="">
                        <h6 class="m-0 font-weight-bold text-primary">Order Board</h6>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                
                                
                                <th class="col-1"> Image</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Count</th>
                                <th>Total Price</th>
                                <th>

                                </th>
                            </tr>
                        </thead>
                        <tbody>
                           @foreach ($order as $item)
                               <tr>
                                <td>
                                    <img  src="{{asset('productImages/'.$item->product_image)}}" class=" img-thumbnail " alt="">
                                </td>
                                <td>{{$item->product_name}}</td>
                                <td>{{$item->product_price}}</td>
                                <td>{{$item->order_count}}</td>
                                <td>{{$item->order_count * $item->product_price}}</td>
                               </tr>
                           @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
@endsection
