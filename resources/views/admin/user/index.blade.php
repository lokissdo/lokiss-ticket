@extends('layout.master')
@section('content')
    @push('css')
        <link rel="stylesheet" href={{ asset('css/admin.css') }}>
        <link rel="stylesheet" href={{ asset('css/admin/index_user.css') }}>
    @endpush
@section('sidebar')
    @include('admin.sidebar', ['site' => 'user'])
@endsection
<div class="admin-page  d-flex flex-column w-100 mr-2 position-relative">

    <ul class="nav nav-tabs d-flex justify-content-between">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.index') }}" class="text-decoration-none">Home</a>
                </li>
                
                <li class="breadcrumb-item active">User</li>
            </ol>
        </nav>
        <div class="d-inline">
            <li class="nav-item">
                <a class="nav-link active"href={{ route('admin.user.index') }}>Xem</a>
            </li>
        </div>
    </ul>

    @if (session('error'))
        <div class="alert alert-danger text-center">{{ session('error') }}</div>
    @endif
    <div class="wrapper-loading position-absolute d-flex justify-content-center d-none">
        <div class="spinner-grow text-secondary align-self-center" style="width: 4rem; height: 4rem;"
            id="loading"role="status">
        </div>
    </div>

    <table class="table  mb-0 mr-auto bg-light border-1 align-self-stretch table-hover">

        <thead class="thead-dark">
            <tr>
                <th scope="col">
                    <div class="d-flex justify-content-between" data-sortcol='id'>
                        <div> STT</div>
                        @include('icons.sort')
                    </div>
                </th>
                <th scope="col">
                    <div class="d-flex justify-content-between position-relative" data-searchcol='name'>
                        <div>Tên</div>
                        <input type="search" name="" class="position-absolute invisible"
                            data-name="search-input">
                        @include('icons.search')
                    </div>

                </th>
                <th scope="col">
                    <div class="d-flex justify-content-between position-relative" data-searchcol='email'>
                        <div>Email</div>
                        <input type="search" name="" class="position-absolute invisible"
                            data-name="search-input">
                        @include('icons.search')
                    </div>
                </th>
                <th scope="col">Avatar</th>
                <th scope="col">
                    <div class="d-flex justify-content-between position-relative">
                        <div>Địa chỉ</div>
                        @include('icons.select', ['data_trigger' => 'select-address'])
                        <div class="position-absolute d-none" data-name="select-address">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="input-group"> <select name="address" class="form-select "
                                                id="select_pro">
                                                <option data-code="null" class="input-group form-control"
                                                    value="null"> Chọn tỉnh / thành phố</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <select name="address2" class="form-select " id="select_dis">
                                                <option data-code="null" class="input-group form-control"
                                                    value="null"> Chọn quận / huyện </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </th>
                <th scope="col">
                    <div class="d-flex justify-content-between" data-sortcol='created_at'>
                        <div> Ngày tạo</div>
                        @include('icons.sort')

                    </div>
                </th>
                <th scope="col">
                    <div class="d-flex justify-content-between position-relative">
                        <div>Vai trò</div>
                        @include('icons.select', ['data_trigger' => 'select-role'])
                        <div class="position-absolute d-none" data-name="select-role">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="input-group"> <select class="form-select " id="select_role">
                                                <option class="input-group form-control" value="null"> Tất cả</option>
                                                @foreach ($roles as $key => $value)
                                                    {
                                                    <option class="input-group form-control"
                                                        value="{{ $value }}"> {{ strtolower($key) }}</option>
                                                    }
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </th>
            </tr>
        </thead>
        <tbody id="data-table">
            @foreach ($users as $user)
                <tr>
                    <th scope="row">{{ $user['id'] }}</th>
                    <td>{{ $user['name'] }}</td>
                    <td>{{ $user['email'] }}</td>
                    <td>
                        <img src="{{ $user['avatar'] }}" alt="" width="32" height="32"
                            class="rounded-circle me-2">
                    </td>
                    <td>{{ $user['address_name'] }}</td>
                    <td>{{ $user['created_at'] }}</td>
                    <td>{{ $user['role_name'] }}</td>

                </tr>
            @endforeach

        </tbody>

    </table>

    <div class="count">Tổng cộng: {{ count($users) }}</div>
   @include('components.pagination',['total_page'=>$total_page])
</div>
@endsection
@push('js')
<script>
    const urlApi = '{{ route('admin.user.index') }}';
</script>
<script src="{{ asset('js/admin/index_user.js') }}"></script>
<script src="{{ asset('js/components/address2.js') }}"></script>
@endpush
