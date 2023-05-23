const choices= document.querySelectorAll('.choix');
choices.forEach(element => {
    element.addEventListener('click' , (e) => {
        let respondeIcon = document.querySelector('.responde-icon');
        console.log(e.target.parentNode.querySelector('.icon').classList);
        respondeIcon.innerHTML = e.target.parentNode.dataset.id;
        respondeIcon.classList = "responde-icon " + e.target.parentNode.querySelector('.icon').classList[1];
        
    })
});


document.addEventListener('keydown', (e) => {
    let respondeIcon = document.querySelector('.responde-icon');
    /*if (e.code == 'Numpad1' ) {
        let input = document.querySelector('#first_choice');
        input.checked = true 
        respondeIcon.innerHTML = 'أ' ;
        respondeIcon.classList = "responde-icon " + "first" ;  
    } else if (e.code === 'Numpad2') {
        let input = document.querySelector('#second_choice');
        input.checked = true 
        respondeIcon.innerHTML =   'ب' ;
        respondeIcon.classList = "responde-icon " + "second" ;  
    
    }else if(e.code === 'Numpad3'){
        let input = document.querySelector('#third_choice');
        input.checked = true 
        respondeIcon.innerHTML = 'ج' ;
        respondeIcon.classList = "responde-icon " + "third" ;
    }
    else if (e.code === 'Space' ){
        form = document.querySelector('form');
        form.submit();
    }*/
    if (e.code === 'Space' ){
        form = document.querySelector('form');
        form.submit();
    }
});