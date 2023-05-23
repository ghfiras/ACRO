document.addEventListener('keydown', (e) => {
    if (e.code === 'ArrowRight') {
        link = document.querySelector('.next-reponse');
        link.click();
    } else if (e.code === 'ArrowLeft') {
        link = document.querySelector('.prev-reponse');
        link.click();
    }
});