<link rel="stylesheet" href="{{ asset('css/client/topbar.css') }}">
<div class="topbar d-flex flex-column">
    <div class="topbar_items topbar_items_first">
        <div class="topbar_first container d-flex justify-content-between">
            <div class="topbar_infor d-flex">
                <div class=" topbar_infor_item topbar_infor_sdt">
                    <img src="https://img.icons8.com/ios-filled/20/FFFFFF/phone.png" />
                    19000000
                </div>
                <div class="topbar_infor_item topbar_infor_email">
                    <img src="https://img.icons8.com/ios-filled/20/FFFFFF/new-post.png" />
                    hotro@ticket.com
                </div>
            </div>
            <div class="topbar_social d-flex ">

                <div class="topbar_social_item">
                    <a href="#" class="text-decoration-none">
                        <img src="https://img.icons8.com/color/30/000000/facebook-circled--v1.png" />
                    </a>
                </div>
                <div class="topbar_social_item">
                    <a href="#" class="text-decoration-none ">
                        <img width="30px"src="{{ asset('img/github.png') }}" />
                    </a>
                </div>
                <div class="topbar_social_item align-middle">
                    @if (session()->has('user'))
                        <div class="dropdown">
                            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                              <img src="{{session('user')['avatar']??asset('img/user.png')}}" alt="avatar" width="32" height="32" class="rounded-circle me-2">
                              <strong>{{session('user')['name']}}</strong>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                              <li><a class="dropdown-item" href="#">Settings</a></li>
                              <li><a class="dropdown-item" href="#">Profile</a></li>
                              <li><hr class="dropdown-divider"></li>
                              <li><a class="dropdown-item" href="{{route('signOut')}}">
                                Sign out
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                                  <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"/>
                                  <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
                                </svg>
                              </a></li>
                            </ul>
                          </div>
                    @else
                    <a class="btn  btn-danger btn-sm root-color" href="{{ route('login') }}" role="button">
                        <img
                            src="https://img.icons8.com/external-tanah-basah-glyph-tanah-basah/20/FFFFFF/external-user-user-tanah-basah-glyph-tanah-basah-4.png" />
                        Đăng nhập
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="topbar_items">
        <div class="topbar_last container d-flex justify-content-between">
            <div class="topbar_last_item position-relative topbar_last_item_img ">
                <img src="{{ asset('img/logo.png') }}" alt="logo">
                <a href="{{route('passenger.index')}} " class="wrapper"></a>
            </div>
            <div class="topbar_last_item">
                <a href="{{route('passenger.index')}}" class="text-decoration-none  text-reset hover-color">Trang chủ</a>
            </div>
            <div class="topbar_last_item">
                <a href="{{route('trip')}}" class="text-decoration-none text-reset hover-color">Lịch trình</a>
            </div>
            <div class="topbar_last_item">
                <a href="#" class="text-decoration-none text-reset hover-color">Tin tức</a>
            </div>
            <div class="topbar_last_item">
                <a href="#"class="text-decoration-none text-reset hover-color">Liên hệ</a>
            </div>
            <div class="topbar_last_item">
                <a href="#"class="text-decoration-none text-reset hover-color">Hóa đơn</a>
            </div>
            <div class="topbar_last_item">
                <a href="#"class="text-decoration-none text-reset hover-color">Về chúng tôi</a>
            </div>

        </div>
    </div>


</div>
