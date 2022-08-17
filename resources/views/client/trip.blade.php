@extends('layout.client')
@section('topbar')
    @include('layout/topbar')
@endsection
@push('css')
    <link rel="stylesheet" href="{{ asset('css/client/trip.css') }}">
@endpush
@section('content')
    <div class="content position-relative">
        <div class="container">
            <h2 class="mt-3">{{ $departure_province }}-{{ $arrival_province }}</h2>
            <h4>{{ date('d/m/Y', strtotime($departure_date)) }}</h4>
            <div class="step-line-container">
                <div class="step-line">
                    <div class="step-circles">
                        <div class="step-item previous-step">
                            <div class="step-item-text ">1</div>
                            <div class="step-item-title step-active-title"><span id="step-id-1">CHỌN TUYẾN</span>
                            </div>
                        </div>
                        <div class=" step-item current-step">
                            <div class="step-item-text">2</div>
                            <div class=" step-item-title step-active-title"><span id="step-id-2">XÁC NHẬN LỘ
                                    TRÌNH</span></div>
                        </div>
                        <div class="step-item   ">
                            <div class="step-item-text">3</div>
                            <div class="step-item-title step-next-title"><span id="step-id-3">THÔNG TIN HÀNH
                                    KHÁCH</span></div>
                        </div>
                        <div class="step-item ">
                            <div class="step-item-text">4</div>
                            <div class="step-item-title step-next-title"><span id="step-id-4">THANH TOÁN</span></div>
                        </div>
                    </div>
                    <div class="line">
                        <div class="current-line"></div>
                        <div class="next-line"></div>
                        <div class="next-line"></div>
                    </div>
                </div>
            </div>

            @include('components.search_trip', [
                'departure_province_code' => $departure_province_code,
                'arrival_province_code' => $arrival_province_code,
                'departure_date' => $departure_date,
            ])
            @if (count($trips) == 0)
                <h3 class="text-center">Không có chuyến đi nào</h3>
            @else
                <div class="filter-sort-and-trips cont-item">
                    <div class="sort-container">
                        <div class="sort-container-title">
                            Sắp xếp theo:
                        </div>
                        <div data-col='departure_time' data-sort='asc' class="sort-item chosen">Giờ đi sớm nhất</div>
                        <div data-col='departure_time' data-sort='desc' class="sort-item">Giờ đi muộn nhất</div>
                        <div data-col='price' data-sort='asc'class="sort-item">Giá tăng dần</div>
                        <div data-col='price' data-sort='desc'class="sort-item">Giá giảm dần</div>
                    </div>
                    <div class="filter-container">
                        <select id='select_coach' class="form-select filter-select">
                            <option value="" selected="selected">Loại xe</option>

                        </select>
                        <select id='select_rate' class="form-select filter-select">
                            <option value="" selected="selected">Đánh giá</option>
                            <option value="2">2* trở lên</option>
                            <option value="3">3* trở lên</option>
                            <option value="4">4* trở lên</option>
                        </select>
                    </div>
                </div>
            @endif
            <div class="routes-container cont-item ">
                @foreach ($trips as $trip)
                    @php
                        $sp = $trip['service_provider'];
                        $schedule = $trip['schedule'];
                        $detail = $scheduleDetails[$trip['schedule_id']];
                        $coach = $trip['coach'];
                    @endphp

                    <div class=" route-option " data-schedule_id='{{ $trip['schedule_id'] }}'
                        data-trip_container='{{ $trip['id'] }}'>
                        <div class="header-serviceprovider d-flex justify-content-between">
                            <div class="route-infor-provicer d-flex">
                                <div class="route-infor-provicer-text">
                                    {{ $trip['service_provider']['name'] . '  ' }}
                                </div>
                                <div class="bus-rating">
                                    <i aria-label="icon: star" class="anticon anticon-star">
                                        <svg viewBox="64 64 896 896" focusable="false" class="" data-icon="star"
                                            width="1em" height="1em" fill="currentColor" aria-hidden="true">
                                            <path
                                                d="M908.1 353.1l-253.9-36.9L540.7 86.1c-3.1-6.3-8.2-11.4-14.5-14.5-15.8-7.8-35-1.3-42.9 14.5L369.8 316.2l-253.9 36.9c-7 1-13.4 4.3-18.3 9.3a32.05 32.05 0 0 0 .6 45.3l183.7 179.1-43.4 252.9a31.95 31.95 0 0 0 46.4 33.7L512 754l227.1 119.4c6.2 3.3 13.4 4.4 20.3 3.2 17.4-3 29.1-19.5 26.1-36.9l-43.4-252.9 183.7-179.1c5-4.9 8.3-11.3 9.3-18.3 2.7-17.5-9.5-33.7-27-36.3z">
                                            </path>
                                        </svg>
                                    </i>

                                    <span>{{ (round($sp['ratings_avg_rate'], 2) ?? '0') . ' (' . $sp['ratings_count'] . ')' }}</span>
                                </div>
                            </div>
                            <div class="route-price">{{ number_format($trip['price']) . ' VND' }}</div>
                        </div>

                        <div class="route-line-container">
                            <div class="route-image">
                                <img alt="water utilitie" src="{{ asset('storage/img/' . $coach['photo']) }}" width="150px"
                                    height="150px">
                            </div>

                            <div class="route-line-list d-flex">
                                <div class="route-line-left">
                                    <div class="label">
                                        {{ number_format($trip['price']) . 'đ' }} <span class="dot"></span>
                                        {{ $coach['name'] }} <span class="dot"></span>
                                        <span>{{ $coach['seat_number'] }}
                                            chỗ</span>
                                    </div>

                                    <div class="route-time">
                                        {{ date('H:i', strtotime($schedule['departure_time'])) }}
                                        <img alt="fromto" width="28" height="7"
                                            src="{{ asset('img/fromto.png') }}">
                                        {{ date('H:i', strtotime($schedule['departure_time'] . ' + ' . $schedule['duration'] . ' minutes')) }}

                                    </div>
                                    <div class="route-line bold"><img alt="pickup-bold"
                                            src="{{ asset('img/departure.png') }}" width="16" height="16">
                                        {{ $detail[0]['name'] }}
                                        <div>
                                            Xe tuyến: 347km -
                                            {{ $schedule['hour_duration'] }}
                                        </div>
                                    </div>
                                    <div class="route-line bold route-des"><img alt="destination-bold"
                                            src="{{ asset('img/destination.png') }}" width="16" height="19">
                                        {{ end($detail)['name'] }}
                                        <!---->
                                    </div>
                                </div>
                                <div class="hoverable detail-trip-button" data-target='{{ $trip['id'] }}'> <span>Thông
                                        tin
                                        chi tiết <i aria-label="icon: caret-down" class="anticon anticon-caret-down"><svg
                                                viewBox="0 0 1024 1024" class="" data-icon="caret-down"
                                                width="1em" height="1em" fill="currentColor" aria-hidden="true"
                                                focusable="false">
                                                <path
                                                    d="M840.4 300H183.6c-19.7 0-30.7 20.8-18.5 35l328.4 380.8c9.4 10.9 27.5 10.9 37 0L858.9 335c12.2-14.2 1.2-35-18.5-35z">
                                                </path>
                                            </svg></i></span> </div>
                                <div class="route-line-right ">
                                    <div class="utilities"><img alt="water utilitie" src="{{ asset('img/bottle.png') }}"
                                            width="16" height="16"> <img alt="tissue utilitie"
                                            src="{{ asset('img/tissue.png') }}" width="16" height="16"> <img
                                            alt="form utilitie" src="{{ asset('img/wifi.png') }}" width="16"
                                            height="16">
                                    </div>
                                    <div> <strong>Còn {{ $coach['seat_number'] - $trip['tickets_count'] }} chỗ</strong>
                                    </div>
                                    <div class="action d-flex">

                                        <div class="choose hoverable" data-target={{ $trip['id'] }}>
                                            <img alt="checkbox" src="{{ asset('img/checkbox.png') }}" width="30"
                                                height="30">
                                            <!---->
                                            <div class="choose-trip ">
                                                Chọn
                                            </div>
                                        </div>
                                    </div>

                                </div>


                            </div>

                        </div>
                        <div class="open-box position-relative d-none" data-trip='{{ $trip['id'] }}'>
                            <div class="time-line-container">
                                <div class="title-container">
                                    <p class="title">LỊCH TRÌNH CHUYẾN ĐI</p>
                                </div>
                                <div class="alert alert-info noinfo" style="display: none;">
                                    <p style="text-align: center;">Không tìm thấy thông tin chuyến</p>
                                </div>
                                <!---->
                            </div>
                            <div class="seat-map-container ">
                                <div class="seat-map-wrap">
                                    <div class="floor-title">
                                        <div>Tầng dưới</div>
                                        <div>Tầng trên</div>
                                    </div>
                                    <div class="seat-tables">
                                        <div class="seat-table-container" data-rendered="0"
                                            data-seat_number="{{ $coach['seat_number'] }}"
                                            data-api="{{ route('seats', $trip['id']) }}"
                                            data-name="seat-{{ $trip['id'] }}">
                                        </div>

                                    </div>
                                    <div class="seat-statuses">
                                        <div class="status-item d-flex">
                                            <div class="active icon"></div>
                                            <div class="status-text">Trống</div>
                                        </div>
                                        <div class="status-item d-flex">
                                            <div class="select icon"></div>
                                            <div class="status-text">Đang chọn</div>
                                        </div>
                                        <div class="status-item d-flex">
                                            <div class="disable icon"></div>
                                            <div class="status-text">Đã đặt</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="transaction-footer">
                                <div>
                                    <div class="count">
                                        0 vé:
                                    </div>
                                    <div>
                                        Tổng tiền:
                                        <span class="total">
                                            0đ
                                        </span>
                                    </div>
                                </div>
                                <button class="next-button">
                                    Tiếp tục
                                    <img width="24" height="24" alt="next"
                                        src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAAAXNSR0IArs4c6QAAAERlWElmTU0AKgAAAAgAAYdpAAQAAAABAAAAGgAAAAAAA6ABAAMAAAABAAEAAKACAAQAAAABAAAAMKADAAQAAAABAAAAMAAAAADbN2wMAAABFklEQVRoBe2W3Q2DMAyESTeggTG6REdknw7RskZ3SM8VD1aUPEAgxOgsuaUoP3ef3ShdxyABEiABEiABEjBMIITQI6clvTkri3B8/eODz7GmidvOmz2w3qu2iSIPEOuRQl5H9UqUmhigniaKKO4xGVW4bCVmmKt6OhUVJFMJmiiiumXylSrxhhkdJtspZcLO3Qn45YiNTUxbWlPP2fsupNeOnx1exPuFeFCTv0F+RErf65Bq3JsUrEVBZE78oMc1+ZwRL5c+M+JTN1SKP7TdlrYh+UMppxaXPybSLHnT4r1Z8tJKED8hdUgbVTsq47tJqr3XvJsx+Omc+66ZdOpY0O6RUgVJO9fjU6lxcxIgARIgARK4CoEf/uti7K0v/UAAAAAASUVORK5CYII="></button>
                            </div>
                            @include('components.loading', ['name' => 'seat-' . $trip['id']])

                        </div>
                        <div class="open-box d-none" data-tripinfor='{{ $trip['id'] }}'>
                            <div class="infor-container position-relative">
                                <div class="infor-title">
                                    <div data-trip='{{ $trip['id'] }}' class="infor-title-item ">Hình ảnh</div>
                                    <div data-trip='{{ $trip['id'] }}' class="infor-title-item selected"
                                        data-target='{{ 'station' . $trip['id'] }}'>Hành trình di chuyển</div>
                                    <div data-trip='{{ $trip['id'] }}' class="infor-title-item">Tiện ích</div>
                                    <div data-trip='{{ $trip['id'] }}' class="infor-title-item">Chính sách</div>
                                    <div data-trip='{{ $trip['id'] }}' class="infor-title-item"
                                        data-target="{{ 'rate' . $trip['id'] }}"
                                        data-api='{{ route('comments', $sp['id']) }}' data-name="rate"
                                        data-rendered='0'>
                                        Đánh
                                        giá</div>

                                </div>
                                <div class="close-infor position-absolute hoverable" data-target="{{ $trip['id'] }}">
                                    <img width="20px"src="https://storage.googleapis.com/vxrd/iconCloseInfo.svg">
                                </div>
                                <div class="tripinfor-item stations " data-name='{{ 'station' . $trip['id'] }}'>
                                    <div class="schedule-detail">
                                        <div class="content-warning-text">Lưu ý</div>
                                        <div>Các mốc thời gian di chuyển bên dưới là thời gian dự kiến.
                                            Lịch này có thể thay đổi tùy tình hình thưc tế. </div>
                                        <div class="title">Các bến sẽ qua:</div>

                                        <div class="station-content">
                                            @php
                                                $first = 1;
                                            @endphp
                                            @foreach ($scheduleDetails[$trip['schedule_id']] as $detail)
                                                @if ($first == 0)
                                                    <div class="arrow-icon">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                            height="16" fill="blue" class="bi bi-arrow-right"
                                                            viewBox="0 0 16 16">
                                                            <path fill-rule="evenodd"
                                                                d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z" />
                                                        </svg>
                                                    </div>
                                                @endif
                                                @php
                                                    if ($first == 1) {
                                                        $first = 0;
                                                    }
                                                @endphp

                                                <div class="station-content-item">
                                                    <img
                                                        src="https://img.icons8.com/fluency-systems-regular/20/000000/bus-stop.png" />
                                                    {{ $detail['name'] }}
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                </div>
                                <div class="tripinfor-item rates position-relative d-none "
                                    data-name="{{ 'rate' . $trip['id'] }}">
                                    <div class="rate-header d-flex ">
                                        <div class="rate-avg">
                                            <i aria-label="icon: star" class="anticon anticon-star">
                                                <svg viewBox="64 64 896 896" focusable="false" class=""
                                                    data-icon="star" width="1.2em" height="1.2em" fill="currentColor"
                                                    aria-hidden="true">
                                                    <path
                                                        d="M908.1 353.1l-253.9-36.9L540.7 86.1c-3.1-6.3-8.2-11.4-14.5-14.5-15.8-7.8-35-1.3-42.9 14.5L369.8 316.2l-253.9 36.9c-7 1-13.4 4.3-18.3 9.3a32.05 32.05 0 0 0 .6 45.3l183.7 179.1-43.4 252.9a31.95 31.95 0 0 0 46.4 33.7L512 754l227.1 119.4c6.2 3.3 13.4 4.4 20.3 3.2 17.4-3 29.1-19.5 26.1-36.9l-43.4-252.9 183.7-179.1c5-4.9 8.3-11.3 9.3-18.3 2.7-17.5-9.5-33.7-27-36.3z">
                                                    </path>
                                                </svg>
                                            </i>

                                            <span>{{ round($sp['ratings_avg_rate'], 2) ?? '0' }}</span>
                                        </div>
                                        <div class="star-show">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= $sp['ratings_avg_rate'])
                                                    <img src="https://img.icons8.com/emoji/30/000000/star-emoji.png" />
                                                @else
                                                    <img src="https://img.icons8.com/ios-glyphs/30/CCCCCC/star--v1.png" />
                                                @endif
                                            @endfor

                                        </div>
                                        <div>{{ $sp['ratings_count'] }} lượt đánh giá</div>
                                    </div>
                                    <div class="rate-comments">

                                    </div>
                                    @include('components.loading', ['name' => 'rate' . $trip['id']])
                                </div>
                            </div>

                        </div>

                    </div>
                @endforeach


            </div>
            <div class="route-option choose-locations d-none">
            </div>

            <div class="fill-information d-none">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="info-container">
                                <p class="title">THÔNG TIN HÀNH KHÁCH</p>
                                <form id="form-steps" name="form" autocomplete="off" method="post">
                                    <div class="form-outline mb-3">
                                        <label class="form-label" for="f1">*Họ và tên </label>
                                        <input id="f1" class="form-control"  pattern="\D+" name='name' value="{{session('user')['name']??''}}" required/>
                                    </div>
                                    <div class="form-outline mb-3">
                                        <label class="form-label" for="f2">*Email </label>
                                        <input type="email" id="f2" pattern="\w+@\w+.\w+" class="form-control" name='email' value="{{session('user')['email']??''}}"
                                        required  />
                                    </div>
                                    <div class="form-outline mb-3">
                                        <label class="form-label" for="f3">*SDT </label>
                                        <input id="f3" class="form-control" pattern="0[1-9][0-9]{8}" name='phone_number' value="{{session('user')['phone_number']??''}}"
                                        required   />
                                    </div>
                                   
                                    <div class="form-group d-flex ">
                                        <div style="margin-right: 10px;">
                                            <label for="select_pro"> Tỉnh / thành </label>
                                            <select required name="province_ticketinfor" class="hoverable" id="select_pro">
                                                <option data-code="null" value="null"> Chọn tỉnh / thành </option>
                                            </select>
                                        </div>
                                        <div >
                                            <label for="select_dis"> Quận / huyện </label>
                                            <select required name="district_ticketinfor" class="hoverable" id="select_dis">
                                                <option data-code="null" value="null"> Chọn quận / huyện </option>
                                            </select>
                                        </div>
                                    </div>
                            </form>
                            <div class="terms-and-policies"><input type="checkbox" id="terms-policies-checkbox"
                                    class="terms-policies-checkbox"> <label for="terms-policies-checkbox"
                                    class="terms-label"><span class="term-text">
                                        Chấp nhận
                                        <span href="" class="link">điều khoản đặt
                                            vé</span>
                                        của {{env('APP_NAME')}}
                                    </span></label></div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="notes-container">
                            <p class="title">ĐIỀU KHOẢN &amp; LƯU Ý</p>
                            <p class="txt">
                                (*) Quý khách vui lòng mang email có chứa mã vé đến văn phòng để đổi vé lên xe trước giờ
                                xuất bến ít nhất
                                <span class="high-light">60 phút</span>
                                để chúng tôi trung chuyển.
                            </p>
                            <p class="txt">(*) Thông tin hành khách phải chính xác, nếu không sẽ
                                không thể lên xe hoặc hủy/đổi vé.</p>
                            <p class="txt">
                                (*) Quý khách không được đổi/trả vé vào các ngày Lễ Tết (ngày thường quý khách được
                                quyền chuyển đổi hoặc hủy vé
                                <span class="high-light">một lần</span>
                                duy nhất trước giờ xe chạy 24 giờ), phí hủy vé 10%.
                            </p>
                            <p class="txt">
                                (*) Nếu quý khách có nhu cầu trung chuyển, vui lòng liên hệ số điện thoại
                                <a href="tel:1900 6067" class="high-light">1900 6067</a>
                                trước khi đặt vé. Chúng tôi không đón/trung chuyển tại những điểm xe trung chuyển không
                                thể tới được.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="navigations">
                    <button class="back"><img
                        src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEgAAABICAYAAABV7bNHAAAAAXNSR0IArs4c6QAAAERlWElmTU0AKgAAAAgAAYdpAAQAAAABAAAAGgAAAAAAA6ABAAMAAAABAAEAAKACAAQAAAABAAAASKADAAQAAAABAAAASAAAAACQMUbvAAACSklEQVR4Ae3aT07CQBQGcKrAyh22cAiDngGix/BwHMOoW9eohygV1iRAqO/FEppaoJH58435utDpFN7M/CxD5zmtFg8KUIACFKAABShAAQpQgAIUoAAFKPCvBKKQRjMYDOLVavWofe52u5M0Tb9s9z8YoCRJbjebzVOe54miRFGUCtLQNtKl7b+AifiKs16vXyRWXIp3td1uZ8vl8q1UZ7x4YTyi4YAlnJ7h0I3CQQMdw5GPWKbzUKNRnvEiWKBjODLeebvdvrc9/6gr5CR9CqfT6YyzLHs/48Zo/FY4ICQcuDsIDQcKCBEHBggVBwIIGcc7EDqOV6AQcLwBhYKjQM4Xq3Ec38mqXBeedWurucuHQAU4dTh9UCxwnqVTQeAonjOgEHGcAYWK4wSo3+8nkib9lMbKyS5tWw+4OeenW/uf7X3RTkkygZpDrsWR+pGsyj/stGwmqot8UH6gq5F8Y7lo/0Dzzaqtd1CzfpL9m9V0p6d5Zn0mqrkGU2UdSLN+kv17kBHPa0YNj+Tsa17ulGHxn4nrGqhF8YA4rbnmtcoZkI4yRCSnQCEiOQcKDckLUEhI3oBCQfIKFAKSdyB0JAggZCQYIFQkKCBEJDggNCRIoBLSq5Tr8tfO1m6wQKeQig1UN7b3CFlPd+hA/3roHiBZ5Y/k/YtqDN3MudvxWr1m8hwaSAdaII2l+AvJJMShWPBA2nFBmmq+SD9Wu4FIWbcBT3bntn5Dz0HVQfvYSF7tA88pQAEKUIACFKAABShAAQpQgAIUoEDgAt/KjWWzclDJlgAAAABJRU5ErkJggg=="
                        alt="back" width="24" height="24" class="icon" >
                    Quay lại
                </button>
                <!---->
                <button class="next">
                    Tiếp tục
                    <img width="24" height="24" alt="next"
                        src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAAAXNSR0IArs4c6QAAAERlWElmTU0AKgAAAAgAAYdpAAQAAAABAAAAGgAAAAAAA6ABAAMAAAABAAEAAKACAAQAAAABAAAAMKADAAQAAAABAAAAMAAAAADbN2wMAAABFklEQVRoBe2W3Q2DMAyESTeggTG6REdknw7RskZ3SM8VD1aUPEAgxOgsuaUoP3ef3ShdxyABEiABEiABEjBMIITQI6clvTkri3B8/eODz7GmidvOmz2w3qu2iSIPEOuRQl5H9UqUmhigniaKKO4xGVW4bCVmmKt6OhUVJFMJmiiiumXylSrxhhkdJtspZcLO3Qn45YiNTUxbWlPP2fsupNeOnx1exPuFeFCTv0F+RErf65Bq3JsUrEVBZE78oMc1+ZwRL5c+M+JTN1SKP7TdlrYh+UMppxaXPybSLHnT4r1Z8tJKED8hdUgbVTsq47tJqr3XvJsx+Omc+66ZdOpY0O6RUgVJO9fjU6lxcxIgARIgARK4CoEf/uti7K0v/UAAAAAASUVORK5CYII="></button>
                </div>
                </div>
               
            
        </div>
        @include('layout.footer_client')

    </div>
    {{-- trips --}}

    @include('components.loading', ['name' => 'routes'])
    </div>
    @include('components.error')
@endsection


@push('js')
    <script type="text/javascript">
        const TripAPIURL = "{{ route('trips') }}";
        const urlCoachAPI = "{{ route('coaches_types') }}"
        const apiSeats = "{{ route('seats', '') }}"
        const apiComments = "{{ route('comments', '') }}"
        var scheduleDetails = JSON.parse(atob('{{ base64_encode(json_encode($scheduleDetails)) }}'));;
        const initData = {
            departure_province_code: {{ $departure_province_code }},
            arrival_province_code: {{ $arrival_province_code }},
            departure_date: "{{ $departure_date }}",
        }
        preAddressCode.push({{session('user')['address']??''}})
        const preAddress2Code="{{session('user')['address2']??""}}"
        const images = {
            selected: '{{ asset('img/selected.png') }}',
            unselected: '{{ asset('img/checkbox.png') }}'
        };
        const asset = "{{ asset('') }}";
    </script>
    <script src="{{ asset('js/client/trip/render.js') }}"></script>

    <script src="{{ asset('js/client/trip/index.js') }}"></script>
    <script src="{{ asset('js/components/address.js') }}"></script>
    <script src="{{ asset('js/client/trip/address_infor.js') }}"></script>
    <script src="{{ asset('js/client/trip/event_after_load.js') }}"></script>

@endpush
