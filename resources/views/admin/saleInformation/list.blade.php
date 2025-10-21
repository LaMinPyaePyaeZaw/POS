@extends('admin.layouts.master')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">


        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="d-flex justify-content-between">
                    <div class="">
                        <h6 class="m-0 font-weight-bold text-primary">Sale Information</h6>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th> Name </th>
                                <th>Date</th>
                               
                                <th>Order Code</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                           @foreach ($order as $item)
                           
                           <tr>
                            <input type="hidden" name="" value="{{$item->order_code}}" class="orderCode">
                               <td><a href="{{route('accountProfile',$item->user_id)}}">{{$item->user_name}}</a></td>
                               <td>{{$item->created_at->format('j-F-Y')}}</td>
                              
                               <td><a href="{{ route('userOrderDetails',$item->order_code ) }}">{{ $item->order_code }}</a></td>
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

@section('script-section')
    <script>
        $(document).ready(function(){
            $('.statusChange').change(function(){
                //console.log("change event running");
                $currentStatus = $(this).val();
                $orderCode = $(this).parents("tr").find(".orderCode").val();
                $data = {
                    'status' : $currentStatus , 
                    'orderCode' : $orderCode
                }
                //console.log($data);
                $.ajax({
                    type : 'get' , 
                    url : 'change/status' , 
                    data : $data , 
                    dataType : 'json'
                })

                
            })
        })
    </script>
@endsection
