<div class="booking-select-container position-relative">
    <div class="booking-oneway">
        Một chiều
    </div>
    <form id="search_trip" action="{{ route('trip') }}" method="GET">
        <div class="booking-select d-flex">

            <div class="booking-select-item  position-relative booking-select-item_des">
                <div class="booking-select-item-text" data-label='departure_province_code'>
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
                <div class="booking-select-item-text" data-label='arrival_province_code'>
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
                <div class="booking-select-item-text" data-label='departure_date'>
                    Ngày đi
                </div>
                <input class="form-control" min="{{ date('Y-m-d') }}" id="departure-date" type="date"
                    name="departure_date">
            </div>
        </div>

        <button type="submit" class="btn btn-danger search-trip btn-lg position-absolute">
            <img src="https://img.icons8.com/ios-filled/30/FFFFFF/search--v1.png" />
            Tìm chuyến xe
        </button>
    </form>
</div>
<style>
    .booking-header-content {
        text-transform: uppercase;
        margin: 30px 50px;
    }

    .content {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .booking-select-container {
        width: 100%;
        box-shadow: 4px 4px 20px 1px hsl(0deg 0% 55% / 40%);
        padding: 24px;
        margin-bottom: 40px;
        border-radius: 16px;
        padding-bottom: 40px;
    }

    .booking-oneway:before {
        content: "";
        border-radius: 100%;
        border: 1px solid var(--orange-color);
        display: inline-block;
        width: 20px;
        height: 20px;
        position: relative;
        margin: auto 6px auto auto;
        vertical-align: middle;
        cursor: pointer;
        bottom: 1px;
        background-color: var(--orange-color);
        text-align: center;
        box-shadow: inset 0 0 0 4px #fff;
    }

    .booking-oneway {
        height: 22px;
        vertical-align: bottom;
        font-weight: 700;
        margin-left: 10px;
    }

    .booking-select {
        padding: 10px;

    }

    .booking-select-item {
        width: 100%;
        position: relative;
        display: flex;
        flex-direction: column;
        border: 1px solid #dce1e6;
        border-radius: 6px;
        padding: 10px 16px;
        margin-right: 10px
    }

    .booking-select-item_des {
        margin-right: 15px;
    }

    .booking-select-item-text {
        font-size: 14px;
        color: #637280;
        font-weight: 700;
        text-align: center;
        margin-bottom: 5px;
    }

    #select_pro {
        font-size: 20px;
        color: #111;
        border: none;
        text-overflow: ellipsis;
        width: 100%;
        padding: 4px;
    }

    option:checked {
        text-align: center;
    }

    .exchange-icon {
        right: -27px;
        top: 20px;
        z-index: 999;
    }

    @media (max-width: 900px) {
        .booking-select {
            flex-wrap: wrap;
        }

        .exchange-icon {
            bottom: -20px;
            z-index: 999;
            top: unset;
            right: 50%;
            padding-left: 20px;
        }

    }

    .btn-danger:not(.root-color) {
        background-color: var(--orange-color);
    }

    .search-trip {
        bottom: -20px;
        right: 30px;
        box-shadow: 4px 4px 20px 1px hsl(0deg 0% 55% / 40%);
        text-transform: uppercase;
    }
</style>
<script src="{{ asset('js/components/search_trip.js') }}"></script>