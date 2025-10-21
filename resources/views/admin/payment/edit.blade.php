@extends('admin.layouts.master')

@section('content')
     <!-- Begin Page Content -->
     <div class="container-fluid">

                  
        <!-- DataTales Example -->
        <div class="card shadow mb-4 col-5 offset-3">
            <div class="card-header py-3">
                <div class="">
                    <div class="">
                        <h6 class="m-0 font-weight-bold text-primary">Add Category Page</h6>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{route('paymentUpdate')}}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{$data->id}}">
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Payment Id</label>
                        <input type="text" class="form-control  @error('paymentId') is-invalid @enderror"
                            name="paymentId" value="{{ $data->account_number,old('paymentId') }}" id="exampleFormControlInput1"
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
                            <option value="Wave Pay" @if (old('paymentMethod' , $data->type == 'Wave Pay')) selected @endif>Wave Pay</option>
                            <option value="KBZ Pay" @if (old('paymentMethod' , $data->type == 'KBZ Pay')) selected @endif>KBZ Pay</option>
                        </select>
                        @error('paymentMethod')
                            <small class=" invalid-feedback">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Account Name</label>
                        <input type="text" class="form-control  @error('accountName') is-invalid @enderror"
                            name="accountName" value="{{ $data->account_name,old('accountName') }}" id="exampleFormControlInput1"
                            placeholder="Enter Account Name...">
                        @error('accountName')
                            <small class=" invalid-feedback">{{ $message }}</small>
                        @enderror
                    </div>
                    <input type="submit" value="Update" class="btn btn-primary">
                </form>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
@endsection