document.addEventListener('DOMContentLoaded', () => {
    const modalHeader = document.querySelector("#modalHeader");
    const calendar = document.querySelector("#calendar");
    const calendarDays = document.querySelectorAll(".calendar-day");
    const dateInput = document.querySelector("#date-input");
    const activitiesContainer = document.querySelector("#activitiesContainer");
    const dayActivitiesModal = document.querySelector("#dayActivitiesModal");
    const containerShadow = document.querySelector("#containerShadow");

    const colors1 = {
        "0": "red-500",
        "1": "lime-400",
    };

    function loadLessons(e) {
        let date;
        const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
        const csrfToken = csrfTokenMeta ? csrfTokenMeta.content : '';
        const disciplineId = calendar.getAttribute('data-discipline-id');
        if (!disciplineId) {
            console.error("No se encontró el ID de la disciplina (data-discipline-id) en la tabla #calendar");
            return;
        }

        if (e && e.type === 'change' && e.target.value) {
            date = new Date(e.target.value + 'T00:00:00');
        } else {
            date = new Date();
        }

        fetch('/lesson/calendar', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: JSON.stringify({
                "date": date,
                "discipline_id": disciplineId
            }),
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Hubo un error en el servidor: ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            calendar.setAttribute("data-current-month", data.month);
            calendar.setAttribute("data-current-year", data.year);
            fillDays(data.activities, date);

            if (dateInput) {
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                dateInput.value = `${year}-${month}-${day}`;
            }
        })
        .catch(error => console.error("Error cargando calendario: ", error));
    }

    function fillDays(activities, currentDay) {
        const firstDate = new Date(currentDay.getFullYear(), currentDay.getMonth(), 1);
        const lastDate = new Date(currentDay.getFullYear(), currentDay.getMonth() + 1, 0);
        const firstDay = firstDate.getDay();
        const lastDay = lastDate.getDate();

        let dateCount = 0 - firstDay;
        let dayCount = 0;

        for (const day of calendarDays) {
            day.innerHTML = "";
            const parentTd = day.parentElement;

            parentTd.classList.remove("bg-gray-400", "bg-white2", 'cursor-pointer', 'hover:bg-gray-200');
            parentTd.removeAttribute("data-day");
            parentTd.removeEventListener("click", showWindow);

            if (dateCount < 0) {
                parentTd.classList.add("bg-gray-400");
                dateCount++;
                continue;
            }

            dayCount++;
            if (dayCount > lastDay) {
                parentTd.classList.add("bg-gray-400");
                continue;
            }

            parentTd.classList.add("bg-white2");
            parentTd.setAttribute("data-day", dayCount);

            const dayNumber = document.createElement("span");
            dayNumber.innerText = dayCount;
            dayNumber.classList.add("text-gray-800", "font-bold", "text-left");
            day.appendChild(dayNumber);

            const dateStr = dayCount.toString();
            if (!activities[dateStr]) {
                continue;
            }

            parentTd.addEventListener('click', showWindow);
            parentTd.classList.add('cursor-pointer', 'hover:bg-gray-200');
            const activityFlex = document.createElement("div");
            activityFlex.classList.add('flex', 'gap-1', 'flex-wrap', 'content-start', 'mt-1');

            for (const activity of activities[dateStr]) {
                const activityDiv = document.createElement("div");
                const color = colors1[activity.status] || 'gray-400';

                activityDiv.classList.add(`bg-${color}`, "rounded-full", "h-2", "w-2");
                activityDiv.setAttribute("data-name", activity.name);
                activityDiv.setAttribute("data-color", color);

                if (activity.time_array) {
                    activityDiv.setAttribute("data-hours", JSON.stringify(activity.hours));
                    activityDiv.setAttribute("data-has-many-hours", "true");
                } else {
                    activityDiv.setAttribute("data-has-many-hours", "false");
                }

                activityDiv.setAttribute("data-starting-hour", activity.starting_time);
                activityDiv.setAttribute("data-ending-hour", activity.ending_time);

                activityFlex.appendChild(activityDiv);
            }
            day.appendChild(activityFlex);
        }
    }

    function showWindow(e) {
        const targetDayDiv = e.currentTarget.querySelector('.calendar-day');
        if (!targetDayDiv) return;

        const dayNum = e.currentTarget.getAttribute("data-day");
        const monthName = calendar.getAttribute('data-current-month');
        const yearNum = calendar.getAttribute('data-current-year');

        modalHeader.innerText = `${dayNum} de ${monthName} de ${yearNum}`;
        activitiesContainer.innerHTML = "";

        const activitiesFlex = targetDayDiv.lastElementChild;

        if (activitiesFlex && activitiesFlex.tagName === 'DIV') {
            for (const activityDot of activitiesFlex.children) {
                const section = document.createElement("section");
                const color = activityDot.getAttribute("data-color");

                section.className = `min-h-20 p-3 bg-white flex flex-col justify-start border-b-4 border-${color} rounded shadow-sm mb-2`;

                const header = document.createElement("h4");
                header.classList.add("font-bold", "text-lg", "text-gray-800");
                header.innerText = activityDot.getAttribute("data-name");

                const list = document.createElement("ul");
                list.classList.add("text-gray-600", "mt-1");

                section.appendChild(header);
                section.appendChild(list);

                if (activityDot.getAttribute("data-has-many-hours") === "true") {
                    const hours = JSON.parse(activityDot.getAttribute("data-hours"));
                    for (const hour of hours) {
                        const listHour = document.createElement("li");
                        listHour.innerText = `${hour.starting_time} - ${hour.ending_time}`;
                        list.appendChild(listHour);
                    }
                } else {
                    const listHour = document.createElement("li");
                    const start = activityDot.getAttribute("data-starting-hour");
                    const end = activityDot.getAttribute("data-ending-hour");
                    listHour.innerText = `${start} - ${end}`;
                    list.appendChild(listHour);
                }

                activitiesContainer.appendChild(section);
            }
        }

        dayActivitiesModal.classList.remove("hide");
        containerShadow.classList.remove("hide");
        containerShadow.classList.remove("opacity-0");
        containerShadow.classList.add("opacity-25");
    }

    function hideWindow(e) {
        if (e && e.target !== containerShadow && e.target !== dayActivitiesModal) return;

        activitiesContainer.innerHTML = "";
        dayActivitiesModal.classList.add("hide");
        containerShadow.classList.add("hide");
        containerShadow.classList.add("opacity-0");
        containerShadow.classList.remove("opacity-25");
    }

    loadLessons();

    if (dateInput) {
        dateInput.addEventListener('change', loadLessons);
    }

    if (containerShadow) {
        containerShadow.addEventListener("click", hideWindow);
    }

    if (dayActivitiesModal) {
        dayActivitiesModal.addEventListener("click", hideWindow);
    }
});
