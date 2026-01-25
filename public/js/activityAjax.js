const detailsBody = document.querySelector("#details-body")

function getDetails(e){


    let activityId = e.target.getAttribute('data-activity-id');
    let header = e.target.getAttribute('data-header');

    let csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        fetch('/activity/getDetails', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
        },
        body: JSON.stringify({
                "id": activityId,
                "header": header,
            }),
        })
        .then(data => data.json())
        .then(data => printAnswer(data, header))
}

function updateStatus(e){

    let csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    let activityId = e.target.parentElement.getAttribute('data-activity-id');
    let status = e.target.innerText;


    fetch('/activity/changeStatus', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken,
        'Accept': 'application/json',
    },
    body: JSON.stringify({
            "_method": "PATCH",
            "id": activityId,
            "status": status,
        }),
    })
    .then(data => data.json())
    .then(data => console.log(data))

}

function printAnswer(data, header){
    detailsBody.innerHTML = "";
    if(header == "Fechas y Horas"){
        for(date of data.dates){
            let section = document.createElement("section");
            section.classList.add("bg-white2", "text-black2", "rounded-2xl", "p-3");
            detailsBody.appendChild(section);

            let header = document.createElement("h4");
            header.classList.add("text-xl", "text-center");
            header.innerHTML = date.date
            section.appendChild(header)

            let list = document.createElement("ul");
            section.appendChild(list)
            let first = true;

            for(hour of data.hours[date.id]){
                console.log(hour)
                if(!first){
                    let br = document.createElement("br")
                    list.appendChild(br);
                } else {
                    first = false
                }
                let startingHour = document.createElement("li");
                startingHour.innerText = "Hora de inicio: " + hour.starting_time;
                let endingHour = document.createElement("li");
                endingHour.innerText = "Hora de fin: " + hour.ending_time;

                list.appendChild(startingHour);
                list.appendChild(endingHour);
            }
        }
    } else if(header == "Bienes") {
            let section = document.createElement("section");
            section.classList.add("bg-white2", "text-black2", "rounded-2xl", "p-3");
            detailsBody.appendChild(section);

            let list = document.createElement("ul");
            section.appendChild(list)

            for (good of data){
                let goodData = document.createElement("li");
                goodData.innerText = good.quantity_requested + " " + good.goodName + getSeparator(good.quantity_requested) + good.inventoryName;
                list.appendChild(goodData);

        }
    } else {
            let section = document.createElement("section");
            section.classList.add("bg-white2", "text-black2", "rounded-2xl", "p-3");
            detailsBody.appendChild(section);

            let list = document.createElement("ul");
            section.appendChild(list)

            for (organizer of data){
                let organizerData = document.createElement("li");
                organizerData.innerText = organizer.name;
                list.appendChild(organizerData);
        }
    }
}

function getSeparator(quantity){
    if (quantity > 1) {
        return "s - "
    } else {
        return " - "
    }
}

for(clickableElement of clickableElements){
    clickableElement.addEventListener('click', getDetails)
}

for(statusSelectOption of statusSelectOptions){
    statusSelectOption.addEventListener('click', updateStatus)
}
