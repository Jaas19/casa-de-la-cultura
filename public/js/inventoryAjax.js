const goodIdInput = document.querySelector('#goodId')
const inventoryIdInput = document.querySelector('#inventoryId')
const userIdInput = document.querySelector('#userId')
const quantityInput = document.querySelector('#quantity')



const suspendButton = document.querySelector('#suspend-button')
const registerButton = document.querySelector('#register-button')
const depositButton = document.querySelector('#deposit-button')
const retireButton = document.querySelector('#retire-button')

/*
fetch('/good/create').then(
    (response) => {
        return response.json()
    }
).then((data) =>{
    console.log(data)
}
)
*/


function registerMovement(e){
    
    let buttonType = e.target.getAttribute('id')
    if(buttonType == "deposit-button") {
        let movementType = "deposit"
        execute(e, movementType)
    } else if (buttonType == "retire-button") {
        let movementType = "retire"
        execute(e, movementType)
    } else {
        return
    }

    
}

function execute(e, movementType){
    if(goodIdInput.value == 0 || inventoryIdInput.value == 0 || quantityInput.value < 1){
        return alert("Error en la operación.")
    }
    let goodId = goodIdInput.value
    let inventoryId = inventoryIdInput.value
    let userId = userIdInput.value
    let quantity = quantityInput.value
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        fetch('/movement/create', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
        },
        body: JSON.stringify({
                "type": movementType,
                "good_id": goodId,
                "inventory_id": inventoryId,
                "user_id": userId,
                "quantity": quantity
            }),
        })
        .then(data => data.json())
        .then(data => getAnswer(data), quantityInput.value="")
}

function getAnswer(data){
    if(data.id){
        alert("Éxito en la operación.")
        changeQuantity(data)
    } else if(typeof data.error !== undefined) {
        alert(data.error)
    } else {
        alert("Error en la operación.")
    }
}
function changeQuantity(data){
    selected.children[3].innerText = data.newValue
}

function suspendMovement(e){
    let goodId = goodIdInput.value;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    fetch('/good/patch', {
    method: 'PATCH',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken,
    },
    body: JSON.stringify({
            "status": "inactive",
            "id": goodId,
        }),
    })
    .then(data => data.json())
    .then(data => console.log(data))
}


suspendButton.addEventListener('click', suspendMovement)
depositButton.addEventListener('click', registerMovement)
retireButton.addEventListener('click', registerMovement)
