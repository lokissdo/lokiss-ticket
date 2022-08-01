@extends('layout.master')
@section('content')
    @push('css')
        <link rel="stylesheet" href={{ asset('css/admin.css') }}>
    @endpush
@section('sidebar')
@include('employer.sidebar',['site'=>'employee'])

@endsection
<div class="admin-page  d-flex flex-column w-100 mr-2 ">
    <ul class="nav nav-tabs d-flex justify-content-end">
        <li class="nav-item">
            <a class="nav-link active"href={{ route('employer.employee.index') }}>Xem</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href={{ route('employer.employee.create') }}>Thêm</a>
        </li>
    </ul>
    <h2 class="text-center">@include('icons.company') Nhà xe <strong>{{ Session::get('user')['service_provider_name'] }}</strong></h2>
    @if (session('error'))
        <div class="alert alert-danger text-center">{{ session('error') }}</div>
    @endif
    <h2>@include('icons.employees') Danh sách nhân viên</h2>
    <table class="table   mb-0 mr-auto bg-light border-1 align-self-stretch table-hover ">
        <thead class="thead-dark">
            <tr>
                <th scope="col">STT</th>
                <th scope="col">Tên</th>
                <th scope="col">Email</th>
                <th scope="col">Địa chỉ</th>
                <th scope="col">Ngày bắt đầu</th>

                <th scope="col">###</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($employees as $employee)
                <tr>
                    <th scope="row">{{ $employee['id'] }}</th>
                    <td>{{ $employee['name'] }}</td>
                    <td>{{ $employee['email'] }}</td>
                    <td>{{ $employee['address_name'] }}</td>
                    <td>{{ $employee['created_at'] }}</td>


                    <td>
                        <form id="delete_form" method="POST"
                            action={{ route('employer.employee.destroy', ['id' => $employee['id']]) }}>
                            @method('DELETE')
                            <button id="delete_employee" class="btn btn-danger btn-sm" type="submit">
                                Xóa
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @include('layout.footer')

</div>
<script type="text/javascript">
    const deleteButtons = document.querySelectorAll("#delete_employee");
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
