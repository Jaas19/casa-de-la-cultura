const redirectOptions = document.querySelectorAll('.redirectOption')
const redirectForm = document.querySelector('.redirectForm');

function redirect(e){
    redirectForm.action = e.target.value;
    console.log(redirectForm.action)
    redirectForm.submit();
}

for(option of redirectOptions){
    option.addEventListener('click', redirect);
}