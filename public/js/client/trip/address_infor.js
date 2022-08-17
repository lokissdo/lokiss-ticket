var province=document.querySelector("[name=province_ticketinfor]")
var district=document.querySelector("[name=district_ticketinfor]")
var defaultAddress={
    "district":`<option data-code="null" value="null"> Chọn quận / huyện </option>`,
}
window.addEventListener('load',()=>{
    // Select districts when province changes
   province.addEventListener('change',ProvinceChangeListenter)
})
if(ProvinceChangeListenter) console.log(ProvinceChangeListenter)
function ProvinceChangeListenter(){
    console.log(province.value,data)
    if(province.value!="null"){
        let html=defaultAddress.district;       
       const temp = data.find(element => element.code==province.value).districts;
        for (let i=0;i<temp.length;i++)
           html+=` <option ${(typeof preAddress2Code)!=='undefined' && preAddress2Code==temp[i].code ?'selected':''} data-code="${temp[i].code}" value="${temp[i].code}"> ${temp[i].name} </option>`
        district.innerHTML=html;
       }
       else  district.innerHTML=defaultAddress.district
}