const attributeButton = document.querySelector('#add-attribute');
const loginDiv = document.querySelector("#login-div");
let numberOfAttributes = 0;
attributeButton.addEventListener('click', createAttributeInput)

function createAttributeInput(e){
    let div = document.createElement('div');
    div.classList.add("col-start-2")
    
    let input = document.createElement('input');
    input.setAttribute("type", "text")
    input.setAttribute("name", "key_name[]")
    input.setAttribute("placeholder", "Introduzca el atributo...")
    input.classList.add("block")

    let label = document.createElement('label');
    if(numberOfAttributes == 0){
        label.innerText = "Atributo 2"
        numberOfAttributes = 2
    } else {
        numberOfAttributes ++
        label.innerText = "Atributo " + numberOfAttributes
    }
    
    div.appendChild(label)
    div.appendChild(input)
    loginDiv.insertBefore(div, attributeButton.parentElement)
}