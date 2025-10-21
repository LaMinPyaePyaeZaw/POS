@extends('user.layouts.master')

@section('content')
     <!-- Begin Page Content -->
     <div class="container-fluid">

                  
        <!-- DataTales Example -->
        <div class="row py-5 ">
            <div class="card shadow py-5 my-5  mb-4 col-5 offset-3">
                <div class="card-header py-3 mt-5">
                    <div class="">
                        <div class="">
                            <h6 class="m-0 font-weight-bold text-primary">Contact Us</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body ">
                    <form action="{{ route('contactReport') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Title</label>
                            <input type="title" class="form-control  @error('title') is-invalid @enderror" name="title" value="{{old('title')}}" id="exampleFormControlInput1">
                            @error('title')
                                <small class=" invalid-feedback">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Message</label>
                            <input type="message" class="form-control  @error('message') is-invalid @enderror" name="message" value="{{old('message')}}" id="exampleFormControlInput1" >
                            @error('message')
                                <small class=" invalid-feedback">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Email</label>
                            <input type="email" class="form-control  @error('email') is-invalid @enderror" name="email" value="{{old('email')}}" id="exampleFormControlInput1" >
                            @error('email')
                                <small class=" invalid-feedback">{{$message}}</small>
                            @enderror
                        </div>
                        <input type="submit" value="Report" class="btn btn-primary">
                    </form>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
@endsection