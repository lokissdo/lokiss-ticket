var province=document.querySelector("#select_pro")
var district=document.querySelector("#select_dis")
var defaultAddress={
    "province":`<option data-code="null" value="null"> Chọn tỉnh / thành </option>`,
    "district":`<option data-code="null" value="null"> Chọn quận / huyện </option>`,
    "town":`<option data-code="null" value="null">Chọn phường / xã </option>`
}
window.onload=()=>{
    fetch("https://provinces.open-api.vn/api/?depth=3")
    .then(response => response.json())
    .then(res =>{
       // console.log(res);
        data=res
        var html=province.innerHTML;
        for (let i=0;i<data.length;i++){
            html+=` <option data-code="${data[i].code}" value="${i}"> ${data[i].name} </option>`
        }
        province.innerHTML=html;

         // Select districts when province changes
        province.onchange=()=>{
            if(province.value!="null"){
             let html=defaultAddress.district;       
             let temp=data[province.value].districts;
             for (let i=0;i<temp.length;i++){
                 html+=` <option data-code="${data[i].code}" value="${i}"> ${temp[i].name} </option>`
             }
             district.innerHTML=html;
            }
            else  district.innerHTML=defaultAddress.district
        }
    });
}