window.addEventListener('load', function() {
    const hiddenTxt = document.getElementById('txt');
    hiddenTxt.classList.add('show');
});

const boton = document.getElementById('btn');
boton.addEventListener('click', function(){
    alert('Something Happen!!!')
});