let detailButtons, chooseButtons, openBoxes,
    imgChooseCheckBoxes, routeOptions, closeInforButtons,
    tripInforButtons, activeSeats, nextStepButtons,
    chooseLocationsCont,fillInformationCont;

const sortItemButtons = $$('.sort-item');
const filterItemSelects = $$('.filter-select')
let dataSort = null;
let isFilter = 0, pageNum = 0;
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
        console.log(activeSeats)
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
        tS('.transaction-footer .total').innerHTML = helper.number_format(Number(pricePerSeat) * selecteds.length) + 'đ';
    },
    HideShowInforDetail: function (target) {
        console.log(target)
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
        if (data.trips.length === 0) {
            $('.routes-container').innerHTML = 'Không có chuyến đi nào';
        }
        else {
            $('.routes-container').innerHTML = render.trips(data)
            AssignEventInTrip.run();
        }
        loading.classList.add('d-none');
    },
    processStepLineInfor: function(){
        Handler.increaseStepCircle();
         const Line=$('.line ')
        Line.innerHTML=`<div class="current-line"></div>
        <div class="current-line"></div>
        <div class="next-line"></div>`
    },
    increaseStepCircle: function(){
        const currentCircleStep=$('.step-line .current-step');
        console.log(currentCircleStep)
        $('.step-item:not(.previous-step):not(.current-step)').classList.add('current-step')
        currentCircleStep.classList.remove('current-step');
        currentCircleStep.classList.add('previous-step');
    },
    decreaseStepCirle: function(){
        const currentCircleStep=$('.step-line .current-step');
        const previous=$$('.step-line .previous-step')
        const lastPrevious= previous[previous.length-1];
        lastPrevious.classList.add('current-step')
        lastPrevious.classList.remove('previous-step')
        currentCircleStep.classList.remove('current-step');
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
        if (isFilter) {
            pageNum = 0;
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
                scheduleDetails = data['scheduleDetails'];
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
    }
}

const helper = {
    Capitalize: function (string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    },
    number_format: function (string) {
        return new Intl.NumberFormat().format(string);
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
    }
}
const app = {
    run: async function () {
        AssignEventInTrip.run();
        AssignEventInit.run();
    }
}
app.run();