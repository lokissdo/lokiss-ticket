@php
$role = Session::get('user')['role'];
@endphp
@extends('layout.master')
@section('content')
    @push('css')
        <link rel="stylesheet" href={{ asset('css/admin.css') }}>
        <link rel="stylesheet" href={{ asset('css/service_provider/trip_index.css') }}>
    @endpush
@section('sidebar')
    @include($role . '.sidebar', ['site' => 'trip'])
@endsection
<div class="admin-page  d-flex flex-column w-100 mr-2 close-select ">

    <ul class="nav nav-tabs d-flex justify-content-between">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route("$role.index") }}" class="text-decoration-none">Home</a>
                </li>
                <li class="breadcrumb-item active">Trip</li>
            </ol>
        </nav>
        <div class="d-flex">
            <li class="nav-item">
                <a class="nav-link active"href={{ route('serviceprovider.trip.index') }}>Xem</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href={{ route('serviceprovider.schedule.index') }}>Thêm</a>
            </li>
        </div>
    </ul>
    <h2 class="text-center"> @include('icons.company') Nhà xe
        <strong>{{ Session::get('user')['service_provider_name'] }}</strong>
    </h2>
    <div class="wrapper-loading position-fixed d-flex justify-content-center d-none">
        <div class="spinner-grow text-secondary align-self-center" style="width: 4rem; height: 4rem;"
            id="loading"role="status">
        </div>
    </div>
    @if (session('error'))
        <div class="alert alert-danger text-center">{{ session('error') }}</div>
    @endif
    {{-- {{dd($trips)}} --}}
    <h3> @include('icons.trip')Danh sách chuyến đi</h3>
    <table class="table  mr-auto bg-light border-1 align-self-stretch table-hover">
        <thead class="thead-dark">
            <tr>
                <th scope="col">
                    <div class="d-flex justify-content-between" data-sortcol='id'>
                        <div> STT</div>
                        @include('icons.sort')
                    </div>
                </th>
                <th scope="col">
                    <div class="d-flex justify-content-between position-relative">
                        <div>Khởi hành</div>
                        @include('icons.select', ['data_trigger' => 'select-departure-address'])
                        <div class="position-absolute d-none select-dropdown" data-name="select-departure-address">
                            <div class="form-group">
                                <div class="input-group"> <select name="address" data-name="select-departure-code" class="form-select " id="select_pro">
                                        <option data-code="null" class="input-group form-control" value="null">
                                            Tất cả</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </th>
                <th scope="col">
                    <div class="d-flex justify-content-between position-relative">
                        <div>Ngày khởi hành</div>
                        @include('icons.calendar', ['data_trigger' => 'select-departure-date'])
                        <div class="position-absolute d-none select-dropdown" data-name="select-departure-date">
                            <input  class="form-control" type="date" name="departure_date">
                        </div>
                    </div>
                </th>
                <th scope="col">
                    <div class="d-flex justify-content-between position-relative">
                        <div>Đến</div>
                        @include('icons.select', ['data_trigger' => 'select-arrival-address'])
                        <div class="position-absolute d-none select-dropdown" data-name="select-arrival-address">

                            <div class="form-group">
                                <div class="input-group"> <select data-name="select-arrival-code" name="address" class="form-select " id="select_pro">
                                        <option data-code="null" class="input-group form-control" value="null"> Tất cả</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </th>
                <th scope="col">
                    <div class="d-flex justify-content-between" data-sortcol='duration'>
                        <div> Thời gian di chuyển</div>
                        @include('icons.sort')
                    </div>
                </th>
                <th scope="col">
                    <div class="d-flex justify-content-between position-relative">
                        <div>Xe</div>
                        @include('icons.select', ['data_trigger' => 'select-coach'])
                        <div class="position-absolute d-none select-dropdown" data-name="select-coach">
                            <div class="form-group">
                                <div class="input-group">
                                    <select class="form-select " id="select_coach">
                                        <option class="input-group form-control" value=""> Tất cả</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </th>
                <th scope="col">
                    <div class="d-flex justify-content-between" data-sortcol='price'>
                        <div> Giá</div>
                        @include('icons.sort')
                    </div>
                </th>
                <th scope="col">###</th>
            </tr>
        </thead>
        <tbody id="data-table">
            @foreach ($trips as $trip)
                <tr>
                    <th scope="row">{{ $trip['id'] }}</th>
                    <td>{{ $trip['schedule']['departure_province_name'] }}</td>
                    <td>{{ date('H:i',strtotime($trip['schedule']['departure_time'])). ' | ' . date('d-m-Y', strtotime($trip['departure_date'])) }}
                    </td>

                    <td>{{ $trip['schedule']['arrival_province_name'] }}</td>
                    <td>{{ $trip['schedule']['hour_duration']  }}
                    </td>
                    <td>{{ $trip['coach']['name'] . ' (' . $trip['coach']['seat_number'] . 'chỗ )' }}</td>
                    <td>{{ number_format($trip['price']) . ' VND' }}</td>


                    <td>
                        <div class="d-flex justify-content-around">
                            <form id="delete_form" method="POST"
                                action={{ route('serviceprovider.trip.destroy', ['id' => $trip['id']]) }}>
                                @method('DELETE')
                                <button id="delete_trip" class="btn btn-danger btn-sm" type="submit">
                                    Xóa
                                </button>
                            </form>
                            <a class="btn btn-primary btn-sm "
                                href="{{ route('serviceprovider.trip.show', ['id' => $trip['id']]) }}"
                                role="button">Xem chi tiết </a>
                        </div>

                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>
    <div class="count">Tổng cộng: {{count($trips)}}</div>
   @include('components.pagination',['total_page'=>$total_page])
    @include('layout.footer')

</div>
@endsection


@push('js')
<script>
    const urlCoachAPI = '{{ route('coaches') }}';
    const urlFilterAndSortAPI = '{{ route('serviceprovider.trip.index') }}';

</script>

<script src="{{ asset('js/components/address.js') }}"></script>
<script src="{{ asset('js/service_provider/trip_index.js') }}"></script>
@endpush
