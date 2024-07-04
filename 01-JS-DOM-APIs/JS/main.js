window.addEventListener("load", function () {
    const hiddenTxt = document.getElementById("txt");
    hiddenTxt.classList.add("show");
});

function errorCliente() {
    const aboutError = document.getElementById("txt");
    aboutError.style.backgroundColor = "red";
}

const configuracion = {
    url: "https://api.chucknorris.io/jokes/random",
    metodo: "GET",
};

const llamadaAPI = (configuracion) => {
    return new Promise((resolve, reject) => {
        const cliente = new XMLHttpRequest();

        cliente.onreadystatechange = () => {
            if (cliente.readyState === 4) {
                if (cliente.status === 200) {
                    const respuestaAPI = document.getElementById("txt");
                    const node = document.getElementById("parrafo");
                    
                    if (node) {
                        respuestaAPI.removeChild(node);
                    }
                    
                    const parrafo = document.createElement("p");
                    parrafo.id = "parrafo";
                    parrafo.textContent = JSON.parse(
                        cliente.responseText
                    ).value;
                    respuestaAPI.appendChild(parrafo);
                    
                    resolve(parrafo);
                } else {
                    reject(new Error(errorCliente()));
                }
            }
        };
        cliente.open(configuracion.metodo, configuracion.url);
        cliente.send();
    });
};

document.getElementById("btn").addEventListener("click", function () {
        llamadaAPI(configuracion);
});
