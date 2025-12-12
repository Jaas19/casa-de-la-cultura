const loanStatusSelects = document.querySelectorAll(".loanSelectStatus")

function toggleLoanStatus(e){
    e.target.disabled = true
    const loanId = e.target.getAttribute("data-loan-id")
    const status = e.target.value
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        fetch('loan/patch', {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
        },
        body: JSON.stringify({
                "id": loanId,
                "status": status
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

    for(loanStatusSelect of loanStatusSelects) {
        loanStatusSelect.addEventListener("change", toggleLoanStatus)
    }
