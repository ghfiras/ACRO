document.addEventListener('DOMContentLoaded' , () => {
    let score = document.querySelector('span').innerText;
    progress = document.querySelector('.parent-progress');
    console.log(typeof(score));
    let deg = (score * 360) / 30 ;
    console.log(deg);
    if (score >= 24){
        progress.style.background = `conic-gradient(green ${deg}deg , #F0F0F0 0deg)`;
    }else{
        progress.style.background = `conic-gradient(#DC3545 ${deg}deg , #F0F0F0 0deg)`;
    }

} )