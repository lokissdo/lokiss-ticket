@extends('layout.master')
@section('content')
    @push('css')
        <link rel="stylesheet" href={{ asset('css/admin.css') }}>
        <link rel="stylesheet" href={{ asset('css/admin/index_passenger.css') }}>
    @endpush
@section('sidebar')
    @include('admin.sidebar')
@endsection
<div class="admin-page  d-flex flex-column w-100 mr-2 ">

    <ul class="nav nav-tabs d-flex justify-content-end">
        <li class="nav-item">
            <a class="nav-link active"href={{ route('admin.passenger.index') }}>Xem</a>
        </li>
    </ul>

    @if (session('error'))
        <div class="alert alert-danger text-center">{{ session('error') }}</div>
    @endif
    <table class="table border mb-0 mr-auto bg-light border-1 align-self-stretch">
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
                    <div class="d-flex justify-content-between position-relative" >
                        <div>Địa chỉ</div>
                        @include('icons.select')
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
                <th scope="col">###</th>
            </tr>
        </thead>
        <tbody id="data-table">
            @foreach ($passengers as $passenger)
                <tr>
                    <th scope="row">{{ $passenger['id'] }}</th>
                    <td>{{ $passenger['name'] }}</td>
                    <td>{{ $passenger['email'] }}</td>
                    <td>
                        <img src="{{ $passenger['avatar'] }}" alt="" width="32" height="32"
                            class="rounded-circle me-2">
                    </td>
                    <td>{{ $passenger['address_name'] }}</td>
                    <td>{{ $passenger['created_at'] }}</td>
                </tr>
            @endforeach

        </tbody>

    </table>
    <ul class="pagination align-self-center">
        @for ($i = 1; $i <= $total_page; ++$i)
            <li class="page-item">
                <a class="page-link pointer" data-page="{{ $i }}">{{ $i }}</a>
            </li>
        @endfor

    </ul>

</div>
@endsection
@push('js')
<script>
    const urlApi = '{{ route('admin.passenger.index') }}';
</script>
<script src="{{ asset('js/admin/index_passenger.js') }}"></script>
<script src="{{ asset('js/components/address2.js') }}"></script>
@endpush
