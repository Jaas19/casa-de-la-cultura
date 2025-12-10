const searchPersonInput = document.querySelector('#search-person-input')
const positionSelectInput = document.querySelector('#positions')
const personId = document.querySelector('#personId')
const disciplineId = document.querySelector('#disciplineId')
const personDataField = document.querySelectorAll('.person-data-attribute')
const statusInput = document.querySelector('#statusInput')

const updateForm = document.querySelector('#update-form');
const updateButton = document.querySelector('#update-button');


function submitUpdateForm(){
    if(updateForm.getAttribute("action") === ""){
        return
    } else {
        updateForm.submit();
    }
}

function showPersonsWithMatchingStatus(e){
    const data = document.querySelectorAll('.person-data');
    const value = e.target.value.trim();
    for(const info of data){
        const currentDataMatches = info.matches("[data-status=\""+ value +"\"]")
        if(!currentDataMatches){
            info.classList.add('hide2')
        } else {
            info.classList.remove('hide2')
        }
    }
}

function showPersonsData(e){
    const data = document.querySelectorAll('.person-data')
    if(updateForm.getAttribute("action") !== ""){
        updateForm.setAttribute("action", "")
    }

    const value = e.target.value.trim();

    if(value === ""){
        for(const info of data){
            info.classList.remove('hidden')
        }
        return
    }
    for(const info of data){
        const currentDataMatches = info.matches("[data-position-id=\""+ value +"\"]")
        if(!currentDataMatches){
            info.classList.add('hidden')
        } else {
            info.classList.remove('hidden')
        }
    }
}

function searchResult(){
    const data = document.querySelectorAll('.person-data')
    let input = searchPersonInput.value.trim().toLowerCase();

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

function highlightField(e){
    if(updateForm.getAttribute("action") == ""){
        updateForm.setAttribute("action", "person/update")
    }
    const focus = e.target.parentElement
    if(typeof selected !== 'undefined'){
        selected.classList.remove('bg-yellow-950')
        focus.classList.add('bg-yellow-950')
        selected = document.querySelector('.bg-yellow-950')
        personId.value = selected.getAttribute("data-person-id")
        disciplineId.value = selected.getAttribute("data-discipline-id")
        // let goodId = selected.getAttribute("data-good-id")
    } else {
        focus.classList.add('bg-yellow-950')
        selected = document.querySelector('.bg-yellow-950')
        // let goodId = selected.getAttribute("data-good-id")
        personId.value = selected.getAttribute("data-person-id")
        disciplineId.value = selected.getAttribute("data-discipline-id")
    }
}

searchPersonInput.addEventListener("keyup", searchResult);
positionSelectInput.addEventListener("change", showPersonsData);
updateButton.addEventListener("click", submitUpdateForm)
statusInput.addEventListener("click", showPersonsWithMatchingStatus)


for(field of personDataField){
    field.addEventListener("click", highlightField);
}