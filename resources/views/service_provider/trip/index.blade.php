@extends('layout.master')
@section('content')
    @push('css')
        <link rel="stylesheet" href={{ asset('css/admin.css') }}>
    @endpush
@section('sidebar')
    @include(Session::get('user')['role'] . '.sidebar', ['site' => 'trip'])
@endsection
<div class="admin-page  d-flex flex-column w-100 mr-2 ">

    <ul class="nav nav-tabs d-flex justify-content-end">
        <li class="nav-item">
            <a class="nav-link active"href={{ route('serviceprovider.trip.index') }}>Xem</a>
        </li>
        <li class="nav-item">
            <a class="nav-link " href={{ route('serviceprovider.schedule.index') }}>Thêm</a>
        </li>

    </ul>
    <h2 class="text-center"> @include('icons.company') Nhà xe <strong>{{ Session::get('user')['service_provider_name'] }}</strong></h2>
    @if (session('error'))
        <div class="alert alert-danger text-center">{{ session('error') }}</div>
    @endif
    <div>Danh sách chuyến đi</div>
    <table class="table  mr-auto bg-light border-1 align-self-stretch table-hover">
        <thead class="thead-dark">
            <tr>
                <th scope="col">STT</th>
                <th scope="col">Khởi hành</th>
                <th scope="col">Ngày Khởi hành</th>
                <th scope="col">Đến</th>
                <th scope="col">Ngày Đến</th>
                <th scope="col">Xe</th>
                <th scope="col">Giá</th>
                <th scope="col">###</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($trips as $trip)
                <tr>
                    <th scope="row">{{ $trip['id'] }}</th>
                    <td>{{ $trip['schedule']['departure_province_name'] }}</td>
                    <td>{{ $trip['schedule']['departure_time_str'] . ' | ' . date('d-m-Y', strtotime($trip['departure_date'])) }}
                    </td>

                    <td>{{ $trip['schedule']['arrival_province_name'] }}</td>
                    <td>{{ $trip['schedule']['arrival_time_str'] . ' | ' . date('d-m-Y', strtotime($trip['arrival_date'])) }}
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
    @include('layout.footer')

</div>
<script type="text/javascript">
    const deleteButtons = document.querySelectorAll("#delete_trip");
    deleteButtons.forEach(deleteButton => {
        deleteButton.onclick = (e) => {
            e.preventDefault();
            if (window.confirm('Bạn có chắc chắn muốn xóa nhân viên  này?')) {
                e.target.parentNode.submit();
            }
        }
    });
</script>
@endsection
