@extends('layout.client')
@section('topbar')
    @include('layout/topbar')
@endsection
@push('css')
    <link rel="stylesheet" href="{{ asset('css/client/index.css') }}">
@endpush
@section('content')
    <div class="position-relative">
        <img width="100%"
            height="400px"src="https://langgo.edu.vn/public/files/upload/default/images/bai-viet/ielts-grammar-phan-biet-travel-trip-journey-tour-voyage-excursion-expedition-passage.jpg"
            alt="">
        <div class="position-absolute" style="right: 0px; top:0">
            <img width="400px" src="{{ asset('img/logo-text.png') }}" walt="logo">
        </div>
    </div>

    <div class="content">
        <div class="container">
            @include('components.search_trip')

            @include('layout.footer_client')
        </div>
    </div>
    @include('components.error')
@endsection


@push('js')
    <script type="text/javascript">
        const PopularSchedulesAPIUrl = "{{ route('popular_schedules') }}";
    </script>
    <script src="{{ asset('js/client/index.js') }}"></script>
    <script src="{{ asset('js/components/address.js') }}"></script>
@endpush
