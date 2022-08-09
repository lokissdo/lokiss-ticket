
const blocks = $$('.popular-block')



// Get popular schedule
window.onload = () => {
    console.log(PopularSchedulesAPIUrl);
    fetch(PopularSchedulesAPIUrl)
        .then(response => response.json())
        .then(res => {
            console.log(res)
            blocks.forEach(element => {
                const elementData = res.shift();
                const select = element.querySelector.bind(element);

                const locations = select('.popular-block-trip-header');
                let arrival_province = elementData.arrival_province.name.replace(/(Tỉnh|Thành phố)/g, '');
                let departure_province = elementData.departure_province.name.replace(/(Tỉnh|Thành phố)/g, '');
                locations.textContent = `${departure_province} ⇒ ${arrival_province}`

                const duration = select('.infor-duration>span')
                duration.textContent = elementData.hour_duration;

                const price = select('.infor-price>span')
                price.textContent = new Intl.NumberFormat().format(Math.round(Number(elementData.price) / 1000) * 1000);
            });

        });

}



