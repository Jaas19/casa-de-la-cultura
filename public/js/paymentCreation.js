const nameInput = document.querySelector("#name")
const lastnameInput = document.querySelector("#lastname")
const dniInput = document.querySelector("#dni")

dniInput.addEventListener("input", getPersonData)


function getPersonData(e){
    nameInput.value = "";
    lastnameInput.value = "";
    const dniInput = e.target
    const route = document.querySelector("#route").value
    const dni = dniInput.value
    if(dni.length < 5){
        return
    }
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        fetch(route, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
        },
        body: JSON.stringify({
                "dni": dni,
            }),
        }).then(response => {
            if(!response.ok) {
                throw new Error("Network response error");
            }
            return response.json();
        })
        .then(data => {
        nameInput.value = data.name
        lastnameInput.value = data.lastname
        })
        .catch(error => {
            console.error("Error:", error);
            nameInput.value = "Estudiante no encontrado."
            lastnameInput.value = "Estudiante no encontrado."
        })
    }
