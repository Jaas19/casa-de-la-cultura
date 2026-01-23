const modalHeader = document.querySelector("#modalHeader")
const calendar = document.querySelector("#calendar");
const calendarDays = document.querySelectorAll(".calendar-day");
const dateInput = document.querySelector("#date-input");
const activitiesContainer = document.querySelector("#activitiesContainer")
const notificationContainer = document.querySelector("#notificationsContainer")
const leftButton = document.querySelector("#left-button")
const rightButton = document.querySelector("#right-button")


leftButton.addEventListener('click', moveNotificationsRight);
rightButton.addEventListener('click', moveNotificationsLeft);

const dayActivitiesModal = document.querySelector("#dayActivitiesModal");
const containerShadow = document.querySelector("#containerShadow");

    const colors1 = {
        "Suspendida": "red-500",
        "Activa": "purple-400",
        "En Espera": "orange-400",
        "Completada": "lime-400",
        "Pospuesta": "yellow-400",
        "En Progreso": "cyan-400",
    };
    const colors2 = {
        "Suspendida": "red-300",
        "Activa": "purple-200",
        "En Espera": "orange-200",
        "Completada": "lime-200",
        "Pospuesta": "yellow-100",
        "En Progreso": "cyan-200",
    };


function loadActivities(e){
    let date

    let csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    if(e.type == 'change' && e.target.value){
        date = new Date(e.target.value + 'T00:00:00');
    }
    else {
        date = new Date;
    }
    fetch('/activity/calendar', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
        },
        body: JSON.stringify({
                "date": date,
            }),
        }).then(response => {
            if (!response.ok){
                throw new Error('Hubo un error en el servidor: ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            calendar.setAttribute("data-current-month", data.month);
            calendar.setAttribute("data-current-year",  data.year);
            fillDays(data.activities, date)

            if(dateInput){
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                dateInput.value = `${year}-${month}-${day}`;
            }
        })
        .catch(error => console.error("Error cargando calendario: ", error));
}

function fillDays(activities, currentDay){
    const firstDate = new Date(currentDay.getFullYear(), currentDay.getMonth(), 1)
    const lastDate = new Date(currentDay.getFullYear(), currentDay.getMonth() + 1, 0)
    const firstDay = firstDate.getDay();
    const lastDay = lastDate.getDate();

    let dateCount = 0 - firstDay;
    let dayCount = 0;
    for(const day of calendarDays){
        day.innerHTML = "";
        day.parentElement.classList.remove("bg-gray-400", "bg-white2", 'cursor-pointer', 'hover:bg-gray-200');
        day.parentElement.removeAttribute("data-day");
        day.parentElement.removeEventListener("click", showWindow);

        if(dateCount < 0){
            day.parentElement.classList.add("bg-gray-400")
            dateCount ++
            continue
        }

        dayCount ++
        if (dayCount > lastDay){
            day.parentElement.classList.add("bg-gray-400")
            continue
        }
        day.parentElement.classList.add("bg-white2")
        day.setAttribute("data-day", dayCount)

        const dayNumber = document.createElement("span");
        dayNumber.innerText = dayCount;
        dayNumber.classList.add("text-gray-800", "font-bold", "text-left")
        day.appendChild(dayNumber);

        const date = day.getAttribute("data-day").toString();
        if(!activities[date]){
            continue
        }

        day.parentElement.addEventListener('click', showWindow)
        day.parentElement.classList.add('cursor-pointer', 'hover:bg-gray-200')
        const activityFlex = document.createElement("div")
        activityFlex.classList.add('flex', 'gap-1', 'flex-wrap', 'content-start')
        for(const activity of activities[date]){
            const activityDiv = document.createElement("div");
            const color = colors1[activity.status]
            activityDiv.classList.add(`bg-${color}`, "rounded-full", "h-2", "w-2")
            activityDiv.setAttribute("data-name", activity.name)
            activityDiv.setAttribute("data-color", color)


            if(activity.time_array){
                activityDiv.setAttribute("data-hours", JSON.stringify(activity.hours))
                activityDiv.setAttribute("data-has-many-hours", "true")
            } else {
                activityDiv.setAttribute("data-has-many-hours", "false")
            }
                activityDiv.setAttribute("data-starting-hour", activity.starting_time)
                activityDiv.setAttribute("data-ending-hour", activity.ending_time)
            activityFlex.appendChild(activityDiv);
        }
        day.appendChild(activityFlex)
    }
}


function moveNotificationsLeft(){
    let newPosition;
    const currentPosition = parseInt(notificationContainer.getAttribute("data-position"));
    if(currentPosition <= -4032 || currentPosition > 0){
        newPosition = 0
    } else {
        newPosition = currentPosition - 576;
    }
    notificationContainer.style.transform = `translateX(${newPosition}px)`
    notificationContainer.setAttribute("data-position", newPosition);
}

function moveNotificationsRight(){
    let newPosition;
    const currentPosition = parseInt(notificationContainer.getAttribute("data-position"));
    if(currentPosition >= 0 || currentPosition < -4032){
        newPosition = -4032;
    } else {
        newPosition = currentPosition + 576;
    }
    notificationContainer.style.transform = `translateX(${newPosition}px)`
    notificationContainer.setAttribute("data-position", newPosition);
}

window.moveNotificationsLeft = moveNotificationsLeft;
window.moveNotificationsRight = moveNotificationsRight;

function showWindow(e){
    modalHeader.innerText = `${e.currentTarget.firstElementChild.getAttribute("data-day")} de ${calendar.getAttribute('data-current-month')} de ${calendar.getAttribute('data-current-year')}`
    activitiesContainer.innerHTML = ""
    const activities = e.currentTarget.firstElementChild.lastElementChild;
    for (activity of activities.children){
        const section = document.createElement("section");
        section.className = `min-h-20 p-3 bg-white flex flex-col justify-start border-b-4 border-${activity.getAttribute("data-color")}`
        const header = document.createElement("h4")
        header.innerText = activity.getAttribute("data-name")


        const list = document.createElement("ul")
        section.appendChild(header);
        section.appendChild(list)

        if(activity.getAttribute("data-has-many-hours") == "true"){
            for(hour of JSON.parse(activity.getAttribute("data-hours"))){
                const listHour = document.createElement("li")
                listHour.innerText = `${hour.starting_time} - ${hour.ending_time}`
                list.appendChild(listHour)
            }} else {
                const listHour = document.createElement("li")
                const startingHour = activity.getAttribute("data-starting-hour");
                const endingHour = activity.getAttribute("data-ending-hour");
                listHour.innerText = `${startingHour} - ${endingHour}`
                list.appendChild(listHour)
            }

        activitiesContainer.appendChild(section)
        }


    dayActivitiesModal.classList.remove("hide");
    containerShadow.classList.remove("hide");
    containerShadow.classList.remove("opacity-0")
    containerShadow.classList.add("opacity-25")
}

function hideWindow(e){
    if(e && e.target !== containerShadow && e.target !== dayActivitiesModal) return;
    activitiesContainer.innerHTML = ""
    dayActivitiesModal.classList.add("hide");
    containerShadow.classList.add("hide");
    containerShadow.classList.add("opacity-0")
    containerShadow.classList.remove("opacity-25")
}

window.addEventListener('DOMContentLoaded', loadActivities)
dateInput.addEventListener('change', loadActivities)
dayActivitiesModal.addEventListener("click", hideWindow)
containerShadow.addEventListener("click", hideWindow)

calendar.getAttribute("data-current-month")
calendar.getAttribute("data-current-year")
