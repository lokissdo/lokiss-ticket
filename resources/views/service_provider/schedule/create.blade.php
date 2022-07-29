@extends('layout.master')
@section('content')
    @push('css')
        <link rel="stylesheet" href={{ asset('css/admin/provider_create.css') }}>
        <link rel="stylesheet" href={{ asset('css/admin/schedule_create.css') }}>
    @endpush
@section('sidebar')
    @include(Session::get('user')['role'] . '.sidebar',['site'=>'schedule'])
@endsection
<div class="admin-page  d-flex flex-column w-100 mr-2 ">
    <ul class="nav nav-tabs d-flex justify-content-end">
        <li class="nav-item">
            <a class="nav-link " id="show_list"href={{ route('serviceprovider.schedule.index') }}>Xem</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href={{ route('serviceprovider.schedule.create') }}>Thêm</a>
        </li>
    </ul>
    @if (session('error'))
        <div class="alert alert-danger text-center">{{ session('error') }}</div>
    @endif
    <form action="{{ route('serviceprovider.schedule.store') }}" method="GET">

        <div class="container mt-5 mb-5 d-flex justify-content-center">
            <div class="card px-1 py-4">
                <div class="card-body">
                    <div class="card-body min-20 px-md-5" id="message_display">
                    </div>
                    <h2 class="card-title mb-3 text-center">Thêm Lịch trình</h2>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="input-group">
                                    <label class="form-control label-time" for="appt-time">Departure Time:</label>
                                    <input class="form-control" id="appt-time" type="time" name="departure_time">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="input-group"> <select name="departure_province_code" class="form-select "
                                        id="select_pro">
                                        <option data-code="null" class="input-group form-control" value="null">
                                            Departure Province </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="input-group">
                                    <label class="form-control label-time" for="appt-time">Arrival Time:</label>
                                    <input class="form-control" id="appt-time" type="time" name="arrival_time">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="input-group"> <select name="arrival_province_code" class="form-select "
                                        id="select_pro">
                                        <option data-code="null" class="input-group form-control" value="null">
                                            Arrival Province </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="input-group">
                                    <label class="form-control label-time" for="total-time">Total travel days:</label>
                                    <input class="form-control" id="total-time" min="0" max="20"
                                        type="number" name="total_days">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="position-relative d-flex container-station-input">
                        <input class="form-control search-station w-60" type="text" placeholder="Station">
                        <input class="form-control  w-60" id="chosen_station" type="text" name="station_id[]" hidden>
                        <div class="dropdown-container position-absolute">
                            <ul class="list-group list_suggested">
                            </ul>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#dc3545"
                            class="bi bi-x-lg icon-status unapproved mt-20  " viewBox="0 0 16 16">
                            <path
                                d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z" />
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="green"
                            class="bi bi-check-lg icon-status approved mt-20 d-none " viewBox="0 0 16 16">
                            <path
                                d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z" />
                        </svg>
                        <button type="button" class="btn btn-danger mt-20 btn-sm delete-station d-none">Delete</button>
                    </div>
                    <button type="button" class="btn btn-primary btn-sm mt-20 " id="add-station">Add Station</button>

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
    <script src="{{ asset('js/components/address.js') }}"></script>
    <script>
        const object = "Lịch trình";
        const urlStationAPI = '{{ route('stations') }}';
    </script>
    <script src="{{ asset('js/components/create_object.js') }}"></script>
    <script src="{{ asset('js/service_provider/schedule_create.js') }}"></script>
@endpush


@stop
