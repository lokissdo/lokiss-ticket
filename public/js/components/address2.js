var province=document.querySelector("#select_pro")
var district=document.querySelector("#select_dis")
var data;
var defaultAddress={
    "province":`<option data-code="null" value="null"> Chọn tỉnh / thành phố</option>`,
    "district":`<option data-code="null" value="null"> Chọn quận / huyện </option>`,
    "town":`<option data-code="null" value="null">Chọn phường / xã </option>`
}
window.onload=()=>{
    fetch("/api/addresses")
    .then(response => response.json())
    .then(res =>{
        data=res;
        var html=province.innerHTML;
        for (let i=0;i<data.length;i++){     
            html+=` <option ${(typeof preAddressCode)!=='undefined' && preAddressCode==data[i].code ?'selected':''} data-code="${data[i].code}" value="${data[i].code}"> ${data[i].name} </option>`
        }
        province.innerHTML=html;
        ProvinceChangeListenter();
         // Select districts when province changes
        province.addEventListener('change',ProvinceChangeListenter)
    });
}

function ProvinceChangeListenter(){
    console.log(province.value)
    if(province.value!="null"){
        let html=defaultAddress.district;       
       const temp = data.find(element => element.code===province.value).districts;
        for (let i=0;i<temp.length;i++)
           html+=` <option ${(typeof preAddress2Code)!=='undefined' && preAddress2Code==temp[i].code ?'selected':''} data-code="${temp[i].code}" value="${temp[i].code}"> ${temp[i].name} </option>`
        district.innerHTML=html;
       }
       else  district.innerHTML=defaultAddress.district
}