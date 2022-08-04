@extends('layout.master')
@section('content')
    @push('css')
        <link rel="stylesheet" href={{ asset('css/admin/provider_create.css') }}>
    @endpush
@section('sidebar')
    @include('employer.sidebar', ['site' => 'employee'])
@endsection
<div class="admin-page  d-flex flex-column w-100 mr-2 ">
    <ul class="nav nav-tabs d-flex justify-content-between">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('employer.index') }}" class="text-decoration-none">Home</a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('employer.employee.index') }}"
                        class="text-decoration-none">Employee</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create</li>
            </ol>
        </nav>
        <div class="d-flex">
            <li class="nav-item">
                <a class="nav-link " id="show_list" href={{ route('employer.employee.index') }}>Xem</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href={{ route('employer.employee.create') }}>Thêm</a>
            </li>
        </div>

    </ul>
    @if (session('error'))
        <div class="alert alert-danger text-center">{{ session('error') }}</div>
    @endif
    <form action="{{ route('employer.employee.store') }}" method="GET">
        <input type="hidden" name="service_provider_id"value="{{ Session::get('user')['service_provider_id'] }}">
        <div class="container mt-5 mb-5 d-flex justify-content-center">
            <div class="card px-1 py-4">
                <div class="card-body">
                    <div class="card-body min-20 px-md-5" id="message_display">
                    </div>
                    <h2 class="card-title mb-3 text-center">Thêm Nhân Viên</h2>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="input-group"> <input class="form-control" name="email" type="text"
                                        placeholder="Email employer">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="input-group"> <select name="address" class="form-select " id="select_pro">
                                        <option data-code="null" class="input-group form-control" value="null"> Select
                                            city </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=" d-flex flex-column text-center px-5 mt-3 mb-3">
                        <small class="agree-text">By submitting this form you agree to the</small>
                        <a href="#" class="terms">Terms & Conditions</a>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block confirm-button w-100">Confirm</button>
                </div>
            </div>
        </div>
    </form>
    @include('layout.footer')

</div>
@push('js')
    <script src="{{ asset('js/components/address.js') }}"></script>
    <script>
        const object = "Nhân viên";
    </script>
    <script src="{{ asset('js/components/create_object.js') }}"></script>
@endpush


@stop
