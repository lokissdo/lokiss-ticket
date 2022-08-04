var provinces=document.querySelectorAll("#select_pro")
var data;
var defaultAddress={
    "province":`<option data-code="null" value="null"> Chọn tỉnh / thành </option>`,
}


const GetAddressByFetchAPI=()=>{
    fetch("/api/addresses")
    .then(response => response.json())
    .then(res =>{
        data=res;
        provinces.forEach(province=>{
            var html=province.innerHTML;
            for (let i=0;i<data.length;i++){     
               html+=` <option ${(typeof preAddressCode)!=='undefined' && preAddressCode==data[i].code ?'selected':''} data-code="${data[i].code}" value="${data[i].code}"> ${data[i].name} </option>`
            }
            province.innerHTML=html;
        })
        
    });
}
window.addEventListener('load',GetAddressByFetchAPI)
