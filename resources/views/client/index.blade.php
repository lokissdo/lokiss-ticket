@extends('layout.client')
@section('topbar')
    @include('layout/topbar')
@endsection
@push('css')
    <link rel="stylesheet" href="{{ asset('css/client/index.css') }}">
@endpush
@section('content')
    <div class="content">
        <div class="container">
            <h2 class="booking-header-content ">Chọn tuyến</h2>
            <div class="booking-select-container position-relative">
                <div class="booking-oneway">
                    Một chiều
                </div>

                <div class="booking-select d-flex">

                    <div class="booking-select-item  position-relative booking-select-item_des">
                        <div class="booking-select-item-text">
                            Điểm đi
                        </div>
                            <div class="form-group">
                                <div class="input-group"> <select name="departure_province_code" class="form-select hoverable"
                                        id="select_pro">
                                        <option data-code="null" class="input-group form-control" value="null">
                                            Chọn Tỉnh/Thành Phố</option>
                                    </select>
                                </div>
                            </div>
                            <div class="exchange-icon position-absolute hoverable">
                                <img src="{{asset('img/exchange.png')}}" alt="">
                            </div>

                    </div>
                    <div class="booking-select-item">
                        <div class="booking-select-item-text">
                            Điểm đến
                        </div>
                        <div class="form-group">
                            <div class="input-group"> <select name="arrival_province_code" class="form-select hoverable"
                                    id="select_pro">
                                    <option data-code="null" class="input-group form-control" value="null">
                                        Chọn Tỉnh/Thành Phố</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="booking-select-item">

                        <div class="booking-select-item-text">
                            Ngày đi
                        </div>
                        <input class="form-control" min="{{date('Y-m-d')}}"  id="departure-date" type="date" name="departure_date">
                    </div>
                </div>
                <div class="btn btn-danger search-trip btn-lg position-absolute">
                    <img src="https://img.icons8.com/ios-filled/30/FFFFFF/search--v1.png"/>
                    Tìm chuyến xe
                     </div>
            </div>
        </div>

    </div>
@endsection


@push('js')
<script src="{{ asset('js/components/address.js') }}"></script>
    
@endpush