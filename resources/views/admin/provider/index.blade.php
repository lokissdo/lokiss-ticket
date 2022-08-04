@extends('layout.master')
@section('content')
    @push('css')
        <link rel="stylesheet" href={{ asset('css/admin.css') }}>
    @endpush
@section('sidebar')
@include('admin.sidebar',['site' => 'provider'])

@endsection
<div class="admin-page  d-flex flex-column w-100 mr-2 ">

    <ul class="nav nav-tabs d-flex justify-content-between">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.index') }}" class="text-decoration-none">Home</a>
                </li>
                <li class="breadcrumb-item active">Service Provider</li>
            </ol>
        </nav>
        <div class="d-flex">
            <li class="nav-item">
                <a class="nav-link active"href={{ route('admin.provider.index') }}>Xem</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href={{ route('admin.provider.create') }}>Thêm</a>
            </li>
        </div>
        
    </ul>

    <table class="table  mb-0 mr-auto bg-light border-1 align-self-stretch table-hover">
        <thead class="thead-dark">
            <tr>
                <th scope="col">STT</th>
                <th scope="col">Tên</th>
                <th scope="col">Số điện thoại</th>
                <th scope="col">Đánh giá</th>
                <th scope="col">Địa chỉ</th>
                <th scope="col">###</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($providers as $provider)
                <tr>
                    <th scope="row">{{ $provider['id'] }}</th>
                    <td>{{ $provider['name'] }}</td>
                    <td>{{ $provider['phone_number'] }}</td>
                    <td>{{ $provider['rate'] }}</td>
                    <td>{{ $provider['address_name'] }}</td>

                    <td>
                        <div class="d-flex">
                            <a class="btn btn-primary btn-sm"
                                href={{ route('admin.provider.edit', ['id' => $provider['id']]) }} role="button">Sửa</a>
                            <form id="delete_form" method="POST"
                                action={{ route('admin.provider.destroy', ['id' => $provider['id']]) }}>
                                @method('DELETE')
                                <button id="delete_provider" class="btn btn-danger btn-sm" type="submit">
                                    Xóa
                                </button>
                            </form>
                        </div>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<script type="text/javascript">
    const deleteButtons = document.querySelectorAll("#delete_provider");
    deleteButtons.forEach(deleteButton => {
        deleteButton.onclick = (e) => {
            e.preventDefault();
            if (window.confirm('Bạn có chắc chắn muốn xóa nhà xe  này?')) {
                e.target.parentNode.submit();
            }
        }
    });
</script>
@endsection
