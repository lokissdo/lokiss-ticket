const $$ = document.querySelectorAll.bind(document);
const $ = document.querySelector.bind(document);
const form = $("form");
const uri = form.getAttribute("action");
const message = $("#message_display");

function SubmitFormHandler(e) {
    e.preventDefault();
    // const formEntries=new FormData(form).entries();
    // const data = Object.fromEntries(formEntries);
    // console.log(data)
    const params = new URLSearchParams([...new FormData(form).entries()]);
    console.log(params.toString());
    fetch(uri, {
        headers: {
            Accept: "application/json, text/plain, */*",
            "Content-Type": "application/x-www-form-urlencoded",
        },
        method: "POST",
        body: params,
    })
        .then((response) => response.json())
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
        });
    // .catch((e) => console.log(e, "Pls don't dp that"));
    
}
form.addEventListener("submit", SubmitFormHandler);
function ErrorHandler(e) {
    return `
        ${e.map((one) => `<li>${one}</li>`)}
   `;
}
