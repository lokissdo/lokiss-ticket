@php
$role= Session::get('user')['role'];
@endphp
@extends('layout.master')
@section('content')
    @push('css')
        <link rel="stylesheet" href={{ asset('css/admin/provider_create.css') }}>
        <link rel="stylesheet" href={{ asset('css/service_provider/trip_create.css') }}> 
        <style>
            .instruction-col{
                background-color: #ffffff;
                color: rgba(46, 45, 45, 0.919);
                border: 1px solid rgb(130, 130, 130);
                padding: 7px 20px;
            }
            .error-item{
                margin-left: 10px;
            }
      
            </style>
    @endpush
@section('sidebar')
    @include($role . '.sidebar',['site'=>'trip'])
@endsection
<div class="admin-page  d-flex flex-column w-100 mr-2 ">
    <ul class="nav nav-tabs d-flex justify-content-between">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route("$role.index")}}" class="text-decoration-none">Home</a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('serviceprovider.trip.index') }}" class="text-decoration-none">Trip</a>
                </li>
                <li class="breadcrumb-item active">Create</li>
            </ol>
        </nav>
        <div class="d-flex">
            <li class="nav-item">
                <a class="nav-link " id="show_list"href={{ route('serviceprovider.trip.index') }}>Xem</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" id="show_list"href={{ route('serviceprovider.schedule.index') }}>Thêm</a>
            </li>
        </div>
       
      
    </ul>
    @if (session('error'))
        <div class="alert alert-danger text-center">{{ session('error') }}</div>
    @endif
    <h3>Bao gồm các cột:</h3>
    <div class="d-flex ">
        <div class="instruction-col">schedule_id( ID Lịch trình )</div>
        <div class="instruction-col">schedule_id (ID Xe)</div>
        <div class="instruction-col">departure_date(Ngày khởi hành)</div>
        <div class="instruction-col">price (Giá)</div>
    </div>
    
    <div class="card-body min-20 px-md-5 d-none" id="message_display">
    </div>
    <form id="form"action="{{ route('serviceprovider.trip.importing') }}" method="POST" enctype='multipart/form-data'>
        @csrf
        <div class="container mt-5 mb-5 d-flex justify-content-center">
            <div class="card px-1 py-4">
                <div class="card-body">
             
                    <h2 class="card-title mb-3 text-center">Thêm Chuyến Đi</h2>
                    <div class="form-group">
                        <div class="input-group">
                            <input class="form-control" id="appt-file" type="file" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" name="trips_file">
                        </div>
                    </div>


                    <div class=" d-flex flex-column text-center px-5 mt-3 mb-3">
                        <small class="agree-text">By submitting this form you agree to the</small>
                        <a href="#" class="terms">Terms & Conditions</a>
                    </div>
                    <button type="submit" id="submit-button"class="btn btn-primary btn-block confirm-button w-100">Confirm</button>
                </div>
            </div>
        </div>
    </form>
    @include('layout.footer')

</div>
@push('js')
    <script>
        const object = "Chuyến đi";
        const urlCoachAPI='{{route('coaches')}}';
    </script>
    <script src="{{ asset('js/components/create_object_form.js') }}"></script>

@endpush


@stop
