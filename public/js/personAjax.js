const suspendButton = document.querySelector("#suspend-button")
const statusCheckboxes = document.querySelectorAll(".person-assistance-status")

suspendButton.addEventListener("click", toggleUserStatus);

for(const statusCheckbox of statusCheckboxes){
    statusCheckbox.addEventListener('change', toggleAssistanceStatus);
}

function toggleUserStatus(e){
    if(typeof selected !== 'undefined'){
        suspendButton.disabled = true;
        let personId = selected.getAttribute("data-person-id");
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            fetch('/person/put', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: JSON.stringify({
                    "id": personId,
                }),
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error("Network response error");
                }
                return response.json();
            })
            .then(data => {
                suspendButton.disabled = false;
                if (data.success) {
                    selected.setAttribute("data-status", data.status)
                    selected.classList.add("hide2")
                }
            }).catch(error => {
                suspendButton.disabled = false;
                console.error("Error:", error);
                window.alert("Hubo un error al ejecutar la operación.")
            })
    } else {
        window.alert("Por favor, elija una persona.")
    }
}

function toggleAssistanceStatus(e){
    e.target.disabled = true
    const personId = e.target.parentElement.parentElement.getAttribute("data-person-id")
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        fetch('/person/put2', {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
        },
        body: JSON.stringify({
                "id": personId,
            }),
        }).then(response => {
            e.target.disabled = false;
            if(!response.ok) {
                throw new Exception("Network response error");
            }
            return response;
        }).catch(error => {
            e.target.disabled = false;
            console.error("Error:", error);
            window.alert("Hubo un error al ejecutar la operación.")
        })
    }




/*
function toggleAssistanceStatus(e){
    e.target.disabled = true
    const personId = e.target.parentElement.parentElement.getAttribute("data-person-id")
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        fetch('/person/put2', {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
        },
        body: JSON.stringify({
                "id": personId,
            }),
        }).catch(error => {
            console.error(error);
            window.alert("Hubo un error al ejecutar la operación.")
        }).then(e.target.disabled = false)
}*/
