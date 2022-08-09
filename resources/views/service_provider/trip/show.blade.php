@php
$role = Session::get('user')['role'];
$seats = [];
foreach ($tickets as $ticket) {
    $seats[$ticket['seat_position']] = $ticket;
}
$seat_number = $trip['coach']['seat_number'];
@endphp
@extends('layout.master')
@section('content')
    @push('css')
        <link rel="stylesheet" href={{ asset('css/admin.css') }}>
        <link rel="stylesheet" href={{ asset('css/service_provider/show_trip.css') }}>
    @endpush
@section('sidebar')
    @include($role . '.sidebar', ['site' => 'trip'])
@endsection
<div class="admin-page  d-flex flex-column w-100 mr-2 ">

    <ul class="nav nav-tabs d-flex justify-content-between">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route("$role.index") }}" class="text-decoration-none">Home</a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('serviceprovider.trip.index') }}"
                        class="text-decoration-none">Trip</a>
                </li>
                <li class="breadcrumb-item active">Show</li>
            </ol>
        </nav>
        <div class="d-flex">
            <li class="nav-item">
                <a class="nav-link active"href={{ route('serviceprovider.trip.index') }}>Xem</a>
            </li>
            <li class="nav-item">

                <a class="nav-link "href={{ route('serviceprovider.schedule.index') }}>Thêm</a>
            </li>
        </div>

    </ul>
    <h2 class="text-center"> @include('icons.company') Nhà xe
        <strong>{{ Session::get('user')['service_provider_name'] }}</strong>
    </h2>
    <table class="table mr-auto bg-light border-1 align-self-stretch">
        <thead class="thead-dark">
            <tr>
                <th scope="col">STT</th>
                <th scope="col">Khởi hành</th>
                <th scope="col">Ngày Khởi hành</th>
                <th scope="col">Đến</th>
                <th scope="col">Thời gian di chuyển</th>
                <th scope="col">Xe</th>
                <th scope="col">Giá</th>
                <th scope="col">Doanh thu</th>

            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="row">{{ $trip['id'] }}</th>
                <td>{{ $trip['schedule']['departure_province_name'] }}</td>
                <td>{{ date('H:i',strtotime($trip['schedule']['departure_time'])) . ' | ' . date('d-m-Y', strtotime($trip['departure_date'])) }}
                </td>

                <td>{{ $trip['schedule']['arrival_province_name'] }}</td>
                <td>{{ $trip['schedule']['hour_duration']}}
                </td>
                <td>{{ $trip['coach']['name'] . ' (' . $seat_number . ' chỗ )' }}</td>
                <td>{{ number_format($trip['price']) . ' VND' }}</td>
                <td>{{ number_format(count($tickets) * $trip['price']) . ' VND' }}</td>

            </tr>
        </tbody>
    </table>
    <div class="straight-line"></div>
    <h3> @include('icons.schedule')Lịch trình di chuyển</h3>
    <div>
        @foreach ($schedule['schedule_detail'] as $key => $each)
            @include('icons.station')
            <strong>{{ $each['name'] }}
                ({{ $each['district_name'] . ', ' . $each['province_name'] }})
            </strong>
            @if ($key != count($schedule['schedule_detail']) - 1)
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="blue"
                    class="bi bi-arrow-right" viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z" />
                </svg>
            @endif
        @endforeach
    </div>
    <div class="straight-line"></div>
    <div>
        <h3>Xe</h3>
        <img height="100px" src="{{ asset('storage/img/' . $trip['coach']['photo']) }}"alt="Xe khách">
    </div>

    <div class="straight-line"></div>
    <h3> Chỗ trống: {{ $seat_number - count($tickets) }}</h3>
    <div class="btn-group-toggle ">
        <label class="btn btn-primary active">
            <input type="checkbox" id="show-seat-detail" autocomplete="off"> Xem các vị trí trong xe
        </label>
    </div>

    <div class="d-flex flex-wrap seat-detail d-none">
        @for ($i = 1; $i <= $seat_number; ++$i)
            @if (empty($seats[$i]))
                <div class="seat " id="seat-{{ $i }}">
                    @include('icons.seat_bus', ['isActive' => 1])
                    <div class="text-center"> Mã : {{ $i }}</div>
                </div>
            @else
                <div class="seat hoverable position-relative" id="seat-{{ $i }}">
                    @include('icons.seat_bus', ['isActive' => 0])
                    <div class="text-center"> Mã : {{ $i }}</div>
                    <div class=" position-absolute ticket-detail">
                        <div class="d-flex infor-ticket">
                            <img src="{{ $seats[$i]['user']['avatar'] }}" alt="" width="32" height="32"
                                class="rounded-circle me-2">
                            <strong>{{ $seats[$i]['user']['name'] }}</strong>
                        </div>
                        <div class="d-flex infor-ticket">
                            Email: {{ $seats[$i]['user']['email'] }}
                        </div>
                        <div class="d-flex infor-ticket">
                            SDT: {{ $seats[$i]['user']['phone_number'] }}
                        </div>
                        <div class=" infor-ticket">
                            <div> Đi từ
                                :{{ $seats[$i]['arrival_station']['name'] . '(' . $seats[$i]['arrival_station']['district_name'] . ',' . $seats[$i]['arrival_station']['province_name'] . ')' }}
                            </div>
                            <div> Đến
                                :{{ $seats[$i]['departure_station']['name'] . '(' . $seats[$i]['departure_station']['district_name'] . ',' . $seats[$i]['departure_station']['province_name'] . ')' }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endfor
    </div>
    <div class="straight-line"></div>

    <div class="btn-group-toggle ">
        <label class="btn btn-primary active">
            <input type="checkbox" id="show-station-detail" autocomplete="off"> Xem các bến đón trả khách
        </label>
    </div>
    @php
        $ticketsByStation = [];
        foreach ($tickets as $ticket) {
            $ticketsByStation[$ticket['departure_station']['name']][] = $ticket;
        }
    @endphp

    <table class="table station-detail mr-auto bg-light border-1 align-self-stretch d-none">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Bến</th>
                <th scope="col">Hàng khách</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($schedule['schedule_detail'] as $station)
                <tr>
                    <th scope="row">{{ $station['name'] }}</th>



                    <td>
                        @php
                            if (empty($ticketsByStation[$station['name']])) {
                                continue;
                            }
                        @endphp
                        @foreach ($ticketsByStation[$station['name']] as $ticket)
                            <div class="btn btn-primary user position-relative">
                                {{ $ticket['user']['name'] }}

                                <div class=" position-absolute ticket-detail">
                                    <div class="d-flex infor-ticket">
                                        <img src="{{ $ticket['user']['avatar'] }}" alt="" width="32"
                                            height="32" class="rounded-circle me-2">
                                        <strong>{{ $ticket['user']['name'] }}</strong>
                                    </div>
                                    <div class=" infor-ticket">
                                        Email: {{ $ticket['user']['email'] }}
                                    </div>
                                    <div class=" infor-ticket">
                                        SDT: {{ $ticket['user']['phone_number'] }}
                                    </div>
                                    <div class=" infor-ticket">

                                        Đi từ
                                        :{{ $ticket['departure_station']['name'] . '(' . $ticket['departure_station']['district_name'] . ',' . $ticket['departure_station']['province_name'] . ')' }}
                                       
                                    </div>

                                    <div class=" infor-ticket">
                                        Đến
                                        :{{ $ticket['arrival_station']['name'] . '(' . $ticket['arrival_station']['district_name'] . ',' . $ticket['arrival_station']['province_name'] . ')' }}
                                    </div>
                                    <div class=" infor-ticket">
                                       Mã chỗ: {{$ticket['seat_position']}}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="straight-line"></div>
    @include('layout.footer')

</div>



<script src="{{ asset('js/service_provider/trip_show.js') }}"></script>

@endsection
