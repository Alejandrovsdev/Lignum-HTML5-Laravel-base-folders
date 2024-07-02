window.addEventListener('load', function() {
    const textOculto = document.getElementById('txt');
    textOculto.classList.add('show');
});

const boton = document.getElementById('btn');
boton.addEventListener('click', function(){
    alert('Something Happen!!!')
});