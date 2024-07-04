window.addEventListener("DOMContentLoaded", function () {
    githubRepositories(configRepositoriesAPI);
});

window.addEventListener("load", function () {
    const hiddenTxt = document.getElementById("txt");
    hiddenTxt.classList.add("show");
});

function openSidebar() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle("open");
}

function errorCliente() {
    const aboutError = document.getElementById("txt");
    aboutError.style.backgroundColor = "red";
}

const config = {
    url: "https://api.chucknorris.io/jokes/random",
    metodo: "GET",
};

const configRepositoriesAPI = {
    url: "https://api.github.com/search/repositories?q=",
    metodo: "GET"
};

const githubRepositories = (configRepositoriesAPI) => {
    return new Promise((resolve, reject) => {
        const cliente = new XMLHttpRequest();

        const inputValue = document.getElementById("searchInput").value;

        if (inputValue == "") {
            url = configRepositoriesAPI.url + "Javascript";
        } else {
            url = configRepositoriesAPI.url + inputValue;
        }

        cliente.onreadystatechange = () => {
            if (cliente.readyState === 4) {
                if (cliente.status === 200) {
                    const repositoryList = document.getElementById("repositoryList");
                    const repositoryItem = document.getElementsByClassName("repositoryItem");
                    const itemsJSON = JSON.parse(cliente.responseText).items;

                    if (repositoryItem.length) {
                        repositoryList.innerHTML = "";
                    }

                    for (let i = 0; i < itemsJSON.length; i++) {
                        const repositoryItem = document.createElement("li");
                        repositoryItem.classList.add("repositoryItem");

                        const repositoryItemsLink = document.createElement("a");
                        repositoryItemsLink.setAttribute("href", itemsJSON[i].owner.html_url);
                        repositoryItemsLink.setAttribute("target", "_blank");
                        repositoryItemsLink.innerText = itemsJSON[i].full_name;

                        repositoryItem.appendChild(repositoryItemsLink);
                        repositoryList.appendChild(repositoryItem);
                    }
                    resolve(true)
                } else {
                    reject(new Error(errorCliente()));
                }
            }
        }
        cliente.open(configRepositoriesAPI.metodo, url);
        cliente.send();
    });
}

const search = document.getElementById("search").addEventListener("click", function () {
    githubRepositories(configRepositoriesAPI);
})

const llamadaAPI = (config) => {
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
        cliente.open(config.metodo, config.url);
        cliente.send();
    });
};

document.getElementById("btn").addEventListener("click", function () {
        llamadaAPI(config);
});


