const EventsAfterLoad = {
    clickStepLocationsButtons: function () {
        nextStepButtons = $$('.next-button');
        nextStepButtons.forEach(ele => {
            ele.onclick = () => {
                const target = $('.route-option.selected');
                if (!target.querySelector('g.selecting')) {
                    displayError('Cần chọn ít nhất 1 vé');
                    return;
                }
                chooseLocationsCont = $('.choose-locations')
                chooseLocationsCont.innerHTML = render.choose_locations(target);
                $$('.cont-item').forEach(e => e.classList.add('d-none'))
                chooseLocationsCont.classList.remove('d-none');
                EventsAfterLoad.clickBackToSeatsButtons();
                EventsAfterLoad.checkRadioLocations();
                EventsAfterLoad.clickStepInforButtons()
            }
        })
    },
    clickBackToSeatsButtons: function () {
        const backButton = $('.choose-locations .back');
        backButton.onclick = () => {
            $$('.cont-item').forEach(e => e.classList.remove('d-none'))
            chooseLocationsCont.classList.add('d-none');
            $('.selected.route-option').scrollIntoView();
        }

    },
    clickBackToLocationsButtons: function () {
        const backButton = $('.fill-information .back');
        backButton.onclick = () => {
            chooseLocationsCont.classList.remove('d-none');
            fillInformationCont.classList.add('d-none');
            Handler.decreaseStepCirle()
            const Line=$('.line ')
            Line.innerHTML=`<div class="current-line"></div>
            <div class="next-line"></div>
            <div class="next-line"></div>`
        }

    },
    clickNextToTransactionButtons: function () {
        const nextButton = $('.fill-information .next');
        nextButton.onclick = () => {
            const form=$('form#form-steps')
            console.log($('form#form-steps').checkValidity())
            const params = new URLSearchParams([...new FormData(form).entries()]);
            console.log(params.toString());
            if(!form.checkValidity()){
                displayError('Vui lòng điền đẩy đủ và đúng')
            }
        //    $('form#form-steps').submit();
        }

    },
    checkRadioLocations: function () {
        const arrivalCheckBoxes = $$('[name=arrival]')
        const departureCheckBoxes = $$('[name=departure]')
        const lA = arrivalCheckBoxes.length, lD = departureCheckBoxes.length;
        departureCheckBoxes.forEach((e, index) => {
            e.onclick = () => {
                departure_id = e.value;
                let flag = 0;
                for (let i = 0; i < lA; ++i) {
                    let aChecker = arrivalCheckBoxes[i];
                    aChecker.disabled = (flag === 0 && index !== 0) ? true : false;
                    if (aChecker.value == e.value) flag = 1;
                }

            }
        })
        arrivalCheckBoxes.forEach((e, index) => {
            e.onclick = () => {
                arrival_id = e.value;
                let flag = 0;
                for (let i = lD - 1; i >= 0; --i) {
                    let dCheker = departureCheckBoxes[i];
                    dCheker.disabled = (flag === 0 && index != lA - 1) ? true : false;
                    if (dCheker.value == e.value) flag = 1;

                }
                console.log(arrival_id);
            }
        })
    },
    clickStepInforButtons: function () {
        const nextButton = $('.choose-locations .next');
        nextButton.onclick = () => {
            if (!arrival_id || !departure_id)
                displayError('Vui lòng chọn địa điểm lên và xuống xe!')
            else {
                chooseLocationsCont.classList.add('d-none');
                fillInformationCont=$('.fill-information');
                fillInformationCont.classList.remove('d-none');
                EventsAfterLoad.clickNextToTransactionButtons()
                Handler.processStepLineInfor();
                EventsAfterLoad.clickBackToLocationsButtons()
            }
        }
    },
}