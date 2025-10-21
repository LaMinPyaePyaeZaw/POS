@extends('admin.layouts.master')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">


        <!-- DataTales Example -->
        <div class="card shadow mb-4 col">
            <div class="card-header py-3">
                <div class="">
                    <div class="">
                        <h6 class="m-0 font-weight-bold text-primary">Payment Page</h6>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-4">
                        <form action="{{ route('createPayment') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Payment Id</label>
                                <input type="text" class="form-control  @error('paymentId') is-invalid @enderror"
                                    name="paymentId" value="{{ old('paymentId') }}" id="exampleFormControlInput1"
                                    placeholder="Eg-09*********">
                                @error('paymentId')
                                    <small class=" invalid-feedback">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Choose Payment Method</label>
                                <select name="paymentMethod"
                                    class="form-control @error('paymentMethod') is-invalid @enderror" id="">
                                    <option value="">Choose Payment Method</option>
                                    <option value="Wave Pay">Wave Pay</option>
                                    <option value="KBZ Pay">KBZ Pay</option>
                                </select>
                                @error('paymentMethod')
                                    <small class=" invalid-feedback">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Account Name</label>
                                <input type="text" class="form-control  @error('accountName') is-invalid @enderror"
                                    name="accountName" value="{{ old('accountName') }}" id="exampleFormControlInput1"
                                    placeholder="Enter Account Name...">
                                @error('accountName')
                                    <small class=" invalid-feedback">{{ $message }}</small>
                                @enderror
                            </div>
                            <input type="submit" value="Create" class="btn btn-primary">
                        </form>
                    </div>
                    <div class="col">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Account Id</th>
                                        <th>Account Name</th>
                                        <th>Payment Type</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{$item->account_number}}</td>
                                            <td>{{$item->account_name}}</td>
                                            <td>{{$item->type}}</td> 
                                            <td>
                                                <a href="{{route('paymentEdit',$item->id)}}"><i class="fa-solid fa-pen-to-square btn btn-outline-secondary"></i></a>
                                                <a href="{{route('paymentDelete',$item->id)}}"><i class="fa-solid fa-trash-can btn btn-outline-danger"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    

                                </tbody>
                            </table>
                            <span class=" d-flex justify-content-end">{{$data->links()}}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
@endsection
