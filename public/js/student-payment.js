const studentPaymentSelects = document.querySelectorAll(".studentSelectPayment")
const studentNextPaymentFields = document.querySelectorAll(".student-next-payment-field")

function registerStudentPayment(e){
    button = e.currentTarget;
    button.disabled = true
    const studentId = e.currentTarget.getAttribute("data-student-id")
    const nextPayment = e.currentTarget.value
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
                "next_payment": nextPayment
            }),
        }).then(response => {
            button.disabled = false;
            if(!response.ok) {
                throw new Error("Network response error");
            }
            return response.json();
        })
        .then(data => {
            field = document.querySelector(`.student-next-payment-field[data-student-id="${studentId}"]`)
            if (field && data.data){
                field.innerText = data.data.next_payment;
            }
        }).catch(error => {

            console.error("Error:", error);
            window.alert("Hubo un error al ejecutar la operación.")
        })
        .finally(()=> {
            button.disabled = false;
        })
    }

    for(studentPaymentSelect of studentPaymentSelects) {
        studentPaymentSelect.addEventListener("change", registerStudentPayment)
    }
