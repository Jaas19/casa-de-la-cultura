const goodAttributes = document.querySelectorAll(".good-attribute");
const inventoryOptions = document.querySelectorAll(".inventory-option")
const goodAttributesInputs = document.querySelectorAll(".good-attribute-input");

function showAttributes(e){
    for(input of goodAttributesInputs){
        input.setAttribute("disabled", "true")
    }
    for(goodAttribute of goodAttributes){
        const inputs = goodAttribute.querySelectorAll('input');
        if(goodAttribute.getAttribute("data-inventory-id") == e.target.value){
            goodAttribute.classList.remove("hidden")
            for(input of inputs){
                input.disabled = false
            }

        } else {
            goodAttribute.classList.add("hidden")
            for(input of inputs){
                input.disabled = true
            }
        }
    }
}

for(inventoryOption of inventoryOptions){
    inventoryOption.addEventListener("click", showAttributes)
}
