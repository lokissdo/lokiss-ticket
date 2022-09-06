const initEvent = {
    seeDetails: function () {
        $$('[data-name=see_detail]').forEach(element => {
            element.onclick = () => {
                const container = $(`[data-name=${element.dataset.target}]`);
                container.querySelectorAll('.detail-ticket').forEach(e => e.classList.toggle('d-none'))
            }
        });
    },
    rate_trip: function () {
        $$('[data-name=rate_button]').forEach(element => {
            element.onclick = async () => {
                const loading = $(`[data-name=loadingrating${element.dataset.target}]`);
                const container = $(`[data-name=${element.dataset.target}]`);
                loading.classList.toggle('d-none');
                if (container.dataset.rendered == '0') {
                    await Handler.processRateData(container, element.dataset.trip_id);
                    container.dataset.rendered = '1';
                }
                container.classList.toggle('d-none');
                loading.classList.toggle('d-none');

            }
        });
    },
    rate: function () {
        $$('.rating-btn').forEach(ele => {
            ele.onclick = async (e) => {
                e.preventDefault();
                await Handler.rate(ele);
                $(`.rating-post[data-key="${ele.dataset.key}"]`).classList.remove('d-none');
                $(`.star-widget[data-key="${ele.dataset.key}"]`).classList.add('d-none');

            }
        })
    },
    editRate: function () {
        $$('.rating-edit').forEach(ele => {
            ele.onclick =  (e) => {
                $(`.rating-post[data-key="${ele.dataset.key}"]`).classList.add('d-none');
                $(`.star-widget[data-key="${ele.dataset.key}"]`).classList.remove('d-none');
            }
        })
    },
    deleteTicket: function(){
        $$('[data-name="delete-tickets"]').forEach(ele=>{
            ele.onclick= async()=>{
                if(confirm('Bạn có chắc chắn muốn hủy vé/những vé này')){
                    const params=new URLSearchParams();
                    let tripId=ele.dataset.trip_id
                    params.append('trip_id',tripId);
                    params.append('created_at',ele.dataset.created_at);
                    const res = await fetch(delete_ticketAPIURL, {
                        method: "POST",
                        body: params,
                    })
                        .then((response) => response.json());
                    console.log(res);
                    let timestamp=(new Date(ele.dataset.created_at)).getTime() / 1000;
                    let container=$(`[data-name="a${tripId}_${timestamp}"]`);
                    let titleCont= container.querySelector('.title-bar-bg.wait');
                    titleCont.classList.remove('wait');
                    titleCont.classList.add('canceled');
                    titleCont.querySelector('.title-txt').textContent="TRẠNG THÁI: ĐÃ HỦY";
                    ele.remove();
                }
            }
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
    processRateData: async function (targeted, trip_id) {
        let res = await API.getRatingsData(trip_id);
        if (res.status === -1 || !res.data) return;
        let data = res.data;
        const tS = targeted.querySelector.bind(targeted);
        tS(`input[value="${data.rate}"]`).checked = true;
        tS('#rate-comment').value = data.comment;
    },
    rate: async function (targeted) {
        const form = targeted.parentNode;
        const formData = new FormData(form);
        // const formEntries=new FormData(form).entries();
        // const data = Object.fromEntries(formEntries);
        // console.log(data)
        let rateValue;

        form.parentNode.querySelectorAll('input.rating-input').forEach(e => {
            if (e.checked == true)
                rateValue = e.value;
        });
        formData.append('comment', form.querySelector('#rate-comment').value);
        formData.append('rate', rateValue)
        const res = await fetch(form.getAttribute('action'), {
            method: "POST",
            body: formData,
        })
            .then((response) => response.json());
        console.log(res);
    }
}
const API = {
    getRatingsData: async function (trip_id) {
        let params = new URLSearchParams();
        params.append('trip_id', trip_id)
        let data = await fetch(getRatingsInforAPIURL + '/?' + params).then(res => res.json());
        console.log(data);
        return data;
    },
}
initEvent.run();