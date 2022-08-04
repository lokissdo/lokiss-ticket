@extends('layout.master')
@section('content')
    @push('css')
        <link rel="stylesheet" href={{ asset('css/admin/provider_create.css') }}>
    @endpush
@section('sidebar')
    @include('employer.sidebar', ['site' => 'coach'])

@endsection
<div class="admin-page  d-flex flex-column w-100 mr-2 ">
    <ul class="nav nav-tabs d-flex justify-content-between">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('employer.index') }}" class="text-decoration-none">Home</a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('serviceprovider.coach.index') }}"
                        class="text-decoration-none">Coaches</a></li>
                <li class="breadcrumb-item active">Create</li>
            </ol>
        </nav>
        <div class="d-flex">
            <li class="nav-item">
                <a class="nav-link " id="show_list"href={{ route('serviceprovider.coach.index') }}>Xem</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href={{ route('employer.coach.create') }}>Thêm</a>
            </li>
        </div>

    </ul>

    <form action="{{ route('employer.coach.store') }}" method="POST" enctype='multipart/form-data'>
        @csrf
        @if ($errors->any())
            <div class="alert alert-danger text-center">
                <ul class=" list-unstyled">
                    @foreach ($errors->all() as $error)
                        <li > * {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="container mt-5 mb-5 d-flex justify-content-center">
            <div class="card px-1 py-4">
                <div class="card-body">
                    <div class="card-body min-20 px-md-5" id="message_display">
                    </div>
                    <h2 class="card-title mb-3 text-center">Thêm Xe Khách</h2>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <input class="form-control" name="name"type="text"
                                    value="{{ old('name') }}"placeholder="Name">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="image-file" style="flex:1" class="form-label form-control">Photo</label>
                                    <input class="form-control" name="photo" style="flex:3" type="file"
                                        accept="image/*" id="image-file">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="input-group"> <input class="form-control" value="{{ old('seat_number') }}" name="seat_number" type="number"
                                        min="10" max="50" placeholder="Seat Number">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="input-group"> <select name="type" class="form-select ">
                                        @foreach ($coach_types as $key => $val)
                                            <option class="input-group form-control" {{$val==old('type')?'selected':''}} value="{{ $val }}">
                                                {{ $key }} </option>
                                        @endforeach

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
@endpush


@stop
