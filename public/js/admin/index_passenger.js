
const $ = document.querySelector.bind(document);
const $$ = document.querySelectorAll.bind(document);
var sortCol = 'id', sortType = 'asc', searchCol = 'name', searchVal = '';
const sortButtons = $$('.sort-bar');
const searchButtons = $$('[data-name=search-bar]')
const searchInputs = $$('[data-name=search-input]');
const selectIcon = $('[data-name=select-icon]')
const addressSelectors = $$("#select_pro, #select_dis")
var  paginateButtons;
var pageNum=0;


function AssignEventPaginateButton(){
    paginateButtons=$$('[data-page]');
    paginateButtons.forEach(element => {
        element.addEventListener('click',()=>{
            pageNum=element.dataset.page;
            CallAPIForSearchnSort()
        });
    });
}
addressSelectors.forEach(element => {
    element.addEventListener('change', CallAPIForSearchnSort);
})

selectIcon.onclick = clickSelectIconHandler;
function clickSelectIconHandler(e) {
    $('[data-name=select-address]').classList.remove('d-none');
    selectIcon.onclick = e => {
        $('[data-name=select-address]').classList.add('d-none');
        selectIcon.onclick = clickSelectIconHandler;
    }
}

searchInputs.forEach(element => {
    element.addEventListener('keyup', CallAPIForSearchnSort)
})

sortButtons.forEach(element => {
    element.addEventListener('click', function (e) {
        const parentTag = element.parentNode;
        const nextIcon = parentTag.querySelector(`[data-val='${element.dataset.next}']`);;
        changeItemSort(element, nextIcon, parentTag);
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
    params.append('sortCol', sortCol);
    params.append('sortType', sortType);
    params.append('searchCol', searchCol);
    params.append('searchVal', searchVal);
    params.append('address', $('#select_pro').value);
    params.append('address2', $('#select_dis').value);
    params.append('searchVal', searchVal);
    params.append('pageNum', pageNum);

    console.log(params.toString())
    params.append('isAPI', true);
    fetch(`${urlApi}/?${params}`)
        .then((response) => response.json())
        .then((data) => {
            console.log(data)
            renderItems(data)
            AssignEventPaginateButton();
        })
}
function renderItems({ passengers, totalPage }) {
    const tbody = $('#data-table');
    let html = '';
    passengers.forEach(passenger => {
        let date = new Date(passenger['created_at']);
        passenger['created_at'] = date.getFullYear() +
            "-" + "0".repeat(2 - String(date.getMonth() + 1).length) + (date.getMonth() + 1) +
            "-" + "0".repeat(2 - String(date.getDate()).length) + date.getDate() +
            " " + date.getHours() +
            ":" + "0".repeat(2 - String(date.getMinutes()).length) + date.getMinutes() +
            ":" + "0".repeat(2 - String(date.getSeconds()).length) + date.getSeconds();
        html += `
        <tr>
        <th scope="row">${passenger['id']}</th>
        <td>${passenger['name']}</td>
        <td>${passenger['email']}</td>
        <td>
            <img src="${passenger['avatar']}" alt="" width="32" height="32"
                class="rounded-circle me-2">
        </td>
        <td>${passenger['address_name']}</td>
        <td>${passenger['created_at']}</td>
    </tr>
    `
    })
    tbody.innerHTML = html;
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
