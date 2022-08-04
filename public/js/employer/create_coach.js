const $$ = document.querySelectorAll.bind(document);
const $ = document.querySelector.bind(document);
const form = $("form");
const uri = form.getAttribute("action");
const message = $("#message_display");
const photoInput = $('#image-file')



// Can't recieve messages 'cause backend mistake this req with redirect req
function SubmitFormHandler(e) {
    e.preventDefault();
    const formData = new FormData(form);
    formData.append('photo', photoInput.files[0])
    console.log(...formData.entries());
    fetch(uri, {
        method: "POST",
        body: formData
    })
        .then((response) => response.text())
        .then((res) => {
            let html;
            console.log(res);
            if (res.errors) {
                errors = res.errors;
                console.log(errors);
                html = '<div class="alert alert-danger"><ul>';
                for (const key in errors) {
                    html += ErrorHandler(errors[key]);
                }
                html += " </ul> </div>";
            } else {
                html =
                    `<div class="alert alert-success">Thêm ${object} thành công<ul>`;
                // window.location.href =
                //     $("#show_list").getAttribute("href");
            }
            message.innerHTML = html;
        })
        .catch((e) => {
            console.log(e, "Pls don't dp that")
        });

}
form.addEventListener("submit", SubmitFormHandler);
function ErrorHandler(e) {
    return `
        ${e.map((one) => `<li>${one}</li>`)}
   `;
}
