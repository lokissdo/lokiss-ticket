<div class="modal-message d-none">
    <div class="message-content">
        <h3 class="text-content" style="user-select: text">Chúc mừng bạn mua vé thành công!.</h3>
        <a href="{{route('passenger.index')}}">
            <h4>
            Về Trang Chủ 
        </h4>
        </a>

    </div>
</div>
<style>
    .modal-message{
        position: fixed;
        top: 0;
        bottom: 0;
        right: 0;
        left: 0;
        background-color: rgba(240, 240, 238, 0.267);
        z-index: 999;
        display: flex;
        justify-content: center;
        align-items: center
    }
    .message-content{
        background-image: linear-gradient( 109.6deg, rgb(188, 229, 248) 11.2%, rgb(138, 241, 149) 91.1% );
        border-radius: 20px;
        padding: 20px 30px;
        font-size: 15px;
    }
</style>