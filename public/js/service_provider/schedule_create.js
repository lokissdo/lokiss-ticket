var searchSation = Array.from($$(".search-station")).pop();
var X = Array.from($$(".unapproved")).pop();
var tick = Array.from($$(".approved")).pop();
var list_suggested = Array.from($$(".list_suggested")).pop();
var container_station_input = $(".container-station-input").cloneNode(true);
var addStation = $("#add-station");
console.log(urlStationAPI);
console.log(searchSation)

init();


//Events
function clickStationItem(e) {
    const chosen = Array.from($$("#chosen_station")).pop();
    chosen.value = e.target.value;
    searchSation.value = e.target.textContent;
    searchSation.disabled = true;
    list_suggested.classList.add('d-none');

    //show tick
    tick.classList.remove("d-none");
    X.classList.add("d-none");
    //show addStation button
    addStation.classList.remove("d-none");
    // show delete button
    const deleteButtons=Array.from($$(".delete-station"));
    if(deleteButtons.length > 1) {
        deleteButtons[0].classList.remove("d-none");
        deleteButtons.pop().classList.remove("d-none");
    }
    else  deleteButtons[0].classList.add("d-none");
}
addStation.addEventListener('click', addStationInput);
function addStationInput() {
    const newStation = container_station_input.cloneNode(true);
    Array.from($$(".container-station-input")).pop().insertAdjacentElement("afterend", newStation);
    addStation.classList.add("d-none");
    init();
}
function assignEventItemSuggested() {
    items_suggested = $$(".item_suggested");
    items_suggested.forEach(element => {
        element.addEventListener('click', clickStationItem);
    });
}
function CallAPIwithStation(e) {

    let params = new URLSearchParams();
    params.append('value', e.target.value);
    let Stations = Array.from($$("#chosen_station"));
    let pre = [];
    for (let i = 0; i < Stations.length - 1; ++i)
        pre.push(Stations[i].value);
    params.append('preVal', pre);
    fetch(`${urlStationAPI}/?${params}`)
        .then((response) => response.json())
        .then((res) => {
            list_suggested.innerHTML = res.map(ele => itemSuggeted(ele)).join(' ');
            assignEventItemSuggested();

        })
}


function init() {
    searchSation = Array.from($$(".search-station")).pop();
    X = Array.from($$(".unapproved")).pop();
    list_suggested = Array.from($$(".list_suggested")).pop();
    tick = Array.from($$(".approved")).pop();
    addStation.classList.add("d-none");
    searchSation.addEventListener('keyup', CallAPIwithStation);
    $$(".delete-station ").forEach(ele => {
        ele.addEventListener('click', (e) => {
            const deleteButtons=Array.from($$(".delete-station"));
            if(deleteButtons.length > 1) {
            e.target.parentNode.remove();
            }
        })
    })

}

// render
function itemSuggeted(data) {
    return `<li class="list-group-item hoverable item_suggested" value="${data.id}">${data.name}(${data.district_name},${data.province_name} )</li>`
}
