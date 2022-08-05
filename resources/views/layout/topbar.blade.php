<link rel="stylesheet" href="{{ asset('css/client/topbar.css') }}">
<div class="topbar d-flex flex-column">
    <div class="topbar_items topbar_items_first">
        <div class="topbar_first container d-flex justify-content-between">
            <div class="topbar_infor d-flex">
                <div class=" topbar_infor_item topbar_infor_sdt">
                    <img src="https://img.icons8.com/ios-filled/20/FFFFFF/phone.png"/>
                    19000000</div>
                <div class="topbar_infor_item topbar_infor_email">
                    <img src="https://img.icons8.com/ios-filled/20/FFFFFF/new-post.png"/>
                    hotro@ticket.com</div>
            </div>
            <div class="topbar_social d-flex ">

                <div class="topbar_social_item">
                    <a href="#" class="text-decoration-none">
                        <img src="https://img.icons8.com/color/30/000000/facebook-circled--v1.png" />
                    </a>
                </div>
                <div class="topbar_social_item">
                    <a href="#" class="text-decoration-none">
                        <img width="30px"src="{{ asset('img/github.png') }}" />
                    </a>
                </div>

                <div class="topbar_social_item align-middle">
                    <a class="btn btn-danger btn-sm root-color" href="{{route('login')}}" role="button">
                        <img
                            src="https://img.icons8.com/external-tanah-basah-glyph-tanah-basah/20/FFFFFF/external-user-user-tanah-basah-glyph-tanah-basah-4.png" />
                        Đăng nhập
                    </a>

                </div>
            </div>
        </div>
    </div>
    <div class="topbar_items">
        <div class="topbar_last container d-flex justify-content-between">
            <div class="topbar_last_item  topbar_last_item_img">
                <img src="{{ asset('img/logo.jpg') }}" walt="logo">
            </div>
            <div class="topbar_last_item">
                <a href="#" class="text-decoration-none text-reset">Trang chủ</a>
            </div>
            <div class="topbar_last_item">
                <a href="#" class="text-decoration-none text-reset">Lịch trình</a>
            </div>
            <div class="topbar_last_item">
                <a href="#" class="text-decoration-none text-reset">Tin tức</a>
            </div>
            <div class="topbar_last_item">
                <a href="#"class="text-decoration-none text-reset">Liên hệ</a>
            </div>
            <div class="topbar_last_item">
                <a href="#"class="text-decoration-none text-reset">Hóa đơn</a>
            </div>
            <div class="topbar_last_item">
                <a href="#"class="text-decoration-none text-reset">Về chúng tôi</a>
            </div>

        </div>
    </div>


</div>
