@extends('layout.master')
@section('content')
    @push('css')
        <link rel="stylesheet" href={{ asset('css/admin.css') }}>
    @endpush
@section('sidebar')
    @include('admin.sidebar')
@endsection
<div class="admin-page  d-flex flex-column w-100 mr-2 ">

    <ul class="nav nav-tabs d-flex justify-content-end">
        <li class="nav-item">
            <a class="nav-link active"href={{ route('admin.station.index') }}>Xem</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href={{ route('admin.station.create') }}>Thêm</a>
        </li>
    </ul>

    <table class="table border mb-0 mr-auto bg-light border-1 align-self-stretch">
        <thead class="thead-dark">
            <tr>
                <th scope="col">STT</th>
                <th scope="col">Tên</th>
                <th scope="col">Quận/Huyện</th>
                <th scope="col">Tỉnh/Thành phố</th>
                <th scope="col">###</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($stations as $station)
                <tr>
                    <th scope="row">{{ $station['id'] }}</th>
                    <td>{{ $station['name'] }}</td>
                    <td>{{ $station['district_name'] }}</td>
                    <td>{{ $station['province_name'] }}</td>

                    <td>
                        {{-- <div class="d-flex">
                            <a class="btn btn-primary btn-sm"
                                href={{ route('admin.provider.edit', ['id' => $provider['id']]) }} role="button">Sửa</a>
                            <form id="delete_form" method="POST"
                                action={{ route('admin.provider.destroy', ['id' => $provider['id']]) }}>
                                @method('DELETE')
                                <button id="delete_provider" class="btn btn-danger btn-sm" type="submit">
                                    Xóa
                                </button>
                            </form>
                        </div> --}}

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{-- <script type="text/javascript">
    const deleteButtons = document.querySelectorAll("#delete_provider");
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
