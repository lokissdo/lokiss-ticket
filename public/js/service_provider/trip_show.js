const $ = document.querySelector.bind(document)
$('#show-seat-detail').onchange = (e) => {
    if (e.target.checked) {
        $('.seat-detail').classList.remove('d-none')
    }
    else {
        $('.seat-detail').classList.add('d-none')

    }
}
$('#show-station-detail').onchange = (e) => {
    if (e.target.checked) {
        $('.station-detail').classList.remove('d-none')
    }
    else {
        $('.station-detail').classList.add('d-none')

    }
}