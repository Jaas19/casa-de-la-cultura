const redirectOptions = document.querySelectorAll('.redirectOption')
const redirectForm = document.querySelector('#redirectForm');
const redirectSelect = document.querySelector('#redirect-select')

function redirect(e){
    if (e.target.value) {
        console.log(e.target.value)
        redirectForm.action = e.target.value;
        redirectForm.submit();
    }
}
redirectSelect.addEventListener('change', redirect);