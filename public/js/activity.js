const detailsWindow = document.querySelector('.details-window');
const detailsHeader = document.querySelector('.details-header');
const clickableElements = document.querySelectorAll('.clickable-element');
const filterActivitySelect = document.querySelector('#filter-activity-select');
const filterActivityOptions = document.querySelectorAll('.filter-activity-option');
const activities = document.querySelectorAll('.activity-card')
/*
const startingDates = document.querySelectorAll(".starting-date");
const endingDates = document.querySelectorAll(".ending-date");
*/

const statusSelectInputs = document.querySelectorAll('.status-select-input');
const statusSelectOptions = document.querySelectorAll('.status-select-option');
/*
function filterActivity(e){
    filter = e.target.value;
    if (filter == "Todas") {
        for(activity of activities){
            activity.classList.remove("hidden")
        }
    } else {
        for(activity of activities){
            if(filter == activity.getAttribute("data-status")){
                activity.classList.remove("hidden")
            } else {
                activity.classList.add("hidden")
            }
        }
    }
}
*/
function hide(){
    detailsWindow.classList.add("opacity-0")
    setTimeout(detailsWindow.classList.add('hidden'), 300)
}

function showDetails(e){
    detailsWindow.classList.remove('hidden');
    detailsWindow.classList.add('flex');
    detailsHeader.innerText =  e.target.getAttribute('data-header');
    detailsWindow.classList.remove("opacity-0");
}

function updateActivityDate(starting_date, ending_date, activityId){
    let startingDate = document.querySelector(`[data-activity-id="${activityId}"].starting-date`);
    let endingDate = document.querySelector(`[data-activity-id="${activityId}"].ending-date`);
    startingDate.innerText = `Fecha de inicio: ${starting_date}`;
    endingDate.innerText = `Fecha de fin: ${ending_date}`;
}

function updateColor(e){

    let select = e.target.parentElement;
    let option = e.target;
    let activityBox = document.querySelector(`[data-header-id="${select.getAttribute("data-activity-id")}"]`);

    let oldColor = select.getAttribute('data-color')
    let oldColor2 = activityBox.getAttribute('data-color')
    let newColor = option.getAttribute('data-color')
    let newColor2 = option.getAttribute('data-color2')

    if(oldColor === newColor && oldColor2 === newColor2){
        return;
    }

    activityBox.classList.remove("from-"+oldColor.replace("text-", ""));
    activityBox.classList.remove("to-"+oldColor2.replace("text-", ""));
    activityBox.classList.add("from-"+newColor.replace("text-", ""));
    activityBox.classList.add("to-"+newColor2.replace("text-", ""));

    activityBox.setAttribute('data-color', newColor2)


    select.classList.add(option.getAttribute('data-color'));
    select.classList.remove(select.getAttribute('data-color'));
    select.setAttribute('data-color', option.getAttribute('data-color'));
}

detailsWindow.addEventListener('click', hide);

/*
for(const filterActivityOption of filterActivityOptions){
    filterActivityOption.addEventListener('click', filterActivity);
}*/


for(clickableElement of clickableElements){
    clickableElement.addEventListener('click', showDetails);
}

// filterActivitySelect.addEventListener('change', filterActivity);

for(statusSelectOption of statusSelectOptions){
    statusSelectOption.addEventListener('click', updateColor);
    if(statusSelectOption.getAttribute('data-color') == statusSelectOption.parentElement.getAttribute('data-color')){
        statusSelectOption.setAttribute('selected', 'true')
    }
}


