const attributeButton = document.querySelector('#add-attribute');
const loginDiv = document.querySelector("#login-div");
let numberOfAttributes = 0;
attributeButton.addEventListener('click', createAttributeInput)

function createAttributeInput(e){
    numberOfAttributes ++
    let div = document.createElement('div');
    div.classList.add("col-start-1")

    let input = document.createElement('input');
    input.setAttribute("type", "text")
    input.setAttribute("name", `attributes[${numberOfAttributes}][key_name]`)
    input.setAttribute("placeholder", "Introduzca el atributo...")
    input.classList.add("block")

    let label = document.createElement('label');
    label.innerText = "Atributo " + numberOfAttributes

    div.appendChild(label)
    div.appendChild(input)
    loginDiv.insertAdjacentElement("beforeend", div)

    const selectHTML = `
        <div class="col-start-2">
            <label for="">Tipo</label>
            <select name="attributes[${numberOfAttributes}][type]" id="" class="block" required>
                <option value="text">Texto corto/Código</option>
                <option value="paragraph">Párrafo</option>
                <option value="numeric">Númerico</option>
                <option value="boolean">Sí/No</option>
            </select>
        </div>
        `
    loginDiv.insertAdjacentHTML("beforeend", selectHTML)

}
