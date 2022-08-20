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
                this.clickBackToSeatsButtons();
                this.checkRadioLocations();
                this.clickStepInforButtons();
                title.textContent = "Xác nhận lộ trình";
                title.classList.remove('d-none');

            }
        })
    },
    clickBackToSeatsButtons: function () {
        const backButton = $('.choose-locations .back');
        backButton.onclick = () => {
            $$('.cont-item').forEach(e => e.classList.remove('d-none'))
            chooseLocationsCont.classList.add('d-none');
            $('.selected.route-option').scrollIntoView();
            title.classList.add('d-none');

        }

    },
    clickBackToLocationsButtons: function () {
        const backButton = $('.fill-information .back');
        backButton.onclick = () => {
            chooseLocationsCont.classList.remove('d-none');
            fillInformationCont.classList.add('d-none');
            Handler.decreaseStepCirle()
            Handler.lineIndexPage();
            title.textContent = "Xác nhận lộ trình";
            window.history.pushState("", "", path);
            arrival_id = departure_id = 0;
        }

    },
    clickNextToTransactionButtons: function () {
        const nextButton = $('.fill-information .next');
        nextButton.onclick = () => {
            formInfor = $('form#form-steps')
            if (!formInfor.checkValidity()) {
                const inputs = formInfor.querySelectorAll('input,select');
                let message = '';
                inputs.forEach(e => {
                    if (!e.checkValidity()) {

                        switch (e.name) {
                            case 'email':
                                message += 'Email không hợp lệ.<br>';
                                break;
                            case 'phone_number':
                                message += 'Số điện thoại không hợp lệ.<br>';
                                break;
                            case 'name':
                                message += 'Tên không hợp lệ.<br>';
                                break;
                        }
                        if (e.validity.valueMissing) {
                            let name = $(`label[for='${e.id}']`).textContent.replace('*', '');
                            message += 'Vui lòng điền ' + name.toUpperCase() + '<br>';

                        }
                    }
                    if(e.name==='address' && e.value=='null')  message += 'Tỉnh/Thành Phố phải được chọn.<br>';
                    if(e.name==='address2' && e.value=='null')  message += 'Quận/Huyện phải được chọn.<br>';

                })

                displayError(message)
                return;
            }
            Handler.moveToPaymentPage();
            this.clickBackToInformation()

        }

    },
    clickBackToInformation: function () {
        const backButton = $('.payment .back');
        backButton.onclick = () => {
            fillInformationCont.classList.remove('d-none');
            paymentCont.classList.add('d-none');
            Handler.decreaseStepCirle();
            Handler.lineInforPage();
            title.textContent = "Thông tin khách hàng";
            window.history.pushState("", "", '/information');


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
                fillInformationCont = $('.fill-information');
                fillInformationCont.classList.remove('d-none');
                this.clickNextToTransactionButtons()
                Handler.processStepLineInfor();
                this.clickBackToLocationsButtons();
                window.history.pushState("", "", '/information');

            }
        }
    },
    clickConfirmTransaction: function () {
        const confirmButton = $('#confirm_transaction')
        confirmButton.onclick = async () => {
            let ticketParams = Handler.createTicketsParams();
            let res = await API.createTickets(ticketParams);
            console.log(res, res == 1, res === 1);
            if (res.status === -1) {
                console.log('loi')
                displayError("Rất tiếc vé đã bị mua mất rôi!!!<br>Tải lại trang để cập nhật");
                return;
            }
            if (res.status === 1) {
                if (res.user_password) {
                    console.log('modal')
                    $('.modal-message .text-content').innerHTML += `<br>Mời bạn xem hóa đơn tại tài khoản 
                    <div>- Email: ${formInfor['email'].value}</div>
                    <div>- Mật khẩu:  <span id="newPass">${res.user_password}</span>  <img class="hoverable" id="copyToClipBoard"src="https://img.icons8.com/material-outlined/25/000000/copy.png"/></div>
                    <br>
                    <br>
                    `
                    this.copyToClipBoard();
                }

                console.log('Mo')
                $('.modal-message').classList.remove('d-none');
            }
        }
    },
    copyToClipBoard: function () {
        $('#copyToClipBoard').onclick = () => {
            var copyText = $("#newPass").textContent.trim();
            const textArea = document.createElement("textarea");
            textArea.value = copyText;
            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select();
            document.execCommand('copy');
            $('#copyToClipBoard').src = "https://img.icons8.com/wired/25/000000/checked-2.png";
            textArea.classList.add('d-none')
        }
    }

}