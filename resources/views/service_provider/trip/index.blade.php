@extends('layout.master')
@section('content')
    @push('css')
        <link rel="stylesheet" href={{ asset('css/admin.css') }}>
    @endpush
@section('sidebar')
    @include(Session::get('user')['role'] . '.sidebar',['site'=>'trip'])
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

    <h2> Nhà xe <strong>{{ Session::get('user')['service_provider_name'] }}</strong></h2>
    @if (session('error'))
        <div class="alert alert-danger text-center">{{ session('error') }}</div>
    @endif
    <div>Danh sách chuyến đi</div>
    <table class="table border mb-0 mr-auto bg-light border-1 align-self-stretch">
        <thead class="thead-dark">
            <tr>
                <th scope="col">STT</th>
                <th scope="col">Tên</th>
                <th scope="col">Loại</th>
                <th scope="col">Số chỗ ngồi</th>
                <th scope="col">###</th>
            </tr>
        </thead>
        <tbody>
            {{-- @foreach ($tripes as $trip)
                <tr>
                    <th scope="row">{{ $trip['id'] }}</th>
                    <td>{{ $trip['name'] }}</td>
                    <td>{{ $trip['type_name'] }}</td>
                    <td>{{ $trip['seat_number'] }}</td>

                    <td>
                        @if ($isEmployer)
                            <form id="delete_form" method="POST"
                                action={{ route('employer.trip.destroy', ['id' => $trip['id']]) }}>
                                @method('DELETE')
                                <button id="delete_trip" class="btn btn-danger btn-sm" type="submit">
                                    Xóa
                                </button>
                            </form>
                        @endif

                    </td>
                </tr>
            @endforeach --}}
        </tbody>
    </table>
</div>
{{-- <script type="text/javascript">
    const deleteButtons = document.querySelectorAll("#delete_trip");
    deleteButtons.forEach(deleteButton => {
        deleteButton.onclick = (e) => {
            e.preventDefault();
            if (window.confirm('Bạn có chắc chắn muốn xóa nhân viên  này?')) {
                e.target.parentNode.submit();
            }
        }
    });
</script> --}}
@endsection
