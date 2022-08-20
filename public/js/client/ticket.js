const initEvent={
    seeDetails: function(){
        $$('[data-name=see_detail]').forEach(element => {
            element.onclick=()=>{
                const container=$(`[data-name=${element.dataset.target}]`);
                container.querySelectorAll('.detail-ticket').forEach(e=>e.classList.toggle('d-none'))
            }
        });
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
initEvent.run();