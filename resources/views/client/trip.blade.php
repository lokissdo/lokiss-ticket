@extends('layout.client')
@section('topbar')
    @include('layout/topbar')
@endsection
@push('css')
    <link rel="stylesheet" href="{{ asset('css/client/trip.css') }}">
@endpush
@section('content')
    <div class="content">
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

            <div class="filter-sort-and-trips">
                <div class="sort-container">
                    <div class="sort-container-title">
                        Sắp xếp theo:
                    </div>
                    <div class="sort-item chosen">Giờ đi sớm nhất</div>
                    <div class="sort-item">Giờ đi muộn nhất</div>
                    <div class="sort-item">Giá tăng dần</div>
                    <div class="sort-item">Giá giảm dần</div>
                </div>
                <div class="filter-container">
                    <select class="form-select filter-select">
                        <option value="0" selected="selected">Loại xe</option>
                        <option value="402">Ghế</option>
                        <option value="403">Giường</option>
                        <option value="1454">Limousine</option>
                    </select>
                    <select class="form-select filter-select">
                        <option value="0" selected="selected">Giờ</option>
                        <option value="1">0h - 6h</option>
                        <option value="2">6h - 12h</option>
                        <option value="3">12h - 18h</option>
                        <option value="4">18h - 24h</option>
                    </select>
                    <select class="form-select filter-select">
                        <option value="0" selected="selected">Đánh giá</option>
                        <option value="2">2* trở lên</option>
                        <option value="3">3* trở lên</option>
                        <option value="4">4* trở lên</option>
                    </select>
                </div>
            </div>


            {{-- trips --}}
            @foreach ($trips as $trip)
            @php
                $s_id=$trip['service_provider']['id'];
                $schedule=$trip['schedule'];
                $detail=$scheduleDetails[$trip['schedule_id']];
                $coach=$trip['coach'];
            @endphp
            <div class="route-option">
                <div class="header-serviceprovider d-flex justify-content-between">
                    <div class="route-infor-provicer d-flex">
                        <div class="route-infor-provicer-text">
                          {{$trip['service_provider']['name']."  "}}
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
                            <span>{{round($ratings[$s_id]['rate'],2)}} ({{$ratings[$s_id]['count']}} )</span>
                        </div>
                    </div>
                    <div class="route-price">{{ number_format($trip['price']) . ' VND'}}</div>
                </div>

                <div class="route-line-container">
                    <div class="route-image">
                        <img alt="water utilitie" src="{{asset('storage/img/'.$coach['photo'] )}}" width="150px" height="150px">
                    </div>

                    <div class="route-line-list">

                        <div class="label">
                            {{ number_format($trip['price']) . 'đ'}} <span class="dot"></span>
                            {{$coach['name']}} <span class="dot"></span> <span>{{$coach['seat_number'] }} chỗ</span>
                        </div>
                        <div class="utilities"><img alt="water utilitie" src="{{ asset('img/bottle.png') }}" width="16"
                                height="16"> <img alt="tissue utilitie" src="{{ asset('img/tissue.png') }}"
                                width="16" height="16"> <img alt="form utilitie" src="{{ asset('img/wifi.png') }}"
                                width="16" height="16"></div>
                        <div class="route-time">
                            {{date('H:i',strtotime($schedule['departure_time']))}}
                            <img alt="fromto" width="28" height="7" src="{{ asset('img/fromto.png') }}">
                            {{date('H:i',strtotime($schedule['departure_time'].' + '.$schedule['duration'].' minutes'))}}

                        </div>
                        <div class="action"><img alt="checkbox" src="{{ asset('img/checkbox.png') }}" width="22"
                            height="22">
                        <!---->
                        <div class="">
                            Chọn
                        </div>
                    </div>
                        <div class="route-line bold"><img alt="pickup-bold" src="{{ asset('img/departure.png') }}"
                                width="16" height="16">
                                {{$detail[0]['name']}}
                            <div>
                                Xe tuyến: 347km -
                               {{$schedule['hour_duration']}}
                            </div>
                        </div>
                        <div class="route-line bold route-des"><img alt="destination-bold"
                                src="{{ asset('img/destination.png') }}" width="16" height="19">
                                {{end($detail)['name']}}
                            <!---->
                        </div>

                        
                    </div>

                </div>
                <!---->
                <!---->
            </div>
            @endforeach
       
            @include('layout.footer_client')
        </div>
    </div>
    @include('components.error')
@endsection


@push('js')
    <script type="text/javascript">
        const PopularSchedulesAPIUrl = "{{ route('popular_schedules') }}";
    </script>
    <script src="{{ asset('js/client/trip.js') }}"></script>
    <script src="{{ asset('js/components/address.js') }}"></script>
@endpush
