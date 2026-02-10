const goodAttributes = document.querySelectorAll(".good-attribute");
const inventoryOptions = document.querySelectorAll(".inventory-option")
const goodAttributesInputs = document.querySelectorAll(".good-attribute-input");
const inventorySelect = document.querySelector("#inventory");

document.addEventListener('DOMContentLoaded', showAttributes);

function showAttributes(e){
    for(input of goodAttributesInputs){
        input.setAttribute("disabled", "true")
    }
    for(goodAttribute of goodAttributes){
        const inputs = goodAttribute.querySelectorAll('input');
        if(goodAttribute.getAttribute("data-inventory-id") == inventorySelect.value){
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

inventorySelect.addEventListener("change", showAttributes)
