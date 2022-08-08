const coach_display = $('#coach_display');
const coach_id = $('#coach_id');
const list_suggested = $('#list_suggested')




$('#price').onkeyup = (e) => {
    let num = Number(String(e.target.value).replace(/[^0-9.]+/g, ""))
    e.target.value = new Intl.NumberFormat().format(num)
}

coach_display.onkeyup = CallCoachAPI;
coach_display.onfocus = (e) => {
    let value = String(coach_display.value);
    coach_display.value = value.replace(/\(.+\)/g, '');
    CallCoachAPI(e);
}

$('#submit-button').onclick = (e) => {
    $$("input").forEach(e => e.disabled = false)
}





function CallCoachAPI(e) {
    let params = new URLSearchParams();
    params.append('value', e.target.value);
    fetch(`${urlCoachAPI}/?${params}`)
        .then((response) => response.json())
        .then((res) => {
            console.log(res)
            list_suggested.innerHTML = res.map(ele => itemSuggeted(ele)).join(' ');
            list_suggested.classList.remove('d-none');
            // list_suggested.innerHTML = res.map(ele => itemSuggeted(ele)).join(' ');
            assignEventItemSuggested();
        })
}



function itemSuggeted(data) {
    return `<li class="list-group-item item_suggested cursor-pointer" data-value="${data.id}">${data.name} (${data.type_name}, ${data.seat_number} chỗ)</li>`
}



function assignEventItemSuggested() {
    items_suggested = $$(".item_suggested");
    items_suggested.forEach(element => {
        element.addEventListener('click', clickItemSuggestedHandler);
    });
}
function clickItemSuggestedHandler(e) {
    const trigger = e.target;
    coach_id.value = trigger.dataset.value;
    coach_display.value = trigger.textContent;
    list_suggested.classList.add('d-none');
}