var province=document.querySelector("#select_pro")
var district=document.querySelector("#select_dis")
var defaultAddress={
    "province":`<option data-code="null" value="null"> Chọn tỉnh / thành </option>`,
    "district":`<option data-code="null" value="null"> Chọn quận / huyện </option>`,
    "town":`<option data-code="null" value="null">Chọn phường / xã </option>`
}
window.onload=()=>{
    fetch("/api/addresses")
    .then(response => response.json())
    .then(data =>{
        var html=province.innerHTML;
        for (let i=0;i<data.length;i++){
            html+=` <option data-code="${data[i].code}" value="${data[i].code}"> ${data[i].name} </option>`
        }
        province.innerHTML=html;

         // Select districts when province changes
        province.onchange=()=>{
            if(province.value!="null"){
             let html=defaultAddress.district;       
            const temp = data.find(element => element.code===province.value).districts;
             for (let i=0;i<temp.length;i++){
                 html+=` <option data-code="${data[i].code}" value="${data[i].code}"> ${temp[i].name} </option>`
             }
             district.innerHTML=html;
            }
            else  district.innerHTML=defaultAddress.district
        }
    });
}
