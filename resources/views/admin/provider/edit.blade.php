@extends('layout.master')
@section('content')
    @push('css')
        <link rel="stylesheet" href={{ asset('css/admin/provider_create.css') }}>
    @endpush
@section('sidebar')
@include('admin.sidebar',['site' => 'provider'])

@endsection
<div class="admin-page  d-flex flex-column w-100 mr-2 ">
    <ul class="nav nav-tabs d-flex justify-content-between">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.index') }}" class="text-decoration-none">Home</a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('admin.provider.index') }}" class="text-decoration-none">Service Provider</a>
                </li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
        <div class="d-flex">
            <li class="nav-item">
                <a class="nav-link " id="show-providers" href={{ route('admin.provider.index') }}>Xem</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href={{ route('admin.provider.create') }}>Thêm</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href={{ route('admin.provider.create') }}>Sửa</a>
            </li>
        </div>
       
    </ul>
    <form action="{{ route('admin.provider.update',['id'=>$provider->id]) }}" method="GET">
        @csrf
        <input type="hidden" name="id" value={{$provider->id}}>
        <div class="container mt-5 mb-5 d-flex justify-content-center">
            <div class="card px-1 py-4">
                <div class="card-body">
                    <div class="card-body min-20 px-md-5" id="message_display">                 
                      </div>
                    <h2 class="card-title mb-3 text-center">Sửa Nhà Xe</h2>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <!-- <label for="name">Name</label> --> <input class="form-control" name="name"type="text" value="{{$provider->name}}"
                                    placeholder="Name">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="input-group"> <input class="form-control" name="phone_number" type="text" value="{{$provider->phone_number}}"
                                        placeholder="Mobile">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="input-group"> <input class="form-control" name="email" type="text" value="{{$provider->email}}"
                                        placeholder="Email employer">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="input-group"> <select name="address" class="form-select " id="select_pro">
                                        <option data-code="null" class="input-group form-control" value="null"> Select
                                            city </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=" d-flex flex-column text-center px-5 mt-3 mb-3">
                        <small class="agree-text">By submitting this form you agree to the</small>
                        <a href="#" class="terms">Terms & Conditions</a>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block confirm-button w-100">Confirm</button>
                </div>
            </div>
        </div>
    </form>
</div>
@push('js')
    <script type="text/javascript">
     const   preAddressCode =['{{$provider->address}}'];
    </script>
    <script src="{{ asset('js/components/address.js') }}"></script>
    <script src="{{ asset('js/admin/edit_provider.js') }}"></script>

@endpush


@stop
