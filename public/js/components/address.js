var provinces=document.querySelectorAll("#select_pro")
var data;
const GetAddressByFetchAPI= ()=>{
    fetch("/api/addresses")
    .then(response => response.json())
    .then(res =>{
        data=res
        provinces.forEach((province,index)=>{
            var html=province.innerHTML;
            for (let i=0;i<data.length;i++){     
               html+=` <option ${(typeof preAddressCode)!=='undefined' && preAddressCode[index]==data[i].code ?'selected':''} data-code="${data[i].code}" value="${data[i].code}"> ${data[i].name} </option>`
            }
            province.innerHTML=html;
        })
        if(typeof ProvinceChangeListenter !=='undefined') ProvinceChangeListenter()
    });
}
window.addEventListener('load',GetAddressByFetchAPI)
