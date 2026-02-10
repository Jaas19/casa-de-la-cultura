const options = document.querySelectorAll('.option')
const headers = document.querySelectorAll('.inventoryHeader')
const data = document.querySelectorAll('.inventoryData')
const fields = document.querySelectorAll('.dataField')
const goodId = document.querySelector('.bg-yellow-950')

const redirectValues = document.querySelectorAll('.redirect');


const searchGoodInput = document.querySelector('#search-good-input')

function searchResult(){
    let input = searchGoodInput.value.trim().toLowerCase();

    if(!input) {
        for (const row of data) {
            row.classList.remove("hide");
        }
        return
    }

    for(const row of data){
        row.classList.add("hide")
        let matches = false;
        for(const innerData of row.cells){
            if(innerData.innerText.trim().toLowerCase().includes(input)){
                matches = true;
                break;
            }
        }
        if(matches){
            row.classList.remove("hide")
        }
    }
}

function redirect(e){
    redirectForm.action = e.target.value;
    redirectForm.submit();
}


function redirectTo(e){
    if(e.target.value.includes("/") || e.target.value.includes("\\")){
        window.location.href = e.target.value;
    } else {
        showInventoryData(e);
    }

}

const inventoriesSelect =  document.querySelector("#inventories");
inventoriesSelect.addEventListener('change', redirectTo)


for (redirectValue of redirectValues){
    redirectValue.addEventListener('click', redirectTo)
}


function showInventoryData(e){
    for(header of headers){
        const currentHeaderMatches = header.matches("[data-inventory-id=\""+ e.target.value +"\"]")

        if(!currentHeaderMatches){
            header.classList.add('hidden')
        } else {
            header.classList.remove('hidden')
        }
    }

    for(info of data){
        const currentDataMatches = info.matches("[data-inventory-id=\""+ e.target.value +"\"]")
        if(!currentDataMatches){
            info.classList.add('hidden')
        } else {
            info.classList.remove('hidden')
        }
    }
}

function highlightField(e){

    if(e.target.closest('a')){
        return;
    }

    const focus = e.target.closest('tr');

    if (!focus) {
        return;
    }

    if(typeof selected !== 'undefined'){
        selected.classList.remove('bg-yellow-950')
        focus.classList.add('bg-yellow-950')
        selected = document.querySelector('.bg-yellow-950')
        goodIdInput.value = selected.getAttribute("data-good-id")
        inventoryIdInput.value = selected.getAttribute("data-inventory-id")
        // let goodId = selected.getAttribute("data-good-id")
    } else {
        focus.classList.add('bg-yellow-950')
        selected = document.querySelector('.bg-yellow-950')
        // let goodId = selected.getAttribute("data-good-id")
        goodIdInput.value = selected.getAttribute("data-good-id")
        inventoryIdInput.value = selected.getAttribute("data-inventory-id")
    }
}

for(option of options){
    option.addEventListener('click', showInventoryData)
}

for(field of fields){
    field.addEventListener('click', highlightField)
}

searchGoodInput.addEventListener("keyup", searchResult)


