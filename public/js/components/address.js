var province=document.querySelector("#select_pro")
var data;
var defaultAddress={
    "province":`<option data-code="null" value="null"> Chọn tỉnh / thành </option>`,
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
    });
}