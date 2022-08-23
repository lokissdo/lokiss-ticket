const $$ = document.querySelectorAll.bind(document);
const $ = document.querySelector.bind(document);
const uri = form.getAttribute("action");
const message = $("#message_display");

function SubmitFormHandler(e) {
    e.preventDefault();
    const formData = new FormData($("#form"));
    // const formEntries=new FormData(form).entries();
    // const data = Object.fromEntries(formEntries);
    // console.log(data)
    fetch(uri, {
        method: "POST",
        body: formData,
    })
        .then((response) => response.json())
        .then((res) => {
            $("#form").reset();
            let html='';

            if (res === 1) {
                html =
                    `<div class="alert alert-success">Thêm ${object} thành công<ul>`;
                window.location.href =
                    $("#show_list").getAttribute("href");
            }
            else {
                errorsMap = [];
                res.forEach(element => {
                    if (errorsMap[element.row])
                        errorsMap[element.row].push(element);
                    else 
                        errorsMap[element.row] = [element];
                    
                });
                console.log(errorsMap)
                errorsMap.forEach((e, key) => {
                        html += '<div class="alert alert-danger"><div class="d-flex"> Row: ' + key;
                        html += ErrorHandler(e);
                        html += " </div> </div>";
      
                })
            }
            message.innerHTML = html;
            message.classList.remove('d-none')
        });
    // .catch((e) => console.log(e, "Pls don't dp that"));

}
form.addEventListener("submit", SubmitFormHandler);
function ErrorHandler(e) {
    return `
        ${e.map((one) => `- <div class='error-item'>${one.errors[0]}</div>`).join('')}
   `;
}
