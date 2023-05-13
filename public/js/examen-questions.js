const choices= document.querySelectorAll('.choix');
choices.forEach(element => {
    element.addEventListener('click' , (e) => {
        let respondeIcon = document.querySelector('.responde-icon');
        console.log(e.target.parentNode.querySelector('.icon').classList);
        respondeIcon.innerHTML = e.target.parentNode.dataset.id;
        respondeIcon.classList = "responde-icon " + e.target.parentNode.querySelector('.icon').classList[1];
        
    })
});