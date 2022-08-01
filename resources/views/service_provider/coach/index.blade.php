@php
$role= Session::get('user')['role'];
$isEmployer =$role == 'employer';
@endphp
@extends('layout.master')
@section('content')
    @push('css')
        <link rel="stylesheet" href={{ asset('css/admin.css') }}>
    @endpush
@section('sidebar')
    @include($role . '.sidebar', ['site' => 'coach'])
@endsection

<div class="admin-page  d-flex flex-column w-100 mr-2 ">

    <ul class="nav nav-tabs d-flex justify-content-between">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route("$role.index") }}" class="text-decoration-none">Home</a>
                </li>
                <li class="breadcrumb-item active">Coach</li>
            </ol>
        </nav>
        <div class="d-flex">
            <li class="nav-item">
                <a class="nav-link active"href={{ route('serviceprovider.coach.index') }}>Xem</a>
            </li>
            @if ($isEmployer)
                <li class="nav-item">
                    <a class="nav-link" href={{ route('employer.coach.create') }}>Thêm</a>
                </li>
            @endif
        </div>



    </ul>

    <h2 class="text-center"> @include('icons.company') Nhà xe
        <strong>{{ Session::get('user')['service_provider_name'] }}</strong></h2>
    @if (session('error'))
        <div class="alert alert-danger text-center">{{ session('error') }}</div>
    @endif
    <h3> @include('icons.coach') Danh sách các loại xe</h3>
    <table class="table mr-auto bg-light border-1 align-self-stretch table-hover">
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
            @foreach ($coaches as $coach)
                <tr>
                    <th scope="row">{{ $coach['id'] }}</th>
                    <td>{{ $coach['name'] }}</td>
                    <td>{{ $coach['type_name'] }}</td>
                    <td>{{ $coach['seat_number'] }}</td>

                    <td>
                        @if ($isEmployer)
                            <form id="delete_form" method="POST"
                                action={{ route('employer.coach.destroy', ['id' => $coach['id']]) }}>
                                @method('DELETE')
                                <button id="delete_coach" class="btn btn-danger btn-sm" type="submit">
                                    Xóa
                                </button>
                            </form>
                        @endif

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @include('layout.footer')

</div>
<script type="text/javascript">
    const deleteButtons = document.querySelectorAll("#delete_coach");
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
