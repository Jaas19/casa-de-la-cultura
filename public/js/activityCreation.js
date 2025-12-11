const dateButton = document.querySelector('#add-date');
const goodButton = document.querySelector('#add-good');
const organizerButton = document.querySelector('#add-organizer');

const datesDiv = document.querySelector('#dates-div')
const goodsDiv = document.querySelector('#goods-div')
const organizerDiv = document.querySelector('#organizer-div')

const hourButtons = document.querySelectorAll('.hour-button');

const selectableOptions = document.querySelectorAll('.selectable-good-option')

for(let selectableOption of selectableOptions){
    selectableOption.addEventListener("click", changeInventorySelectInnerText)
    if(selectableOption.hasAttribute("selected")){
        selectableOption.dispatchEvent(new Event("click"));
    }
}

for(let hourButton of hourButtons){
    hourButton.addEventListener('click', newHour);
}

const activityFormDiv = document.querySelector("#activity-form-div")
const goodsArrays = Object.values(goods);
const inventoriesArrays = Object.values(inventories);

dateButton.addEventListener('click', newDate);
goodButton.addEventListener('click', newGood);
organizerButton.addEventListener('click', newOrganizer);

let dateAmount = 1;
const datesCount = document.querySelector("#number-of-dates")
if(datesCount){
    dateAmount = parseInt(datesCount.getAttribute("data-date-count")); 
}

let organizerAmount = 0;
const organizerCount = document.querySelector("#number-of-organizers")
if(organizerCount){
    organizerAmount = parseInt(organizerCount.getAttribute("data-organizer-count")); 
}

let goodAmount = 0;
const goodCount = document.querySelector("#number-of-goods")
if(goodCount){
    goodAmount = parseInt(goodCount.getAttribute("data-good-count")); 
}

function newHour(e){
    let div1 = document.createElement('div');
    div1.classList.add("col-start-1");

    let label1 = document.createElement('label');
    label1.innerText = "Hora de inicio";

    let input1 = document.createElement('input');
    input1.setAttribute('type', 'time');
    input1.setAttribute('name', `date[${e.target.getAttribute('data-date-count')}][starting_time][]`);
    input1.setAttribute('placeholder', 'Introduzca la hora...');
    input1.classList.add('block');
    
    div1.appendChild(label1);
    div1.appendChild(input1);


    let div2 = document.createElement('div');

    let label2 = document.createElement('label');
    label2.innerText = "Hora de fin";

    let input2 = document.createElement('input');
    input2.setAttribute('type', 'time');
    input2.setAttribute('name', `date[${e.target.getAttribute('data-date-count')}][ending_time][]`);
    input2.setAttribute('placeholder', 'Introduzca la hora...');
    input2.classList.add('block');
    
    div2.appendChild(label2);
    div2.appendChild(input2);
    activityFormDiv.insertBefore(div1, e.target);
    activityFormDiv.insertBefore(div2, e.target);
}

function newDate(){
    dateAmount ++

    let header = document.createElement('div');
    header.classList.add("col-span-2");

    let h1 = document.createElement('h1');
    h1.classList.add("text-white2", "font-black", "text-center", "border-b", "pb-2", "my-8", "text-xl")
    h1.innerText = `Fecha ${dateAmount}`
    header.appendChild(h1);


    let div2 = document.createElement('div');
    div2.classList.add("col-start-1");

    let label1 = document.createElement('label');
    label1.innerText = "Fecha";

    let input1 = document.createElement('input');
    input1.classList.add("block");
    input1.setAttribute("type", "date")
    input1.setAttribute("name", `date[${dateAmount - 1}][date]`)
    input1.setAttribute("placeholder", "Introduzca la Fecha...")

    div2.appendChild(label1);
    div2.appendChild(input1);


    let div3 = document.createElement('div');
    div3.classList.add("col-start-1");

    let label2 = document.createElement('label');
    label2.innerText = "Hora de inicio";

    let input2 = document.createElement('input');
    input2.setAttribute('type', 'time');
    input2.setAttribute('name', `date[${dateAmount-1}][starting_time][]`);
    input2.setAttribute('placeholder', 'Introduzca la hora...');
    input2.classList.add('block');
    
    div3.appendChild(label2);
    div3.appendChild(input2);



    let div4 = document.createElement('div');

    let label3 = document.createElement('label');
    label3.innerText = "Hora de fin";

    let input3 = document.createElement('input');
    input3.setAttribute('type', 'time');
    input3.setAttribute('name', `date[${dateAmount-1}][ending_time][]`);
    input3.setAttribute('placeholder', 'Introduzca la hora...');
    input3.classList.add('block');
    
    div4.appendChild(label3);
    div4.appendChild(input3);


    let addHourButton = document.createElement('div')
    addHourButton.innerText = "Agregar Hora"
    addHourButton.setAttribute("data-date-count", dateAmount-1)
    addHourButton.classList.add("hour-button", "col-span-2", "bg-yellow-900", "text-md", "text-center", "font-bold", "text-white2", "black_contour", "py-3", "hover:bg-yellow-800", "transition", "w-[25%]", "self-center", "justify-center")
    addHourButton.addEventListener("click", newHour);

    activityFormDiv.insertBefore(header, dateButton.parentElement);
    activityFormDiv.insertBefore(div2, dateButton.parentElement);
    activityFormDiv.insertBefore(div3, dateButton.parentElement);
    activityFormDiv.insertBefore(div4, dateButton.parentElement);
    activityFormDiv.insertBefore(addHourButton, dateButton.parentElement);
}

function changeInventorySelectInnerText(e){
    let selectInput = document.querySelector(`[data-good-count="${e.target.getAttribute("data-good-count")}"].inventory-select-input`);
    selectInput.options[0].innerText = inventories[e.target.getAttribute("data-inventory-id")];
    selectInput.setAttribute("value", e.target.getAttribute("data-inventory-id"))
}

function printGoodOption(select, good){
    let option = document.createElement("option");
    option.value = good.id;
    option.innerText = good.name;
    option.setAttribute("data-inventory-id", good.inventory_id);
    select.appendChild(option);
}

function newGood(){
    goodAmount ++
    let header = document.createElement("div"); 
    let title = document.createElement("h1");
    header.classList.add("col-span-2")
    title.classList.add("text-white2", "font-black", "text-center", "border-b", "pb-2", "my-8", "text-xl")
    title.innerText = `Bien ${goodAmount}`;
    header.appendChild(title);

    let div1 = document.createElement("div");
    let label1 = document.createElement("label");
    label1.innerText = "Bien"
    div1.appendChild(label1);

    let select = document.createElement("select");
    let initialOption = document.createElement("option");
    initialOption.innerText = "Seleccionar...";
    initialOption.setAttribute("disabled", "true");
    initialOption.setAttribute("selected", "true");
    select.appendChild(initialOption);
    goodsArrays.forEach(goodArray => {
        goodArray.forEach(good => {
            let option = document.createElement("option");
            option.value = good.id;
            option.innerText = good.name;
            option.setAttribute("data-inventory-id", good.inventory_id);
            option.setAttribute("data-good-count", goodAmount);
            option.classList.add("selectable-good-option")
            select.appendChild(option);
            option.addEventListener("click", changeInventorySelectInnerText)
        })
    })
    select.classList.add("block")
    select.setAttribute("name", "good_id[]")
    div1.appendChild(select);

    let div2 = document.createElement("div")
    let label2 = document.createElement("label");
    label2.innerText = "Inventario"
    let select2 = document.createElement("select");
    select2.setAttribute("data-good-count", goodAmount);
    select2.setAttribute("disabled", true);

    select2.classList.add("inventory-select-input", "block")
    div2.appendChild(label2)
    div2.appendChild(select2);
    let option = document.createElement("option");
    select2.appendChild(option)
    

    let div3 = document.createElement("div");
    let label3 = document.createElement("label");
    label3.innerText = "Cantidad"
    let input = document.createElement("input");
    input.setAttribute("type", "text")
    input.setAttribute("name", "quantity_requested[]")
    input.setAttribute("placeholder", "Introducir Cantidad...")
    input.classList.add("block")

    div3.appendChild(label3)
    div3.appendChild(input)

    activityFormDiv.insertBefore(header, goodButton.parentElement);
    activityFormDiv.insertBefore(div1, goodButton.parentElement);
    activityFormDiv.insertBefore(div2, goodButton.parentElement);
    activityFormDiv.insertBefore(div3, goodButton.parentElement);

    }
/*
        <div class="col-span-2">
                <h1 class="text-white2 font-black text-center border-b pb-2 my-8 text-xl">Bien 1</h1>
            </div>
            <div class="">
                <label for="good[]">Bien</label>
                <select name="good[]" id="" class="block">
                    <option value="">Pan</option>
                    <option value="">Queso</option>
                    <option value="">Fresco</option>
                </select>
            </div>
            <div class="">
                <label for="good[]">Inventario</label>
                <select name="good[]" id="" class="block">
                    <option value="">Academia</option>
                    <option value="">Casa de la Cultura</option>
                    <option value="">Biblioteca</option>
                </select>
            </div>
            <div>
                <label for="quantity_requested">Cantidad</label>
                <input class="block" type="text" name="quantity_requested" id="quantity_requested" placeholder="Introduzca la Cantidad...">
            </div>
            -->*/

    




function newOrganizer(){
    organizerAmount ++
    let header = document.createElement("div"); 
    let title = document.createElement("h1");
    header.classList.add("col-span-2")
    header.classList.add("col-start-1")
    title.classList.add("text-white2", "font-black", "text-center", "border-b", "pb-2", "my-8", "text-xl")
    title.innerText = `Organizador ${organizerAmount}`;
    header.appendChild(title);

    let div = document.createElement("div");

    let label = document.createElement("label");
    label.innerText = "Organizador"

    let input = document.createElement("input");
    input.setAttribute("type", "text");
    input.setAttribute("name", "organizer_name[]");
    input.setAttribute("placeholder", "Indique el Organizador...");
    input.classList.add("block");

    div.appendChild(label);
    div.appendChild(input);

    activityFormDiv.insertBefore(header, organizerButton.parentElement);
    activityFormDiv.insertBefore(div, organizerButton.parentElement);
}
