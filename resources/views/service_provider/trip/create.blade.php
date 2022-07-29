@extends('layout.master')
@section('content')
    @push('css')
        <link rel="stylesheet" href={{ asset('css/admin/provider_create.css') }}>
        <link rel="stylesheet" href={{ asset('css/service_provider/trip_create.css') }}> 
    @endpush
@section('sidebar')
    @include(Session::get('user')['role'] . '.sidebar',['site'=>'trip'])
@endsection
<div class="admin-page  d-flex flex-column w-100 mr-2 ">
    <ul class="nav nav-tabs d-flex justify-content-end">
        <li class="nav-item">
            <a class="nav-link " id="show_list"href={{ route('serviceprovider.trip.index') }}>Xem</a>
        </li>
      
    </ul>
    @if (session('error'))
        <div class="alert alert-danger text-center">{{ session('error') }}</div>
    @endif
    <form action="{{ route('serviceprovider.trip.store') }}" >

        <div class="container mt-5 mb-5 d-flex justify-content-center">
            <div class="card px-1 py-4">
                <div class="card-body">
                    <div class="card-body min-20 px-md-5" id="message_display">
                    </div>
                    <h2 class="card-title mb-3 text-center">Thêm Chuyến Đi</h2>


                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="input-group">
                                    <label class="form-control label-time" >ID Lịch trình:</label>
                                    <input class="form-control"  
                                        type="number" value="{{$id}}" name="schedule_id">
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-sm-12 position-relative">
                            <div class="form-group ">
                                <div class="input-group">
                                    <label class="form-control " for="coach_display" >Loại xe:</label>
                                    <input class="form-control" type="text"  id="coach_display" autocomplete="off">

                                    <input class="form-control" type="text"  id="coach_id" name="coach_id" hidden>
                                </div>
                               
                            </div>
                            <div class="dropdown-container position-absolute">
                                <ul class="list-group " id="list_suggested">
                                </ul>
                            </div>
                           
                        </div>
                        
                    </div>


                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="input-group">
                                    <label class="form-control label-time" for="appt-time">Ngày khởi hành :</label>
                                    <input class="form-control" min="{{date('Y-m-d')}}"  id="departure-date" type="date" name="departure_time">
                                </div>
                            </div>
                        </div>
                    </div>


                   
                    <div class="row">
                        <div class="col-sm-12 ">
                            <div class="form-group ">
                                <div class="input-group">
                                    <label class="form-control label-time" for="price">Giá thành (VND):</label>
                                    <input class="form-control" id="price"
                                        type="currency" name="price">
                                </div>
                            </div>
                           
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
</div>
@push('js')
    <script>
        const object = "Chuyến đi";
        const urlCoachAPI='{{route('coaches')}}';
    </script>
    <script src="{{ asset('js/components/create_object.js') }}"></script>
    <script src="{{ asset('js/service_provider/trip_create.js') }}"></script>


@endpush


@stop
