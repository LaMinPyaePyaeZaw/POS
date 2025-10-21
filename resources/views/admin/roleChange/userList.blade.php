@extends('admin.layouts.master')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">


        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="d-flex justify-content-between">
                    <div class="">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <form action="" method="GET">
                                <div class="input-group mb-3">
                                    <input type="text" name="searchKey" class="form-control"
                                        placeholder="Search admin..." value="{{ request('searchKey') }}"
                                        aria-label="Recipient's username" aria-describedby="button-addon2">
                                    <button class="btn btn-outline-secondary" type="submit" id="button-addon2"><i
                                            class="fa-solid fa-magnifying-glass"></i></button>
                                </div>
                            </form>
                        </h6>
                    </div>
                    
                </div>
                <div class="d-flex justify-content-between">

                    
                </div>
            </div>
            <div class=" d-flex mb-2 mt-3">
                <a href="{{route('adminList')}}" class="btn btn-secondary ml-2 mr-3">Admin List <span class=" badge badge-light">{{$adminCount}}</span></a>
                <a href="{{route('userList')}}" class="btn btn-secondary ">User List <span class=" badge badge-light">{{$userList->total()}}</span></a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="">Name</th>
                                <th class="">Email</th>
                                <th class="">Phone</th>
                                <th class="">Address</th>
                                <th class="">Role</th>
                                <th class=""></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($userList as $item)
                                <tr>
                                    <td>
                                        @if ($item->name != null)
                                            <a href="{{route('accountProfile',$item->id)}}">{{ $item->name }}</a>
                                        @else
                                            <a href="{{route('accountProfile',$item->id)}}">{{ $item->nickname }}</a> 
                                        @endif
                                    </td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->phone }}</td>
                                    <td>{{ $item->address }}</td>
                                    <td>{{ $item->role }}</td>
                                    <td>
                                        @if (auth()->user()->role == 'superadmin')
                                            
                                                <a href="{{ route('deleteAdmin', $item->id) }}">
                                                    <button class="btn btn-sm btn-danger"><i
                                                            class="fa-solid fa-trash-can"></i></button>
                                                </a>
                                                <a href="{{ route('roleChange', $item->id) }}">
                                                    <button class="btn btn-sm bg-dark text-white"><i class="fa-solid fa-arrow-up"></i> Change to Admin Role</button>
                                                </a>
                                            
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class=" d-flex justify-content-end">{{$userList->links()}}</div>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
@endsection
