@extends('admin.layouts.master')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">


        <!-- DataTales Example -->
        <div class="card shadow mb-4 col">
            <div class="card-header py-3">
                <div class="">
                    <div class="">
                        <h6 class="m-0 font-weight-bold text-primary">Account Information</h6>
                    </div>
                </div>
            </div>
            <form >
                @csrf
                <div class="card-body">
                    <div class="row col-10 offset-1">
                        <div class="col-3">
                            
                            @if ($account->role == 'user' && $account->image == null)
                                <img class="img-profile  img-thumbnail" id="output"
                                src="{{ asset('admin/img/undraw_profile.svg') }}">
                            @elseif ($account->role == 'admin' && $account->image == null)
                                <img class="img-profile  img-thumbnail" id="output"
                                src="{{ asset('admin/img/undraw_profile.svg') }}">
                            @elseif ($account->role == 'admin' || $account->role == 'superadmin')
                                <img class="img-profile  img-thumbnail" id="output"
                                src="{{ asset('adminProfile/'.$account->image) }}">
                            @else
                                <img class="img-profile  img-thumbnail" id="output"
                                src="{{ asset('userProfile/'.$account->image) }}">
                            @endif

                        </div>

                        <div class="col">
                            <div class="row mt-3 ">
                                <div class="col-2 fs-4">Name</div>
                                <div class="col fs-4">{{$account->name == null ? $account->nickname : $account->name}}</div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-2 fs-4">email</div>
                                <div class="col fs-4">{{$account->email}}</div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-2 fs-4">Phone</div>
                                <div class="col fs-4">{{$account->phone== null ? '...' : $account->phone}}</div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-2 fs-4">Address</div>
                                <div class="col fs-4">{{$account->address == null ? '...' : $account->address}}</div>
                            </div>
                            
                        </div>
                    </div>
                    
            </form>

        </div>
    </div>

    </div>
    <!-- /.container-fluid -->
@endsection
