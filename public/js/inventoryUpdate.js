const inventorySelect = document.querySelector("#inventory-id-select");
const addAttributeButton = document.querySelector("#add-attribute")

inventorySelect.addEventListener('change', getInventoryAttributes);
addAttributeButton.addEventListener('click', addNewAttribute);

function getInventoryAttributes(e){
    if(!e.target || !e.target.value){
        return
    }
    clearInventoryAttributes();
    const inventoryId = e.target.value;
    const userId = document.querySelector("#user-id-input").value
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        fetch('/inventory/attributes', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept' : 'application/json',
            'X-CSRF-TOKEN': csrfToken,
        },
        body: JSON.stringify({
                "inventory_id": inventoryId,
                "user_id": userId,
            }),
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la red');
            }
            return response.json();
        })
        .then(data => {
            printAttributes(data);
        })
        .catch(error =>  console.error('Error:', error));
}

function clearInventoryAttributes(){
    const inventoryAttributes = document.querySelectorAll(".inventory-attribute-element");
    for(const inventoryAttribute of inventoryAttributes){
        inventoryAttribute.remove();
    }
}

function printAttributes(data){
    console.log(data);
    const container = document.querySelector('#form-div')
    let attributeCount = 0;
    for(attribute of data){
        attributeCount ++;
        const html = `
        <input class="inventory-attribute-element" type="hidden" name="attributes[${attributeCount}][id]" value="${attribute.id}">

        <div class="col-span-2 inventory-attribute-element">
            <h1 class="text-white2 font-black text-center border-b pb-2 my-8 text-xl">Atributo N°${attributeCount}</h1>
        </div>
        <div class="inventory-attribute-element">
            <label for="">Atributo</label>
            <input type="text" class="block" placeholder="Introduzca el nombre..." value="${attribute.key_name}"
            name="attributes[${attributeCount}][key_name]" required>
        </div>
        <div class="inventory-attribute-element">
            <label for="">Tipo</label>
            <select name="attributes[${attributeCount}][type]" id="" class="block" required>
                <option value="text" ${attribute.type == "text" ?? "selected"}>Texto corto/Código</option>
                <option value="paragraph" ${attribute.type == "paragraph" ?? "selected"}>Párrafo</option>
                <option value="numeric" ${attribute.type == "numeric" ?? "selected"}>Númerico</option>
                <option value="boolean" ${attribute.type == "boolean" ?? "selected"}>Sí/No</option>
            </select>
        </div>
        `
        container.insertAdjacentHTML('beforeend', html)
    }
    container.setAttribute("data-attribute-count", attributeCount)
}

function addNewAttribute(data){
    const container = document.querySelector('#form-div')
    attributeCount = container.getAttribute("data-attribute-count")
    attributeCount ++
    container.setAttribute("data-attribute-count", attributeCount)
    const html = `

        <div class="col-span-2 inventory-attribute-element">
            <h1 class="text-white2 font-black text-center border-b pb-2 my-8 text-xl">Atributo N°${attributeCount}</h1>
        </div>
        <div class="inventory-attribute-element">
            <label for="">Atributo</label>
            <input type="text" class="block" placeholder="Introduzca el nombre..." name="attributes[${attributeCount}][key_name]" required>
        </div>
        <div class="inventory-attribute-element">
            <label for="">Tipo</label>
            <select name="attributes[${attributeCount}][type]" id="" class="block" required>
                <option value="text">Texto corto/Código</option>
                <option value="paragraph">Párrafo</option>
                <option value="numeric">Númerico</option>
                <option value="boolean">Sí/No</option>
            </select>
        </div>
        `
    container.insertAdjacentHTML('beforeend', html)
}
