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
    <div class="d-flex justify-content-between">
        <h3> @include('icons.coach') Danh sách các xe</h3>
        <a href="{{ route('serviceprovider.coach.export') }}" class="btn btn-success float-right  align-self-center"><svg
                xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                class="bi bi-download" viewBox="0 0 16 16">
                <path
                    d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                <path
                    d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z" />
            </svg>Tải file excel</a>
    </div>

    <table class="table mr-auto bg-light border-1 align-self-stretch table-hover">
        <thead class="thead-dark">
            <tr>
                <th scope="col">STT</th>
                <th scope="col">Tên</th>
                <th scope="col">Ảnh</th>
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
                    <td><img  height="100px" src="{{asset('storage/img/'.$coach['photo'] )}}" ></td>

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
            if (window.confirm('Bạn có chắc chắn muốn xóa xe này?')) {
                e.target.parentNode.submit();
            }
        }
    });
</script>
@endsection
