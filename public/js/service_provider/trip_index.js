const $ = document.querySelector.bind(document);
const $$ = document.querySelectorAll.bind(document);
var deleteButtons;
var sortCol = 'id', sortType = 'asc', searchCol = 'name', searchVal = '';
const sortButtons = $$('.sort-bar');
const searchButtons = $$('[data-name=search-bar]')
const selectIcons = $$('[data-name=select-icon]')
const Selectors = $$("select")
const departureDateSelector = $('[name=departure_date]')
const urlShowTrip = $("#delete_form~a").href
const urlDeleteTrip = $("#delete_form").getAttribute('action')


var paginateButtons;
var pageNum = 0;
var isFilter = 1;


const AssignEvent = {
    DeleteTrip: function () {
        deleteButtons = document.querySelectorAll("#delete_trip");
        deleteButtons.forEach(deleteButton => {
            deleteButton.onclick = (e) => {
                e.preventDefault();
                if (window.confirm('Bạn có chắc chắn muốn xóa chuyến đi này?')) {
                    e.target.parentNode.submit();
                }
            }
        });
    },
    Paginate: function () {
        paginateButtons = $$('[data-page]');
        paginateButtons.forEach(element => {
            element.onclick = () => {
                pageNum = element.dataset.page;
                isFilter = 0;
                CallAPIForSortnFilter()
            }
        });
    },
    CloseSeLect: function () {
        $('.close-select').onclick = (e) => {
            if (e.target.nodeName != 'SELECT' && e.target.nodeName != 'INPUT')
                $$('.select-dropdown').forEach(e => {
                    if (!e.classList.contains('d-none')) e.classList.add('d-none')
                })
        }
    },
    ShowSelect: function () {
        selectIcons.forEach(element => {
            element.onclick = Handler.ClikcSelectIcon;
        })
    },
    Sort: function () {
        sortButtons.forEach(element => {
            element.addEventListener('click', function (e) {
                const parentTag = element.parentNode;
                const nextIcon = parentTag.querySelector(`[data-val='${element.dataset.next}']`);;
                Handler.changeItemSort(element, nextIcon, parentTag);
                isFilter = 0;
                CallAPIForSortnFilter()
            })
        });
    },
    SelectorDate: function () {
        departureDateSelector.onchange = () => {
            isFilter = 1;
            CallAPIForSortnFilter();
        }
    },
    Selectors: function () {
        Selectors.forEach(element => {
            element.addEventListener('change', () => {
                isFilter = 1;
                CallAPIForSortnFilter();
            });
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
const Handler = {
    changeItemSort: function (trigger, nextIcon, parentTag) {
        // set the others default icon
        sortButtons.forEach(e => {
            if (e != trigger && e.parentNode != parentTag) {
                if (e.dataset.val != '') {
                    e.classList.add('d-none');
                } else
                    e.classList.remove('d-none');
            }
        })
        trigger.classList.add('d-none');
        nextIcon.classList.remove('d-none');
    },
    ClikcSelectIcon: function (e) {
        e.stopPropagation();
        var icon = e.target
        if (icon.nodeName == "path" || icon.nodeName === "IMG") icon = icon.parentNode;
        console.dir(e.target.nodeName)
        const trigger = $(`[data-name='${icon.dataset.trigger}']`);
        trigger.classList.toggle('d-none');
    }
}
const Api = {
    getCoaches: async function () {
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
AssignEvent.run()


const render = {
    CoachesOption: async function () {
        const coaches = await Api.getCoaches();
        const selectCoach = $('#select_coach');
        selectCoach.innerHTML += coaches.map(e => ` <option class="input-group form-control"
        value="${e.id}"> ${e.name}</option>`).join(' ');
    },
    Pagination: function (totalPage) {
        if (totalPage == -1) return;
        let htmlPagination = '';
        for (let i = 1; i <= totalPage; ++i)
            htmlPagination +=
                `<li class="page-item">
                    <a class="page-link" data-page="${i}">${i}</a>
                </li>`
        $('.pagination').innerHTML = htmlPagination;
    },
    renderItems: function (trips) {
        const tbody = $('#data-table');
        let html = '';
        trips.forEach(trip => {
            html += `
            <th scope="row">${trip['id']}</th>
            <td>${trip['schedule']['departure_province_name']}</td>
            <td>${trip['schedule']['departure_time']} |  ${helper.dateFormatDMY(trip['departure_date'])} 
            </td>
    
            <td>${trip['schedule']['arrival_province_name']}</td>
            <td>${trip['schedule']['hour_duration']}
            </td>
            <td>${trip['coach']['name']} ( ${trip['coach']['seat_number']} chỗ )</td>
            <td>${new Intl.NumberFormat().format(trip['price'])} VND </td>
    
    
            <td>
                <div class="d-flex justify-content-around">
                    <form id="delete_form" method="POST"
                        action="${helper.SetDeletePHPUrl(trip['id'])}">
                        <input type="hidden" name="_method" value="DELETE">
                        <button id="delete_trip" class="btn btn-danger btn-sm" type="submit">
                            Xóa
                        </button>
                    </form>
                    <a class="btn btn-primary btn-sm "
                        href="${helper.SetShowPHPUrl(trip['id'])}"
                        role="button">Xem chi tiết </a>
                </div>
    
            </td>
        </tr>
        `
        })
        tbody.innerHTML = html;
        $('.count').textContent = `Tổng cộng: ${trips.length}`

    }

}


const helper = {
    dateFormatDMY: function (date) {
        str = date.split('-');
        return str[2] + '-' + str[1] + '-' + str[0];
    },
    SetDeletePHPUrl: function (id) {
        let lastIndex = urlDeleteTrip.lastIndexOf('/');
        var res = urlDeleteTrip.slice(0, lastIndex + 1);
        return res + id;
    },
    SetShowPHPUrl: function (id) {
        let lastIndex = urlShowTrip.lastIndexOf('/');
        var res = urlShowTrip.slice(0, lastIndex + 1);
        return res + id;
    }
}
window.addEventListener('load',render.CoachesOption)



function CallAPIForSortnFilter() {
    $('.wrapper-loading').classList.remove('d-none');
    let params = new URLSearchParams();
    let tempSort = $('.sort-bar:not(.d-none):not([data-val=\'\'])');
    if (tempSort) {
        sortCol = tempSort.parentNode.dataset.sortcol;
        sortType = tempSort.dataset.val;
    }
    if (isFilter) {
        pageNum = 0;
    }
    params.append('sortCol', sortCol);
    params.append('sortType', sortType);
    params.append('departure_province_code', $('select[data-name=select-departure-code]').value);
    params.append('arrival_province_code', $('select[data-name=select-arrival-code]').value);
    params.append('coach_id', $('#select_coach').value);
    params.append('departure_date', $('input[name=departure_date]').value);




    params.append('pageNum', pageNum);
    params.append('isFilter', isFilter);

    console.log(params.toString())
    params.append('isAPI', true);
    fetch(`${urlFilterAndSortAPI}/?${params}`)
        .then((response) => response.json())
        .then((data) => {
            console.log(data)
            render.renderItems(data.trips)
            render.Pagination(data.total_page)
            AssignEvent.Paginate();
            $('.wrapper-loading').classList.add('d-none');

        })
}



