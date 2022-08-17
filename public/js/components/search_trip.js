const form = $('form#search_trip')
const departure_code = $('[name=departure_province_code]')
const arrival_code = $('[name=arrival_province_code]')
const departure_date = $('[name=departure_date]')


$('button.search-trip').onclick = (e) => {
    e.preventDefault();
    let errorTitle='';
    if (departure_code.value == 'null') errorTitle=$(`[data-label=${departure_code.name}]`).textContent
    if (arrival_code.value == 'null') errorTitle=$(`[data-label=${arrival_code.name}]`).textContent
    if (departure_date.value == '') errorTitle=$(`[data-label=${departure_date.name}]`).textContent
    if(errorTitle!=='') displayError(`${errorTitle} cần được chọn. `)
    else form.submit();
}

