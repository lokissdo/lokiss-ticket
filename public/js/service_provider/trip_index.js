const $ = document.querySelector.bind(document);
const $$ = document.querySelectorAll.bind(document);
var deleteButtons;
var sortCol = 'id', sortType = 'asc', searchCol = 'name', searchVal = '';
const sortButtons = $$('.sort-bar');
const searchButtons = $$('[data-name=search-bar]')
const searchInputs = $$('[data-name=search-input]');
const selectIcons = $$('[data-name=select-icon]')
const Selectors = $$("select")

var paginateButtons;
var pageNum = 0;
var isFilter = 1;


const AssignEvent = {
    DeleteTrip: function () {
        deleteButtons = document.querySelectorAll("#delete_trip");
        deleteButtons.forEach(deleteButton => {
            deleteButton.onclick = (e) => {
                e.preventDefault();
                if (window.confirm('Bạn có chắc chắn muốn xóa nhân viên này?')) {
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
                CallAPIForSearchnSort()
            }
        });
    },
    CloseSeLect: function () {
        $('.close-select').onclick = (e) => {
            console.log(e.target.nodeName, e.target.nodeName != 'select')
            if (e.target.nodeName != 'SELECT' && e.target.nodeName != 'INPUT')
                $$('.select-dropdown').forEach(e => {
                    if (!e.classList.contains('d-none')) e.classList.add('d-none')
                })
        }
    },
    run: function () {
        for (const key in this) {
            if (Object.hasOwnProperty.call(this, key)) {
                if(key!='run')
                this[key]()
            }
        }
    }

}

AssignEvent.run()

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
        if (icon.nodeName == "path" ||icon.nodeName==="IMG" ) icon = icon.parentNode;
        console.dir(e.target.nodeName)
        const trigger = $(`[data-name='${icon.dataset.trigger}']`);
        trigger.classList.toggle('d-none');
        console.log(trigger.classList)

    }

}
const Api = {
    getCoaches: async function () {
        let params = new URLSearchParams();
        params.append('value', '');
        const res = await fetch(`${urlCoachAPI}/?${params}`)
            .then((response) => response.json())
            .then((data) => {
                console.log(data)
                return data;
            })
        return res;
    }
}

const render = {
    CoachesOption: async function () {
        const coaches = await Api.getCoaches();
        console.log(coaches)
        const selectCoach = $('#select_coach');
        selectCoach.innerHTML += coaches.map(e => ` <option class="input-group form-control"
        value="${e.id}"> ${e.name}</option>`).join(' ');
    }
}
render.CoachesOption();

sortButtons.forEach(element => {
    element.addEventListener('click', function (e) {
        const parentTag = element.parentNode;
        const nextIcon = parentTag.querySelector(`[data-val='${element.dataset.next}']`);;
        Handler.changeItemSort(element, nextIcon, parentTag);
        isFilter = 0;
        // CallAPIForSearchnSort()
    })
});
// Selectors.forEach(element => {
//     element.addEventListener('change', () => {
//         isFilter = 1;
//         CallAPIForSearchnSort();
//     });
// })
selectIcons.forEach(element => {
    element.onclick = Handler.ClikcSelectIcon;
})