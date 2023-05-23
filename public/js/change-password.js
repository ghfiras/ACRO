const show = document.querySelector('.eye-icon');
console.log(show)
show.addEventListener('click' , () => {
    let i = show.querySelector('i');
    let inputs = document.querySelectorAll('input');
    if(i.classList.contains('fa-eye')){  // eye open
        for(let i = 0 ; i < 3; i++){
            inputs[i].type = 'text';
        }
        i.classList = "fa-solid fa-eye-slash" ; 
    }else{
        for(let i = 0 ; i < 3; i++){
            inputs[i].type = 'password';
        }
        i.classList = "fa-solid fa-eye" ; 
    }
})