@extends('layout.client')
@section('topbar')
    @include('layout/topbar')
@endsection
@push('css')
    <link rel="stylesheet" href="{{ asset('css/client/index.css') }}">
@endpush
@section('content')
<div class="position-relative">
<img  width="100%" height="400px"src="https://langgo.edu.vn/public/files/upload/default/images/bai-viet/ielts-grammar-phan-biet-travel-trip-journey-tour-voyage-excursion-expedition-passage.jpg" alt="">
    <div class="position-absolute" style="right: 0px; top:0">
        <img width="400px" src="{{ asset('img/logo-text.png') }}" walt="logo">
    </div>
</div>

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
                            <img src="{{ asset('img/exchange.png') }}" alt="">
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
                        <input class="form-control" min="{{ date('Y-m-d') }}" id="departure-date" type="date"
                            name="departure_date">
                    </div>
                </div>
                <div class="btn btn-danger search-trip btn-lg position-absolute">
                    <img src="https://img.icons8.com/ios-filled/30/FFFFFF/search--v1.png" />
                    Tìm chuyến xe
                </div>
            </div>
            <div class="carousel-ctn">
                <img class="carousel-img "src="{{asset('img/terrace.png')}}" alt="carousel">
                <img class="carousel-img "src="{{asset('img/carou2.jpg')}}" alt="carousel">
                <img class="carousel-img "src="{{asset('img/carou3.jpg')}}" alt="carousel">
                <img class="carousel-img "src="{{asset('img/carou4.png')}}" alt="carousel">
                <img class="carousel-img "src="{{asset('img/carou5.jpg')}}" alt="carousel">
            </div>
            <div class="popular-route ">
                <h4>Tuyến phổ biến</h4>
                <div class="container popular-container d-flex flex-wrap justify-content-around">
                    <div class="popular-block hoverable">
                        <img class="popular-block-image " height="100%" src="https://futabus.vn/_nuxt/img/commonRoutes_3.e0f5b07.png" alt="">
                        <div class="popular-block-content">
                            <div class="popular-block-trip-header " >Sài Gòn ⇒ Đà Nẵng</div>
                            <div class="popular-block-trip-info">
                                <div class="infor-distance">
                                    <img src="https://img.icons8.com/ios-filled/20/666666/marker.png"/>
                                    <span>500km</span>
                                </div>
                                <div class="infor-duration">
                                    <img src="https://img.icons8.com/ios-glyphs/20/666666/clock--v3.png"/>
                                    <span>8h</span>
                                </div>
                                <div class="infor-price">
                                    <img src="https://img.icons8.com/ios-filled/20/666666/ticket-confirmed.png"/>
                                <span>2000.000 đ</span>
                                </div>


                            </div>
                        </div>
                    </div> 
                    <div class="popular-block hoverable">
                        <img height="100%"  class="popular-block-image "  src="https://futabus.vn/_nuxt/img/commonRoutes_2.e873b69.png" alt="">
                        <div class="popular-block-content">
                            <div class="popular-block-trip-header"> Sài Gòn ⇒ Đà Nẵng</div>
                            <div class="popular-block-trip-info">
                                 <div class="infor-distance">
                                    <img src="https://img.icons8.com/ios-filled/20/666666/marker.png"/>
                                    <span>500km</span>
                                </div>
                                <div class="infor-duration">
                                    <img src="https://img.icons8.com/ios-glyphs/20/666666/clock--v3.png"/>
                                    <span>8h</span>
                                </div>
                                <div class="infor-price">
                                    <img src="https://img.icons8.com/ios-filled/20/666666/ticket-confirmed.png"/>
                                <span>2000.000 đ</span>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="popular-block hoverable">
                        <img height="100%"  class="popular-block-image "  src="https://futabus.vn/_nuxt/img/commonRoutes_1.9fcce6a.png" alt="">
                        <div class="popular-block-content">
                            <div class="popular-block-trip-header"> Sài Gòn ⇒ Đà Nẵng</div>
                            <div class="popular-block-trip-info">
                                 <div class="infor-distance">
                                    <img src="https://img.icons8.com/ios-filled/20/666666/marker.png"/>
                                    <span>500km</span>
                                </div>
                                <div class="infor-duration">
                                    <img src="https://img.icons8.com/ios-glyphs/20/666666/clock--v3.png"/>
                                    <span>8h</span>
                                </div>
                                <div class="infor-price">
                                    <img src="https://img.icons8.com/ios-filled/20/666666/ticket-confirmed.png"/>
                                <span>2000.000 đ</span>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="popular-block hoverable">
                        <img height="100%"  class="popular-block-image "  src="https://futabus.vn/_nuxt/img/commonRoutes_5.a0fe8f2.png" alt="">
                        
                        <div class="popular-block-content">
                            <div class="popular-block-trip-header"> Sài Gòn ⇒ Đà Nẵng</div>
                            <div class="popular-block-trip-info">
                                 <div class="infor-distance">
                                    <img src="https://img.icons8.com/ios-filled/20/666666/marker.png"/>
                                    <span>500km</span>
                                </div>
                                <div class="infor-duration">
                                    <img src="https://img.icons8.com/ios-glyphs/20/666666/clock--v3.png"/>
                                    <span>8h</span>
                                </div>
                                <div class="infor-price">
                                    <img src="https://img.icons8.com/ios-filled/20/666666/ticket-confirmed.png"/>
                                <span>2000.000 đ</span>
                                </div>
                            </div>
                           
                        </div>
                        
                    </div>
                    <div class="popular-block hoverable">
                        <img height="100%"  class="popular-block-image "  src="https://futabus.vn/_nuxt/img/commonRoutes_6.56a4691.png" alt="">
                        <div class="popular-block-content">
                            <div class="popular-block-trip-header"> Sài Gòn ⇒ Đà Nẵng</div>
                            <div class="popular-block-trip-info">
                                 <div class="infor-distance">
                                    <img src="https://img.icons8.com/ios-filled/20/666666/marker.png"/>
                                    <span>500km</span>
                                </div>
                                <div class="infor-duration">
                                    <img src="https://img.icons8.com/ios-glyphs/20/666666/clock--v3.png"/>
                                    <span>8h</span>
                                </div>
                                <div class="infor-price">
                                    <img src="https://img.icons8.com/ios-filled/20/666666/ticket-confirmed.png"/>
                                <span>2000.000 đ</span>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="popular-block hoverable">
                        <img height="100%"  class="popular-block-image "  src="{{asset('img/carou5.jpg')}}" alt="">
                        <div class="popular-block-content">
                            <div class="popular-block-trip-header"> Sài Gòn ⇒ Đà Nẵng</div>
                            <div class="popular-block-trip-info">
                                 <div class="infor-distance">
                                    <img src="https://img.icons8.com/ios-filled/20/666666/marker.png"/>
                                    <span>500km</span>
                                </div>
                                <div class="infor-duration">
                                    <img src="https://img.icons8.com/ios-glyphs/20/666666/clock--v3.png"/>
                                    <span>8h</span>
                                </div>
                                <div class="infor-price">
                                    <img src="https://img.icons8.com/ios-filled/20/666666/ticket-confirmed.png"/>
                                <span>2000.000 đ</span>
                                </div>
                            </div>
                        </div>             
                    </div>
                </div>



            </div>
            <div class="news">
                <div class="news-img ">
                    <img width="100%" src="https://futabus.vn/_nuxt/img/bg-3.0d434f3.png" alt="">
                </div>
                <div class="news-container">
                    <h2>Tin tức cập nhật</h2>
                    <h4> Tin tức mới nhất về {{env('APP_NAME')}} và thông tin các chuyến xe  </h4>
                    <div class="news-slides d-flex justify-content-between">
                        <div class="news-slides-item hoverable">
                            <img src="https://photo-cms-sggp.zadn.vn/w1200/Uploaded/2022/aopaohv/2022_07_25/1_ejut.jpg" alt="TỌA ĐÀM: Để xe buýt thực sự là một lựa chọn văn minh">
                            <div class="news-slides-item-title">
                                <p >TỌA ĐÀM: Để xe buýt thực sự là một lựa chọn văn minh</p>
                            </div>
                            
                        </div>
                        <div class="news-slides-item hoverable">
                            <img src="data:image/jpeg;base64,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" alt="TỌA ĐÀM: Để xe buýt thực sự là một lựa chọn văn minh">
                            <div class="news-slides-item-title">
                                <p >Xe buýt điện đầu tiên của Việt Nam chính thức vận hành</p>
                            </div>
                        </div>
                        <div class="news-slides-item hoverable">
                            <img src="https://www.ueh.edu.vn/images/upload/editer/UEH%20trien%20khai%20Shuttel%20Bus%20-%20Copy.png" alt="UEH triển khai dịch vụ Shuttle Bus">
                            <div class="news-slides-item-title">
                                <p >UEH triển khai dịch vụ Shuttle Bus</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>

    </div>
@endsection


@push('js')
    <script src="{{ asset('js/components/address.js') }}"></script>
@endpush
