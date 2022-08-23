@php
$role = Session::get('user')['role'];
@endphp
@extends('layout.master')
@section('content')
    @push('css')
        <link rel="stylesheet" href={{ asset('css/admin.css') }}>
        <link rel="stylesheet" href={{ asset('css/admin/show_scheDetail.css') }}>
    @endpush
@section('sidebar')
    @include($role . '.sidebar', ['site' => 'schedule'])
@endsection
<div class="admin-page  d-flex flex-column w-100 mr-2 ">

    <ul class="nav nav-tabs d-flex justify-content-between">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route("$role.index") }}" class="text-decoration-none">Home</a>
                </li>
                <li class="breadcrumb-item active">Schedule</li>
            </ol>
        </nav>
        <div class="d-flex">
            <li class="nav-item">
                <a class="nav-link active"href={{ route('serviceprovider.schedule.index') }}>Xem</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href={{ route('serviceprovider.schedule.create') }}>Thêm</a>
            </li>
        </div>

    </ul>
    <h2 class="text-center">@include('icons.company') Nhà xe
        <strong>{{ Session::get('user')['service_provider_name'] }}</strong></h2>
    <div class="d-flex justify-content-between">
        <h3> @include('icons.schedule') Danh sách lịch trình</h3>
        <a href="{{ route('serviceprovider.schedule.export') }}"class="btn btn-success float-right h-75"><svg
                xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                class="bi bi-download" viewBox="0 0 16 16">
                <path
                    d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                <path
                    d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z" />
            </svg>Tải file excel</a>
    </div>


    <table class="table  mr-auto bg-light border-1 align-self-stretch table-hover">
        <thead class="thead-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Giờ khởi hành</th>
                <th scope="col">Địa điểm khởi hành</th>
                <th scope="col">Thời gian di chuyển</th>
                <th scope="col">Địa điểm đến</th>
                <th scope="col">###</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($schedules as $schedule)
                <div class="modal" id="{{ $schedule['id'] }}">
                    <div class="modal-bg modal-exit"></div>
                    <div class="modal-container">
                        <a href="{{ route('serviceprovider.schedule.show', ['id' => $schedule['id']]) }}">
                            <h1>ID: {{ $schedule['id'] }}</h1>
                        </a>
                        @foreach ($schedule['schedule_detail'] as $key => $each)
                            @include('icons.station')

                            <span>{{ $each['name'] }}
                                ({{ $each['district_name'] . ', ' . $each['province_name'] }})
                            </span>
                            @if ($key != count($schedule['schedule_detail']) - 1)
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="blue"
                                    class="bi bi-arrow-right" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z" />
                                </svg>
                            @endif
                        @endforeach

                        <button class="modal-close modal-exit">X</button>
                    </div>
                </div>


                <tr>
                    <th scope="row">{{ $schedule['id'] }}</th>
                    <td>{{ $schedule['departure_time'] }}</td>
                    <td>{{ $schedule['departure_province_name'] }}</td>
                    <td>{{ $schedule['hour_duration'] }}</td>
                    <td>{{ $schedule['arrival_province_name'] }}</td>

                    <td>
                        <div class="d-flex justify-content-around">
                            <form id="delete_form" method="POST"
                                action={{ route('serviceprovider.schedule.destroy', ['id' => $schedule['id']]) }}>
                                @method('DELETE')
                                <button id="delete_schedule" class="btn btn-danger btn-sm" type="submit">
                                    Xóa
                                </button>
                            </form>
                            <button data-modal="{{ $schedule['id'] }}" class="btn btn-primary btn-sm">Chi tiết
                            </button>
                            <a class="btn btn-primary btn-sm "
                                href="{{ route('serviceprovider.trip.create', ['id' => $schedule['id']]) }}"
                                role="button">Tạo chuyến đi</a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @include('layout.footer')

</div>
<script type="text/javascript">
    const deleteButtons = document.querySelectorAll("#delete_schedule");
    deleteButtons.forEach(deleteButton => {
        deleteButton.onclick = (e) => {
            e.preventDefault();
            if (window.confirm('Bạn có chắc chắn muốn xóa nhân viên  này?')) {
                e.target.parentNode.submit();
            }
        }
    });
</script>
<script src="{{ asset('js/service_provider/show_scheDetail.js') }}"></script>
@endsection
