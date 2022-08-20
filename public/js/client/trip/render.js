const render = {
    comment: function (item) {
        let starHTML = '';
        for (let i = 1; i <= 5; i++) {
            if (i <= item.rate) starHTML += `<img src="https://img.icons8.com/emoji/15/000000/star-emoji.png" />`
            else starHTML += '<img src="https://img.icons8.com/ios-glyphs/15/CCCCCC/star--v1.png" />'
        }
        return `
        <div class="rate-comment-container">
        <div class="rate-comment-header">
        <img class="avatar" width="50px" height="50px"  src="${item.user.avatar}" alt="" srcset="">
        <div>
            <div class="name">${item.user.name} </div>
            <div class="star">
              ${starHTML}
            </div>
        </div>
        <div class="sold-ticket"><img src="https://img.icons8.com/office/16/000000/checked--v1.png"/> Đã mua vé</div>
        
    </div>
    <div class="rate-commemt-content">
        ${item.comment} 
    </div>
    </div>
        `
    },
    comments: function (commentsContainer, data) {
        let html = '';
        data.forEach(each => {
            html += render.comment(each);
        })
        commentsContainer.innerHTML = html;
    },
    seat: function (id, status) {
        return (
            `<td>
            <svg
                xmlns="http://www.w3.org/2000/svg" width="42"
                height="42" viewBox="0 0 42 42" class="seat ${status == 'active' ? 'active' : ''}"
                pos="7">
                <g fill="none" fill-rule="evenodd">
                    <g class="${status == 'disabled' ? 'disabled-seat' : status}">
                        <path
                            d="M8.625.5c-3.038 0-5.5 2.462-5.5 5.5v27.875c0 .828.672 1.5 1.5 1.5h32.75c.828 0 1.5-.672 1.5-1.5V6c0-3.038-2.462-5.5-5.5-5.5H8.625zM5.75 35.5V38c0 1.933 1.567 3.5 3.5 3.5h23.5c1.933 0 3.5-1.567 3.5-3.5v-2.5H5.75z">
                        </path>
                        <rect width="5.125"
                            height="16.5" x=".5" y="13.625"
                            rx="2.563"></rect>
                        <rect width="5.125"
                            height="16.5" x="36.375" y="13.625"
                            rx="2.563"></rect>
                    </g>
                </g> <text>
                    <tspan x="50%" y="50%"
                        dominant-baseline="middle" text-anchor="middle"
                        class="${status}">
                        ${id}
                    </tspan>
                </text>
            </svg>
        </td>`)
    },
    loading: function (name) {
        return `
<div class="wrapper-loading position-absolute d-flex justify-content-center d-none" data-name="loading${name ?? ''}">
    <div class="spinner-grow text-secondary align-self-center" style="width: 2rem; height: 2rem;"
        id="loading"role="status">
    </div>
</div>
<style>
    .wrapper-loading{
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    z-index: 999;
    background-color: rgba(225, 225, 225, 0.353);
}
#loading{
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
}
</style>`
    },
    seatsMap: function (seatsMapContainer, data) {
        const occupiedSeatsKeys = [];
        data.forEach(e => { occupiedSeatsKeys[e.seat_position] = '1' })
        const seatNumber = Number(seatsMapContainer.dataset.seat_number);
        const leftTableNumSeat = Math.ceil(Math.ceil(seatNumber / 3) / 2);
        let tr = '', leftTable = '', rightTable = '';
        let row = 1, i;
        console.log(seatNumber)
        for (i = 1; i <= seatNumber; i++) {
            if (occupiedSeatsKeys[i])
                tr += render.seat(i, 'disabled');
            else tr += render.seat(i, 'active');
            if (i % 3 === 0) {
                if (row <= leftTableNumSeat) leftTable += `<tr> ${tr}</tr> `;
                else rightTable += `<tr> ${tr}</tr> `;
                tr = '';
                row++;
            }
        }
        if ((i - 1) % 3 !== 0)
            rightTable += `<tr> ${tr}</tr> `;
        seatsMapContainer.innerHTML = `<table class=" seat-table">
                                                 <tbody>
                                                     ${leftTable}
                                                 </tbody>
                                        </table>
                                        <table class=" seat-table">
                                            <tbody>
                                                ${rightTable}
                                            </tbody>
                                        </table>`
    },
    coaches: function (coaches) {
        let html = '';
        for (const property in coaches) {
            html += ` <option class="input-group form-control"
           value="${coaches[property]}"> ${helper.Capitalize(property.toLowerCase())}</option>`;
        }
        return html;
    },
    trip: function (sp, schedule, detail, coach, trip, scheduleDetails) {

        return `
        <div class=" route-option "  data-schedule_id='${trip['schedule_id']}' data-trip_container='${trip['id']}'>
                    <div class="header-serviceprovider d-flex justify-content-between">
                        <div class="route-infor-provicer d-flex">
                            <div class="route-infor-provicer-text">
                                ${trip['service_provider']['name'] + ' '}
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

                                <span>${(helper.round(sp['ratings_avg_rate'], 2) ?? '0') + ' (' + sp['ratings_count'] + ')'}</span>
                            </div>
                        </div>
                        <div class="route-price">${helper.number_format(trip['price']) + ' VND'}</div>
                    </div>

                    <div class="route-line-container">
                        <div class="route-image">
                            <img alt="water utilitie" src="${helper.asset('storage/img/' + coach['photo'])}" width="150px"
                                height="150px">
                        </div>

                        <div class="route-line-list d-flex">
                            <div class="route-line-left">
                                <div class="label">
                                    ${helper.number_format(trip['price']) + 'đ'} <span class="dot"></span>
                                    ${coach['name']} <span class="dot"></span> <span>${coach['seat_number']}
                                        chỗ</span>
                                </div>

                                <div class="route-time">
                               <span data-name='departure-time'>  ${helper.formatHi(schedule['departure_time'])} </span>
                                    <img alt="fromto" width="28" height="7" src="${helper.asset('img/fromto.png')}">
                                    ${helper.formatHiaddMinutes(schedule['departure_time'], schedule['duration'])}

                                </div>
                                <div class="route-line bold"><img alt="pickup-bold" src="${helper.asset('img/departure.png')}"
                                        width="16" height="16">
                                    ${detail[0]['name']}
                                    <div>
                                        Xe tuyến: 347km -
                                        ${schedule['hour_duration']}
                                    </div>
                                </div>
                                <div class="route-line bold route-des"><img alt="destination-bold"
                                        src="${helper.asset('img/destination.png')}" width="16" height="19">
                                    ${detail.at(-1)['name']}
                                    <!---->
                                </div>
                            </div>
                            <div class="hoverable detail-trip-button" data-target='${trip['id']}'> <span>Thông tin
                                    chi tiết <i aria-label="icon: caret-down" class="anticon anticon-caret-down"><svg
                                            viewBox="0 0 1024 1024" class="" data-icon="caret-down" width="1em"
                                            height="1em" fill="currentColor" aria-hidden="true" focusable="false">
                                            <path
                                                d="M840.4 300H183.6c-19.7 0-30.7 20.8-18.5 35l328.4 380.8c9.4 10.9 27.5 10.9 37 0L858.9 335c12.2-14.2 1.2-35-18.5-35z">
                                            </path>
                                        </svg></i></span> </div>
                            <div class="route-line-right ">
                                <div class="utilities"><img alt="water utilitie" src="${helper.asset('img/bottle.png')}"
                                        width="16" height="16"> <img alt="tissue utilitie"
                                        src="${helper.asset('img/tissue.png')}" width="16" height="16"> <img
                                        alt="form utilitie" src="${helper.asset('img/wifi.png')}" width="16"
                                        height="16">
                                </div>
                                <div> <strong>Còn ${Number(coach['seat_number']) - Number(trip['tickets_count'])} chỗ</strong></div>
                                <div class="action d-flex">

                                    <div class="choose hoverable" data-target="${trip['id']}">
                                        <img alt="checkbox" src="${helper.asset('img/checkbox.png')}" width="30"
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
                    <div class="open-box position-relative d-none" data-trip='${trip['id']}'>
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
                                        data-seat_number="${coach['seat_number']}"
                                        data-api="${helper.APIseats(trip['id'])}"
                                        data-name="seat-${trip['id']}">
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
                        ${render.loading('seat-' + trip['id'])}

                    </div>
                    <div class="open-box d-none" data-tripinfor='${trip['id']}'>
                        <div class="infor-container position-relative">
                            <div class="infor-title">
                                <div data-trip='${trip['id']}' class="infor-title-item ">Hình ảnh</div>
                                <div data-trip='${trip['id']}' class="infor-title-item selected"
                                    data-target='${'station' + trip['id']}'>Hành trình di chuyển</div>
                                <div data-trip='${trip['id']}' class="infor-title-item">Tiện ích</div>
                                <div data-trip='${trip['id']}' class="infor-title-item">Chính sách</div>
                                <div data-trip='${trip['id']}' class="infor-title-item"
                                    data-target="${'rate' + trip['id']}"
                                    data-api='${helper.APIcomments(sp['id'])}' data-name="rate" data-rendered='0'>
                                    Đánh
                                    giá</div>

                            </div>
                            <div class="close-infor position-absolute hoverable" data-target="${trip['id']}">
                                <img width="20px"src="https://storage.googleapis.com/vxrd/iconCloseInfo.svg">
                            </div>
                            <div class="tripinfor-item stations " data-name='${'station' + trip['id']}'>
                                <div class="schedule-detail">
                                    <div class="content-warning-text">Lưu ý</div>
                                    <div>Các mốc thời gian di chuyển bên dưới là thời gian dự kiến.
                                        Lịch này có thể thay đổi tùy tình hình thưc tế. </div>
                                    <div class="title">Các bến sẽ qua:</div>

                                    <div class="station-content">
                                        ${render.scheduleDetail(scheduleDetails[trip['schedule_id']])}
                                    </div>
                                </div>

                            </div>
                            <div class="tripinfor-item rates position-relative d-none "
                                data-name="${'rate' + trip['id']}">
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

                                        <span>${helper.round(sp['ratings_avg_rate'], 2) ?? '0'}</span>
                                    </div>
                                    <div class="star-show">
                                      ${render.ratings(sp)}
                                    </div>
                                    <div>${sp['ratings_count']} lượt đánh giá</div>
                                </div>
                                <div class="rate-comments">

                                </div>
                                ${render.loading('rate' + trip['id'])} 
                            </div>
                        </div>

                    </div>
                </div>
        `
    },
    trips: function (data) {
        let html = '';
        data.trips.forEach(trip => {
            sp = trip['service_provider'];
            schedule = trip['schedule'];
            detail = data['scheduleDetails'][trip['schedule_id']];
            coach = trip['coach'];
            html += render.trip(sp, schedule, detail, coach, trip, data.scheduleDetails)
        })
        return html;
    },
    scheduleDetail: function (data) {
        let html = '';
        data.forEach((detail, index) => {
            if (index != 0)
                html += `
                <div class="arrow-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                        fill="blue" class="bi bi-arrow-right" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z" />
                    </svg>
                </div>`;

            html += `
            <div class="station-content-item">
                <img
                    src="https://img.icons8.com/fluency-systems-regular/20/000000/bus-stop.png" />
                ${detail['name']}
            </div>
        `
        })
        return html;
    },
    ratings: function (sp) {
        let html = '';
        for (let $i = 1; $i <= 5; $i++)
            if ($i <= sp['ratings_avg_rate'])
                html += ' <img src="https://img.icons8.com/emoji/30/000000/star-emoji.png" />'
            else
                html += ' <img src="https://img.icons8.com/ios-glyphs/30/CCCCCC/star--v1.png" />'
        return html;
    },
    departure: function (id) {
        let html = '';
        let details = scheduleDetails[Number(id)];
        for (let i = 0; i < details.length - 1; ++i) {
            const e = details[i];
            let label = e.name + '( ' + e.district_name + ', ' + e.province_name + ')';
            html += ` <div class="form-check">
            <input class="form-check-input" type="radio" name="departure" value="${e.id}" id="departure${e.id}">
            <label class="form-check-label" for="departure${e.id}">
            <img src="https://img.icons8.com/ios-filled/15/000000/marker.png" /> <span data-name='departure${e.id}'> ${label} </span>
            </label>
        </div>`
        }
        return html;
    },
    arrival: function (id) {
        let html = '';
        let details = scheduleDetails[Number(id)];
        for (let i = 1; i < details.length; ++i) {
            const e = details[i];
            let label = e.name + '( ' + e.district_name + ', ' + e.province_name + ')';
            html += ` <div class="form-check">
            <input class="form-check-input" type="radio" name="arrival" value="${e.id}" id="arrival${e.id}">
            <label class="form-check-label" for="arrival${e.id}">
            <img src="https://img.icons8.com/ios-filled/15/000000/marker.png" /> <span data-name='arrival${e.id}'> ${label} </span>
            </label>
        </div>`
        }
        return html;

    },
    choose_locations: function (target) {
        const tS = target.querySelector.bind(target);
        const infor = tS('.route-line-left');
        const price = tS('.transaction-footer .count ');
        let html = `  
        <h4>XÁC NHẬN LỘ TRÌNH DI CHUYỂN</h4>
        <div class="slogan"> An tâm được đón đúng nơi, trả đúng chỗ đã chọn và dễ dàng thay đổi khi cần.</div>
        ${infor.outerHTML}
        <h5 class="ticket_number d-flex">
            <img src="https://img.icons8.com/ios-filled/20/A69406/ticket-confirmed.png" />
            ${price.outerHTML}
        </h5>
        <div class="select-locations d-flex">
        <div class="select-departure ">
            <div class="title">Điểm đón</div>
            ${render.departure(target.dataset.schedule_id)}
        </div>
        <div class="divider"></div>
        <div class="select-arrival">
            <div class="title">Điểm trả</div>
            ${render.arrival(target.dataset.schedule_id)}
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
        `
        return html;
    },
    assignDataPaymentPage: function ({ ticket, trip }) {
        $('[data-name=payment-name]').textContent = formInfor['name'].value;
        $('[data-name=payment-phone]').textContent = formInfor['phone_number'].value;
        $('[data-name=payment-email]').textContent = formInfor['email'].value;
        $('[data-name=payment-provider_name]').textContent = trip.serviceProvider;
        $('[data-name=payment-departure_time]').textContent = trip.departure_time+' '+trip.departure_date;
        $$('[data-name=payment-trip_name]').forEach(e => e.textContent = trip.departure + '⇒' + trip.arrival)
        $('[data-name=payment-departure_station]').textContent = ticket.departure_station.name;
        $('[data-name=payment-arrival_station]').textContent = ticket.arrival_station.name;
        $('[data-name=payment-numticket]').textContent = ticket.seats.count;
        $('[data-name=payment-stringticket]').textContent = ticket.seats.str;
        $('[data-name=payment-total]').textContent = ticket.total_price;
    }

}