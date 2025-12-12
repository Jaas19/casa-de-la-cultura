const inventorySelect = document.querySelector('#inventory')
const goodOptions = document.querySelectorAll('.goodOptions')
const goodSelect = document.querySelector('#good')


function showGoods(e){
    goodSelect.selectedIndex = 0
    let inventoryId = e.target.value;
    for(goodOption of goodOptions){
        if(!(goodOption.getAttribute("data-inventory-id") == inventoryId)){
            goodOption.classList.add("hidden")
            goodOption.disabled = true;
        } else {
            goodOption.classList.remove("hidden")
            goodOption.disabled = false;
        }

    }
}

inventorySelect.addEventListener('change', showGoods)

