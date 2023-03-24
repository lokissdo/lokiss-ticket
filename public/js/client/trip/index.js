let detailButtons, chooseButtons, openBoxes,
    imgChooseCheckBoxes, routeOptions, closeInforButtons,
    tripInforButtons, activeSeats, nextStepButtons,
    chooseLocationsCont, fillInformationCont, paymentCont, transaction, seats = {}, formInfor;

const sortItemButtons = $$('.sort-item');
const filterItemSelects = $$('.filter-select')
const title = $('.title-page'), viewMoreButton=$('.load-more-trips');
const path = window.location.href.split('/').at(-1);
let dataSort = null;
let isFilter = 0, pageNum = 1,isPagination=false;
var arrival_id, departure_id;
const AssignEventInTrip = {
    assignVariables: function () {
        detailButtons = $$('.detail-trip-button');
        chooseButtons = $$('.choose[data-target]');
        openBoxes = $$('.open-box');
        imgChooseCheckBoxes = $$('.choose>img');
        routeOptions = $$('.route-option');
        closeInforButtons = $$('.close-infor');
        tripInforButtons = $$('.infor-title-item[data-target]');
        activeSeats = $$('svg>.active');
    },
    clickDetailButtons: function () {
        detailButtons.forEach(element => {
            element.onclick = () => {
                const targetedOpenBox = $(`.open-box[data-tripinfor='${element.dataset.target}']`);
                Handler.HideOtherBoxes(targetedOpenBox)
                Handler.UnSelectedRouteOption();
                targetedOpenBox.classList.toggle('d-none');
            }
        });
    },
    clickChooseButtons: function () {
        chooseButtons.forEach(element => {
            element.onclick = async () => {
                Handler.OpenSeatMapEffect(element);
                const seatTables = $(`[data-name="seat-${element.dataset.target}"`);
                if (seatTables.dataset.rendered === "0") {
                    const loading = $(`[data-name="loadingseat-${element.dataset.target}"]`);
                    loading.classList.remove('d-none')
                    await API.getSeatsMap(seatTables);
                    activeSeats = $$('svg.active');
                    this.clickChooseSeat();
                    seatTables.dataset.rendered = "1";
                    loading.classList.add('d-none');
                }
                EventsAfterLoad.clickStepLocationsButtons();
            }
        });
    },
    clickCloseInforButton: function () {
        closeInforButtons.forEach(e => {
            e.onclick = () => { $(`.open-box[data-tripinfor='${e.dataset.target}']`).classList.add('d-none'); }
        })
    },
    clickTripInforButton: function () {
        tripInforButtons.forEach(ele => {
            ele.onclick = async () => {
                Handler.HideShowInforDetail(ele);
                if (ele.dataset.name === 'rate' && ele.dataset.rendered === '0') {
                    const loading = $(`[data-name='loading${ele.dataset.target}'`);
                    loading.classList.remove('d-none');
                    await API.getComments(ele);
                    ele.dataset.rendered = '1';
                    loading.classList.add('d-none')
                }
            }
        })
    },
    clickChooseSeat: function () {
        activeSeats.forEach(e => {
            e.addEventListener('click', () => {
                const gTag = e.querySelector('g.active,g.selecting')
                gTag.classList.toggle('active');
                gTag.classList.toggle('selecting')
                Handler.CountSelectedSeats($('.route-option.selected'))


            })
        })
    },

    run: function () {
        for (const key in this) {
            if (Object.hasOwnProperty.call(this, key)) {
                if (key != 'run')
                    this[key]()
            }
        }
    }
}

const AssignEventInit = {
    clickSortButtons: function () {
        sortItemButtons.forEach(ele => {
            ele.addEventListener('click', () => {
                if (ele.classList.contains('chosen')) {
                    ele.classList.remove('chosen')
                    dataSort = null;
                }
                else {
                    Handler.UnchooseButtons(ele);
                    dataSort = {
                        col: ele.dataset.col,
                        type: ele.dataset.sort,
                    }
                }
                isFilter = 0;
                Handler.renderTripsSortnFilter()
            })
        })
    },
    changeFilter: function () {
        filterItemSelects.forEach(ele => {
            ele.addEventListener('change', () => {
                isFilter = 1;
                Handler.renderTripsSortnFilter();
            })
        })
    },
    renderCoachesOption: async function () {
        const coaches = await API.getCoachesTypes();
        const selectCoach = $('#select_coach');
        selectCoach.innerHTML += render.coaches(coaches);
    },
    clickLoadMoreTrips:  function () {
        viewMoreButton.onclick = async () => {
            pageNum+=1;
         isPagination=true;
         await Handler.renderTripsSortnFilter();
         isPagination=false;
        }
    },
    run: function () {
        for (const key in this) {
            if (Object.hasOwnProperty.call(this, key)) {
                if (key != 'run')
                    this[key]()
            }
        }
    }
}

const Handler = {
    HideOtherBoxes: function (targeted) {
        openBoxes.forEach(e => {
            if (e != targeted)
                e.classList.add('d-none');
        })
    },
    CountSelectedSeats: function (target) {
        const tSs = target.querySelectorAll.bind(target);
        const tS = target.querySelector.bind(target);

        const selecteds = tSs('g.selecting');

        const pricePerSeat = helper.StringtoPrice(tS('.route-price').textContent);
        let countSeats = tS('.transaction-footer .count');
        let Seatsstr = '';
        selecteds.forEach((e, i) => {
            if (i != 0) {
                Seatsstr += ',';
            }
            Seatsstr += e.parentNode.parentNode.querySelector('tspan').textContent;
        })
        countSeats.innerHTML = `${selecteds.length} vé: ` + Seatsstr;
        seats.str = Seatsstr;
        seats.count = selecteds.length;
        tS('.transaction-footer .total').innerHTML = helper.number_format(Number(pricePerSeat) * selecteds.length) + ' đ';
    },
    HideShowInforDetail: function (target) {
        $(`.infor-title-item.selected[data-trip='${target.dataset.trip}']`).classList.remove('selected');
        target.classList.add('selected');
        const container = target.parentNode.parentNode;
        container.querySelectorAll('.tripinfor-item ').forEach(e => e.classList.add('d-none'));
        container.querySelector(`.tripinfor-item[data-name='${target.dataset.target}'] `).classList.remove('d-none');
    },
    UnSelectedRouteOption: function (imageTargeted = null, routeOptionTargeted = null) {
        imgChooseCheckBoxes.forEach(e => {
            if (e != imageTargeted)
                e.src = images.unselected;
        }
        )
        routeOptions.forEach(e => {
            if (e != routeOptionTargeted)
                e.classList.remove('selected');
        })
    },
    UnchooseButtons: function (target) {
        $('.sort-item.chosen')?.classList.remove('chosen');
        target.classList.add('chosen');
    },
    OpenSeatMapEffect: function (target) {
        const targetedOpenBox = $(`.open-box[data-trip='${target.dataset.target}']`);
        Handler.HideOtherBoxes(targetedOpenBox);
        targetedOpenBox.classList.toggle('d-none');
        const imgcheckBox = target.querySelector('img');
        const routeOption = $(`[data-trip_container='${target.dataset.target}']`);
        Handler.UnSelectedRouteOption(imgcheckBox, routeOption);
        if (imgcheckBox.src == images.selected)
            imgcheckBox.src = images.unselected;
        else imgcheckBox.src = images.selected
        routeOption.classList.toggle('selected');
    },
    renderTripsSortnFilter: async function () {
        const loading = $('[data-name=loadingroutes');
        loading.classList.remove('d-none');
        const data = await API.getRouteOptions();
        console.log(data);
        if (data.trips.length === 0){
            if(!isPagination) {
                $('.routes-container').innerHTML = 'Không có chuyến đi nào';
            }
            $('.load-more-trips').classList.add('d-none');
        } 
        else {
            if(isPagination)
            $('.routes-container').innerHTML +=render.trips(data);
            else  $('.routes-container').innerHTML =render.trips(data);
            AssignEventInTrip.run();
        }
        loading.classList.add('d-none');
    },
    processStepLineInfor: function () {
        this.increaseStepCircle();
        this.lineInforPage();
        title.textContent = "Thông tin khách hàng";

    },
    increaseStepCircle: function () {
        const currentCircleStep = $('.step-line .current-step');
        console.log(currentCircleStep)
        $('.step-item:not(.previous-step):not(.current-step)').classList.add('current-step')
        currentCircleStep.classList.remove('current-step');
        currentCircleStep.classList.add('previous-step');
    },
    decreaseStepCirle: function () {
        const currentCircleStep = $('.step-line .current-step');
        const previous = $$('.step-line .previous-step')
        const lastPrevious = previous[previous.length - 1];
        lastPrevious.classList.add('current-step')
        lastPrevious.classList.remove('previous-step')
        currentCircleStep.classList.remove('current-step');
    },
    moveToPaymentPage: function () {
        paymentCont = $('.payment');
        const loading = $('.wrapper-loading[data-name=loadingroutes');
        loading.classList.remove('d-none');
        this.increaseStepCircle();
        Handler.linePaymentPage();
        title.textContent = "Thanh toán";
        //window.history.pushState("", "", '/payment');
        transaction = Handler.getInforTransaction();
        render.assignDataPaymentPage(transaction);
        EventsAfterLoad.clickConfirmTransaction();
        paymentCont.classList.remove('d-none');
        fillInformationCont.classList.add('d-none');
        loading.classList.add('d-none');

    },
    getInforTransaction: function () {
        const selectedRoute = $('.route-option.selected');
        const S = selectedRoute.querySelector.bind(selectedRoute);
        const trip = {}, ticket = {};

        trip.id = selectedRoute.dataset.trip_container
        trip.serviceProvider = S('.route-infor-provicer-text').textContent;
        let rawProvince = $('[name=departure_province_code] option[selected]').textContent;
        trip.departure = helper.removePrefixProvince(rawProvince);
        rawProvince = $('[name=arrival_province_code] option[selected]').textContent
        trip.arrival = helper.removePrefixProvince(rawProvince);
        trip.departure_date = $('[data-name=departure-date]').textContent;
        trip.departure_time = S('[data-name=departure-time]').textContent;
        ticket.total_price = helper.number_format(helper.StringtoPrice(S('.transaction-footer .total').textContent));
        ticket.departure_station = {};
        ticket.arrival_station = {};
        let departureRadios = $$('input[name=departure]'), arrivalRadios = $$('input[name=arrival]');
        for (let i = 0; i < departureRadios.length; ++i)
            if (departureRadios[i].checked === true) {
                let input = departureRadios[i];
                ticket.departure_station.id = input.value;
                ticket.departure_station.name = $(`[data-name='${input.id}']`).textContent;
            }
        for (let i = 0; i < arrivalRadios.length; ++i)
            if (arrivalRadios[i].checked === true) {
                let input = arrivalRadios[i];
                ticket.arrival_station.id = input.value;
                ticket.arrival_station.name = $(`[data-name='${input.id}']`).textContent;
            }
        ticket.seats = seats;
        return {
            ticket: ticket,
            trip: trip
        }

    },
    lineInforPage: function () {
        const Line = $('.line ')
        Line.innerHTML = `<div class="current-line"></div>
        <div class="current-line"></div>
        <div class="next-line"></div>`
    },
    lineIndexPage: function () {
        const Line = $('.line ')
        Line.innerHTML = `<div class="current-line"></div>
        <div class="next-line"></div>
        <div class="next-line"></div>`
    },
    linePaymentPage: function () {
        const Line = $('.line ')
        Line.innerHTML = `<div class="current-line"></div>
        <div class="current-line"></div>
        <div class="current-line"></div>`
    },
    createTicketsParams: function () {
        const paramsTicket = new URLSearchParams([...new FormData(formInfor).entries()]);

        paramsTicket.append('trip_id', transaction.trip.id)
        paramsTicket.append('departure_station_id', transaction.ticket.departure_station.id)
        paramsTicket.append('arrival_station_id', transaction.ticket.arrival_station.id)
        let seat_positions = transaction.ticket.seats.str.replace(/\n|\s/g, '').split(',');
        seat_positions.forEach(seat => paramsTicket.append('seat_position[]', seat))
        console.log(paramsTicket.toString());
        return paramsTicket;
    }
}
const API = {
    getComments: async function (target) {
        await fetch(target.dataset.api)
            .then(res => res.json())
            .then(data => {
                console.log(data);
                const container = $(`[data-name='${target.dataset.target}'`);
                const commentsContainer = container.querySelector('.rate-comments');
                render.comments(commentsContainer, data);
            })
    },
    getSeatsMap: async function (target) {
        await fetch(target.dataset.api)
            .then(res => res.json())
            .then(data => {
                console.log(data);
                render.seatsMap(target, data);
            })
    },
    getRouteOptions: async function () {
        let params = new URLSearchParams();
        if (dataSort) {
            params.append('sortCol', dataSort.col);
            params.append('sortType', dataSort.type);
        }
        if ( !isPagination) {
            pageNum = 1;
        }
        params.append('isAPI', 1);
        params.append('pageNum', pageNum);
        params.append('isFilter', isFilter);
        console.log(initData)
        params.append('departure_province_code', initData.departure_province_code);
        params.append('arrival_province_code', initData.arrival_province_code);
        params.append('departure_date', initData.departure_date);

        if ($('#select_coach').value != "")
            params.append('coach_type', $('#select_coach').value);
        if ($('#select_rate').value != "")
            params.append('rate', $('#select_rate').value);



        console.log(params.toString())
        const data = await fetch(`${TripAPIURL}/?${params}`)
            .then(res => res.json())
            .then(data => {
                scheduleDetails={...scheduleDetails,...data['scheduleDetails']};
                console.log(scheduleDetails);
                return data;
            })
        return data;
    },
    getCoachesTypes: async function () {
        let params = new URLSearchParams();
        params.append('value', '');
        params.append('all', 1);
        const res = await fetch(`${urlCoachAPI}/?${params}`)
            .then((response) => response.json())
            .then((data) => {
                console.log(data)
                return data;
            })
        return res;
    },
    isExistUser: async function (paramsUser) {
        let res = await fetch(isUserAPIUrl, {
            headers: {
                Accept: "application/json, text/plain, */*",
                "Content-Type": "application/x-www-form-urlencoded",
            },
            method: "POST",
            body: paramsUser,
        }).then(res => res.json());
        console.log(res)
        return res;
    },
    createTickets: async function (params) {
        let res = await fetch(createTicketAPIUrl, {
            headers: {
                Accept: "application/json, text/plain, */*",
                "Content-Type": "application/x-www-form-urlencoded",
            },
            method: "POST",
            body: params,
        }).then(res => res.json());
        console.log(res)
        return res;
    }
}

const helper = {
    Capitalize: function (string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    },
    number_format: function (string) {
        return new Intl.NumberFormat().format(Number(string));
    },
    asset: function (string) {
        return asset + string;
    },
    formatHi: function (time) {
        let arr = time.split(':');
        return arr[0] + ':' + arr[1];
    },
    formatHiaddMinutes: function (time, minutes) {
        let arr = time.split(':');
        let date = new Date(2003, 10, 09, Number(arr[0]), Number(arr[1]), 0, 0);
        date.setMinutes(date.getMinutes() + Number(minutes));
        return date.getHours() + ':' + date.getMinutes();
    },
    APIcomments: function (sp_id) {
        return apiComments + '/' + sp_id;
    },
    APIseats: function (trip_id) {
        return apiSeats + '/' + trip_id;
    },
    StringtoPrice: function (string) {
        const stringPrice = string.split(' ')[0].split(',').join('');
        return Number(stringPrice);
    },
    removePrefixProvince: function (string) {
        return string.replace(/(Tỉnh|Thành phố)/g, '');
    },
    round: function (num, correction) {
        let pow = Math.pow(10, correction);
        return Math.round(Number(num) * pow) / pow;
    }
}
const app = {
    run: async function () {
        AssignEventInTrip.run();
        AssignEventInit.run();
    }
}
app.run();