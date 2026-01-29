const studentStatusSelects = document.querySelectorAll(".studentSelectStatus")

function toggleStudentStatus(e){
    button = e.currentTarget;
    button.disabled = true
    const studentId = e.currentTarget.getAttribute("data-student-id")
    const status = e.currentTarget.value
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    const route = e.currentTarget.getAttribute("data-route")
        fetch(route, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
        },
        body: JSON.stringify({
                "id": studentId,
                "status": status
            }),
        }).then(response => {
            button.disabled = false;
            if(!response.ok) {
                throw new Exception("Network response error");
            }
            return response;
        }).catch(error => {
            button.disabled = false;
            console.error("Error:", error);
            window.alert("Hubo un error al ejecutar la operación.")
        })
    }

    for(studentStatusSelect of studentStatusSelects) {
        studentStatusSelect.addEventListener("change", toggleStudentStatus)
    }
