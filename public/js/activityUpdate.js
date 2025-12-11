const updateNewDateButton = document.querySelectorAll(".new-hour-update-button")

for (button of updateNewDateButton){
    button.addEventListener("click", newInput)
}
function newInput(e){
    let div1 = document.createElement('div');
    div1.classList.add("col-start-1");

    let label1 = document.createElement('label');
    label1.innerText = "Hora de inicio";

    let input1 = document.createElement('input');
    input1.setAttribute('type', 'time');
    input1.setAttribute('name', `date[${e.target.getAttribute('data-date-id')}][starting_time][]`);
    input1.setAttribute('placeholder', 'Introduzca la hora...');
    input1.classList.add('block');
    
    div1.appendChild(label1);
    div1.appendChild(input1);


    let div2 = document.createElement('div');

    let label2 = document.createElement('label');
    label2.innerText = "Hora de fin";

    let input2 = document.createElement('input');
    input2.setAttribute('type', 'time');
    input2.setAttribute('name', `date[${e.target.getAttribute('data-date-id')}][ending_time][]`);
    input2.setAttribute('placeholder', 'Introduzca la hora...');
    input2.classList.add('block');
    
    div2.appendChild(label2);
    div2.appendChild(input2);
    activityFormDiv.insertBefore(div1, e.target);
    activityFormDiv.insertBefore(div2, e.target);
}