@extends('layout.client')
@section('topbar')
    @include('layout/topbar', ['title' => 'ticket'])
@endsection
@push('css')
    <link rel="stylesheet" href="{{ asset('css/client/infor-ticket.css') }}">
    <link rel="stylesheet" href="{{ asset('css/client/ticket.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
@endpush
@section('content')
    <div class="position-relative">

        <div class="content">
            <div class="container">
                <h2 class="title-page">Những vé bạn đã mua</h2>
                <div class="infor-container d-flex">
                    <div class="account_wrap ">
                        <div class="header-account ">TÀI KHOẢN</div>
                        <div class="border_account"></div>
                        <div class="item_list  linked">
                            <div class="icon-infor">
                                <img src="https://img.icons8.com/ios-glyphs/20/000000/user--v1.png">
                            </div>
                            <div class=" item-text-account">Thông tin tài khoản
                            </div>
                            <a href="#"></a>
                        </div>
                        <div class="item_list linked chosen-page">
                            <div class="icon-infor">
                                <img src="https://img.icons8.com/ios-filled/20/000000/list.png">
                            </div>
                            <div class=" item-text-account">Vé đã đặt</div>
                            <a href="#"></a>
                        </div>
                        <div class="item_list linked">
                            <div class="icon-infor ">
                                <img
                                    src="https://img.icons8.com/external-dreamstale-lineal-dreamstale/20/000000/external-sign-out-interface-dreamstale-lineal-dreamstale.png">
                            </div>
                            <div class="linked item-text-account">Đăng xuất</div>

                            <a href="{{ route('signOut') }}"></a>
                        </div>
                    </div>
                    {{-- {{dd($tickets)}} --}}
                    <div style="flex:1">
                        @foreach ($tickets as $key => $ticket)
                            @php
                                $schedule = $ticket['trip']['schedule'];
                                $trip = $ticket['trip'];
                                $arrival_station = $ticket['arrival_station'];
                                $departure_station = $ticket['departure_station'];
                                $success_ticket = $ticket['deleted_at'] === null && strtotime($trip['departure_date'] . ' ' . $schedule['departure_time']) < time() ? true : false;
                            @endphp
                            {{-- {{dd($key)}} --}}
                            <div class="payment " data-name="{{ 'a' . $key }}" data-trip="{{ $trip['id'] }}">
                                <div id="ticket-infomation-container" class="buy-info-container">
                                    @if ($ticket['deleted_at'])
                                        <div class="title-bar-bg canceled d-flex ">
                                            <p class="title-txt ">TRẠNG THÁI: ĐÃ HỦY</p>
                                        </div>
                                    @elseif($success_ticket)
                                        <div class="title-bar-bg d-flex ">
                                            <p class="title-txt ">TRẠNG THÁI: ĐÃ KHỞI HÀNH</p>
                                        </div>
                                    @else
                                        <div class="title-bar-bg wait d-flex ">
                                            <p class="title-txt ">TRẠNG THÁI: CHỜ KHỞI HÀNH</p>
                                        </div>
                                    @endif


                                    <div>
                                        <div class="ticket-info-container">
                                            <div class="title-bar">
                                                <div class="title-txt">
                                                    <p>Thông tin chuyến: <span data-name='payment-trip_name'>
                                                            {{ $schedule['departure_province']['name'] . ' ⇒' . $schedule['arrival_province']['name'] }}
                                                        </span></p>
                                                </div>
                                            </div>
                                            <div class="container infor-ticket">
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 col-ms-12">
                                                        <div class="col-xs-12 field">
                                                            <div class="col-xs-4 sub-tit">Nhà xe:</div>
                                                            <div class="col-xs-8"><span
                                                                    data-name="payment-provider_name">{{ $trip['service_provider']['name'] }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 field">
                                                            <div class="col-xs-4 sub-tit">Tuyến xe:</div>
                                                            <div class="col-xs-8"><span
                                                                    data-name='payment-trip_name'>{{ $schedule['departure_province']['name'] . ' ⇒' . $schedule['arrival_province']['name'] }}
                                                                </span></div>
                                                        </div>
                                                        <div class="col-xs-12 field">
                                                            <div class="col-xs-4 sub-tit">Thời gian:</div>
                                                            <div class="col-xs-8"><span class="orange-value green"
                                                                    data-name='payment-departure_time'>
                                                                    {{ date('H:i', strtotime($schedule['departure_time'])) . ' ' . date('d/m/Y', strtotime($trip['departure_date'])) }}
                                                                </span></div>
                                                        </div>
                                                        <div class=" detail-ticket d-none col-xs-12 field">
                                                            <div class="col-xs-4 sub-tit">Điểm lên xe:</div>
                                                            <div class="col-xs-8">
                                                                <p data-name='payment-departure_station'>
                                                                    {{ $arrival_station['name'] . ' (' . $arrival_station['district']['name'] . ', ' . $arrival_station['province']['name'] . ')' }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 field detail-ticket d-none">
                                                            <div class="col-xs-4 sub-tit">Điểm xuống xe:</div>
                                                            <div class="col-xs-8">
                                                                <p data-name='payment-arrival_station'>
                                                                    {{ $departure_station['name'] . ' (' . $departure_station['district']['name'] . ', ' . $departure_station['province']['name'] . ')' }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 col-ms-12">
                                                        <div class="col-xs-12 field">
                                                            <div class="col-xs-4 sub-tit">Số lượng ghế : </div>
                                                            <div class="col-xs-8" data-name='payment-numticket'>
                                                                {{ count($ticket['seat_position']) }}</div>
                                                        </div>
                                                        <div class="col-xs-12 field">
                                                            <div class="col-xs-4 sub-tit">Số ghế: </div>
                                                            <div class="col-xs-8 orange-value green"><span
                                                                    data-name='payment-stringticket'>
                                                                    @foreach ($ticket['seat_position'] as $index => $each)
                                                                        @if ($index !== 0)
                                                                            ,
                                                                        @endif
                                                                        {{ $each }}
                                                                    @endforeach
                                                                </span></div>
                                                        </div>
                                                        <!---->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="footer-bar">
                                        <div class="action">
                                            <div class="see-detail">
                                                <button data-target="{{ 'a' . $key }}" data-name="see_detail"
                                                    type="button" class="btn btn-primary">Xem chi tiết</button>
                                                <button type="button" class="btn btn-danger">Hủy vé</button>
                                                @if ($success_ticket)
                                                    <button data-trip_id="{{ $trip['id'] }}"
                                                        data-target="{{ 'r' . $key }}" data-name="rate_button"
                                                        type="button" class="btn btn-warning">Đánh giá chuyến đi</button>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="total-info">
                                            <p class="footer-title">TỔNG TIỀN</p>
                                            <p class="footer-price">
                                                <span data-name='payment-total'>
                                                    {{ number_format($trip['price'] * count($ticket['seat_position']), 2) }}</span>
                                                <sup>₫</sup>
                                            </p>
                                        </div>
                                    </div>
                                    <div data-name="{{ 'r' . $key }}" data-rendered="0" class="d-none rate-wrapper position-relative">
                                        <div class="rating__container">
                                            <h4>Đánh giá chuyến đi</h4>

                                            <div class="rating-post d-none" data-key="{{$key}}">
                                                <div class="rating-text">Thanks for rating us!</div>
                                                <div class="rating-edit" data-key="{{$key}}">EDIT</div> 
                                            </div>
                                            <div class="star-widget" data-key="{{$key}}">
                                                <input class="rating-input rate-5"  type="radio" value="5" name="rate{{$key}}"
                                                    id="rate-5{{$key}}">
                                                <label for="rate-5{{$key}}" class="fas fa-star"></label>
                                                <input class="rating-input rate-4" type="radio" value="4" name="rate{{$key}}"
                                                    id="rate-4{{$key}}">
                                                <label for="rate-4{{$key}}" class="fas fa-star"></label>
                                                <input class="rating-input rate-3" type="radio" value="3" name="rate{{$key}}"
                                                    id="rate-3{{$key}}">
                                                <label for="rate-3{{$key}}" class="fas fa-star"></label>
                                                <input class="rating-input rate-2" type="radio" value="2" name="rate{{$key}}"
                                                    id="rate-2{{$key}}">
                                                <label for="rate-2{{$key}}" class="fas fa-star"></label>
                                                <input class="rating-input rate-1" type="radio" value="1" name="rate{{$key}}"
                                                    id="rate-1{{$key}}">
                                                <label for="rate-1{{$key}}" class="fas fa-star"></label>
                                                <form id="rating-form" action="{{route('create_rating')}}" method="POST">
                                                    @csrf
                                                    <header class="rating-header"></header>
                                                    <input value="{{$trip['id']}}" name="trip_id" hidden>
                                                    <div class="textarea">
                                                        <textarea cols="30" id="rate-comment" placeholder="Describe your experience....." maxlength="500"></textarea>
                                                    </div>
                                                    <div class="rating-btn" data-key="{{$key}}">
                                                        <button id="rating-btn"  type="submit">Post</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        @include('components.loading', ['name' => 'ratingr' . $key])
                                    </div>

                                    <!---->
                                </div>

                            </div>
                        @endforeach
                    </div>


                </div>

                @include('layout.footer_client')
            </div>
        </div>
        @include('components.error')
    @endsection


    @push('js')
        <script type="text/javascript">
            const getRatingsInforAPIURL = "{{ route('infor_ratings') }}";
        </script>
        <script src="{{ asset('js/client/ticket.js') }}"></script>
    @endpush
