
const $ = document.querySelector.bind(document);
const $$ = document.querySelectorAll.bind(document);
var sortCol = 'id', sortType = 'asc', searchCol = 'name', searchVal = '';
const sortButtons = $$('.sort-bar');
const searchButtons = $$('[data-name=search-bar]')
const searchInputs = $$('[data-name=search-input]');
const selectIcons = $$('[data-name=select-icon]')
// const addressSelectors = $$("#select_pro, #select_dis")
const Selectors = $$("select")

var paginateButtons;
var pageNum = 0;
var isFilter = 1;

function AssignEventPaginateButton() {
    paginateButtons = $$('[data-page]');
    paginateButtons.forEach(element => {
        element.onclick = () => {
            pageNum = element.dataset.page;
            isFilter = 0;
            CallAPIForSearchnSort()
        }
    });
}
Selectors.forEach(element => {
    element.addEventListener('change', () => {
        isFilter = 1;
        CallAPIForSearchnSort();
    });
})

selectIcons.forEach(element => {
    element.onclick = clickSelectIconHandler;
})

// selectIcon.onclick = clickSelectIconHandler;
function clickSelectIconHandler(e) {
    var icon = e.target
    if (icon.nodeName == "path") icon = icon.parentNode;
    const trigger = $(`[data-name='${icon.dataset.trigger}']`);
    trigger.classList.remove('d-none');
    // console.log(trigger)
    icon.onclick = (e) => {
        trigger.classList.add('d-none');
        console.log(icon)
        icon.onclick = clickSelectIconHandler;
    }
}

searchInputs.forEach(element => {
    element.addEventListener('keyup', () => {
        isFilter = 1;
        CallAPIForSearchnSort();
    }
    )
})

sortButtons.forEach(element => {
    element.addEventListener('click', function (e) {
        const parentTag = element.parentNode;
        const nextIcon = parentTag.querySelector(`[data-val='${element.dataset.next}']`);;
        changeItemSort(element, nextIcon, parentTag);
        isFilter = 0;
        CallAPIForSearchnSort()
    })
});





function searchButtonsClickedHandler(e) {
    var element = e.target;
    if (element.nodeName == "path") element = element.parentNode
    const parentTag = element.parentNode;
    ShowHideSearchItem(element, parentTag);
}


searchButtons.forEach(element => {
    element.onclick = searchButtonsClickedHandler
});


function ShowHideSearchItem(element, parentTag) {
    $$('[data-name=search-input]').forEach(ele => ele.classList.add('invisible'))
    searchButtons.forEach(element => {
        element.onclick = searchButtonsClickedHandler
    });
    parentTag.querySelector('[data-name=search-input]').classList.remove('invisible');
    element.onclick = (e) => {
        parentTag.querySelector('[data-name=search-input]').classList.add('invisible');
        element.onclick = searchButtonsClickedHandler;
    }

}


function CallAPIForSearchnSort() {
    $('.wrapper-loading').classList.remove('d-none');
    let params = new URLSearchParams();
    let tempSort = $('.sort-bar:not(.d-none):not([data-val=\'\'])');
    let tempSearch = $('[data-name=search-input]:not(.invisible)');

    if (tempSort) {
        sortCol = tempSort.parentNode.dataset.sortcol;
        sortType = tempSort.dataset.val;
    }
    if (tempSearch) {
        searchCol = tempSearch.parentNode.dataset.searchcol;
        searchVal = tempSearch.value;
    }
    if (isFilter) {
      pageNum=0;
    }
    params.append('sortCol', sortCol);
    params.append('sortType', sortType);
    params.append('searchCol', searchCol);
    params.append('searchVal', searchVal);
    params.append('address', $('#select_pro').value);
    params.append('address2', $('#select_dis').value);
    params.append('role', $('#select_role').value);

    params.append('searchVal', searchVal);
    params.append('pageNum', pageNum);
    params.append('isFilter', isFilter);

    console.log(params.toString())
    params.append('isAPI', true);
    fetch(`${urlApi}/?${params}`)
        .then((response) => response.json())
        .then((data) => {
            console.log(data)
            renderItems(data)
            AssignEventPaginateButton();
    $('.wrapper-loading').classList.add('d-none');

        })
}
function renderItems({ users, totalPage }) {
    const tbody = $('#data-table');
    let html = '';
    users.forEach(user => {
        let date = new Date(user['created_at']);
        user['created_at'] = date.getFullYear() +
            "-" + "0".repeat(2 - String(date.getMonth() + 1).length) + (date.getMonth() + 1) +
            "-" + "0".repeat(2 - String(date.getDate()).length) + date.getDate() +
            " " + date.getHours() +
            ":" + "0".repeat(2 - String(date.getMinutes()).length) + date.getMinutes() +
            ":" + "0".repeat(2 - String(date.getSeconds()).length) + date.getSeconds();
        html += `
        <tr>
        <th scope="row">${user['id']}</th>
        <td>${user['name']}</td>
        <td>${user['email']}</td>
        <td>
            <img src="${user['avatar']}" alt="" width="32" height="32"
                class="rounded-circle me-2">
        </td>
        <td>${user['address_name']}</td>
        <td>${user['created_at']}</td>
        <td>${user['role_name']}</td>
    </tr>
    `
    })
    tbody.innerHTML = html;
    $('.count').textContent=`Tổng cộng: ${users.length}`
    if (totalPage == -1) return;
    let htmlPagination = '';
    for (let i = 1; i <= totalPage; ++i)
        htmlPagination +=
            `<li class="page-item">
                <a class="page-link" data-page="${i}">${i}</a>
            </li>`
    $('.pagination').innerHTML = htmlPagination;

}
function changeItemSort(trigger, nextIcon, parentTag) {
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
}



// onload
AssignEventPaginateButton()
