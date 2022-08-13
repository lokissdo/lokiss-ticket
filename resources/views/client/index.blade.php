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
            
            @include('components.search_trip')

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
                        <a href="#"></a>           

                    </div> 
                    <div class="popular-block hoverable">
                        <img height="100%"  class="popular-block-image "  src="https://futabus.vn/_nuxt/img/commonRoutes_2.e873b69.png" alt="">
                        <div class="popular-block-content">
                            <div class="popular-block-trip-header"> Sài Gòn ⇒ Đà Nẵng</div>
                            <div class="popular-block-trip-info">
                                 <div class="infor-distance">
                                    <img src="https://img.icons8.com/ios-filled/20/666666/marker.png"/>
                                    <span>200km</span>
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
                        <a href="#"></a>           
                        
                    </div>
                    <div class="popular-block hoverable">
                        <img height="100%"  class="popular-block-image "  src="https://futabus.vn/_nuxt/img/commonRoutes_1.9fcce6a.png" alt="">
                        <div class="popular-block-content">
                            <div class="popular-block-trip-header"> Sài Gòn ⇒ Đà Nẵng</div>
                            <div class="popular-block-trip-info">
                                 <div class="infor-distance">
                                    <img src="https://img.icons8.com/ios-filled/20/666666/marker.png"/>
                                    <span>267km</span>
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
                        <a href="#"></a>           
                        
                    </div>
                    <div class="popular-block hoverable">
                        <img height="100%"  class="popular-block-image "  src="https://futabus.vn/_nuxt/img/commonRoutes_5.a0fe8f2.png" alt="">
                        
                        <div class="popular-block-content">
                            <div class="popular-block-trip-header"> Sài Gòn ⇒ Đà Nẵng</div>
                            <div class="popular-block-trip-info">
                                 <div class="infor-distance">
                                    <img src="https://img.icons8.com/ios-filled/20/666666/marker.png"/>
                                    <span>360km</span>
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
                        <a href="#"></a>           
                    </div>
                    <div class="popular-block hoverable">
                        <img height="100%"  class="popular-block-image "  src="https://futabus.vn/_nuxt/img/commonRoutes_6.56a4691.png" alt="">
                        <div class="popular-block-content">
                            <div class="popular-block-trip-header"> Sài Gòn ⇒ Đà Nẵng</div>
                            <div class="popular-block-trip-info">
                                 <div class="infor-distance">
                                    <img src="https://img.icons8.com/ios-filled/20/666666/marker.png"/>
                                    <span>920km</span>
                                </div>
                                <div class="infor-duration">
                                    <img  src="https://img.icons8.com/ios-glyphs/20/666666/clock--v3.png"/>
                                    <span>8h</span>
                                </div>
                                <div class="infor-price">
                                    <img src="https://img.icons8.com/ios-filled/20/666666/ticket-confirmed.png"/>
                                <span>2000.000 đ</span>
                                </div>
                            </div>
                        </div> 
                        <a href="#"></a>           

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
                        <a href="#"></a>           
                    </div>
                </div>
            </div>


            {{-- news --}}
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
                            <img src="{{asset('img/uehbus.png')}}" alt="TỌA ĐÀM: Để xe buýt thực sự là một lựa chọn văn minh">
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
        @include('layout.footer_client') 
        </div>
    </div>
    @include('components.error') 

@endsection


@push('js')
<script type="text/javascript">
    const PopularSchedulesAPIUrl="{{route('popular_schedules')}}";
</script>
<script src="{{ asset('js/client/index.js') }}"></script>

    <script src="{{ asset('js/components/address.js') }}"></script>
@endpush
