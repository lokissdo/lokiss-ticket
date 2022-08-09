<div class="error-modal d-none">
    Vui long chon dien diem di
</div>
<style>
    .error-modal {
        background-color: var(--orange-color);
        color: whitesmoke;
        height: 70px;
        padding: 20px;
        position: fixed;
        top: 50%;
        right: 0;
        animation: show 4s linear;
    }

    @keyframes show {
        0% {
            transform: translateX(200px);
        }

        10% {
            transform: translateX(0px);
            opacity: 1;
        }

        80% {
            transform: translateX(0px);
            opacity: 1;
        }

        100% {
            opacity: 0;
        }
    }
</style>
<script type="text/javascript">
    const errorModal = $('.error-modal');
    var time_on = 0;
    let myTimeout;
    function displayError(errorContent) {
        if (time_on == 1) return;
        errorModal.textContent = errorContent;
        errorModal.classList.remove('d-none');
        time_on = 1;
        myTimeout = setTimeout(() => {
            time_on = 0;
            errorModal.classList.add('d-none');
            time_on = 0;
        }, 4000);
    };
</script>
