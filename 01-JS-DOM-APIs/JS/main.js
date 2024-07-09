window.addEventListener("load", function () {
    const hiddenTxt = document.getElementById("txt");
    hiddenTxt.classList.add("show");
});

function openSidebar() {
    const sidebar = document.getElementById("sidebar");
    sidebar.classList.toggle("open");
}

function closeSidebar() {
    const sidebar = document.getElementById("sidebar");
    if (sidebar.classList.contains("open")) {
        sidebar.classList.remove("open");
    }
}

function showJokeLoader() {
    const jokeLoader = document.getElementById("jokeLoader");
    jokeLoader.hidden = false;
}

function hideJokeLoader() {
    const jokeLoader = document.getElementById("jokeLoader");
    jokeLoader.hidden = true;
}

function showSearchLoader() {
    const searchLoader = document.getElementById("searchLoader");
    searchLoader.hidden = false;
}

function hideSearchLoader() {
    const searchLoader = document.getElementById("searchLoader");
    searchLoader.hidden = true;
}

function showTableLoader() {
    const tableLoader = document.getElementById("tableLoader");
    tableLoader.hidden = false;
}

function hideTableLoader() {
    const tableLoader = document.getElementById("tableLoader");
    tableLoader.hidden = true;
}

function clientError() {
    const aboutError = document.getElementById("txt");
    aboutError.style.backgroundColor = "red";
}

function setConfigurationGetHttp(url, method) {
    const config = {
        url: url,
        method: method,
    };

    return config;
}

const data = [
    { product: "t-shirt", category: "cloth", price: "$10" },
    { product: "blue berrys", category: "food", price: "$2" },
    { product: "paracetamol", category: "medication", price: "$20" },
    { product: "Micro services book", category: "education", price: "$120" },
];

const getGithubRepositories = (config) => {
    return new Promise((resolve, reject) => {
        const client = new XMLHttpRequest();

        const inputValue = document.getElementById("searchInput").value;

        if (inputValue == "") {
            url = config.url + "Javascript";
        } else {
            url = config.url + inputValue;
        }

        client.onload = () => {
            if (client.status === 200) {
                    const repositoryList = document.getElementById("repositoryList");
                    const repositoryItem = document.getElementsByClassName("repositoryItem");
                    const itemsJSON = JSON.parse(client.responseText).items;

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
                    resolve(true);
                } else {
                    reject(new Error(clientError()));
                }
            
        };
        client.open(config.method, url);
        client.send();
    });
};

const search = document.getElementById("search").addEventListener("click", function () {
        const config = setConfigurationGetHttp("https://api.github.com/search/repositories?q=", "GET");
        try {
            repositoryList.innerHTML = "";
            showSearchLoader();
            setTimeout(function() {
                getGithubRepositories(config)
                    .then(() => {
                        hideSearchLoader();
                    })
            }, 1000);
        } catch (error) {
            clientError();
        }
    });

const getChuckNorrisJoke = (config) => {
    return new Promise((resolve, reject) => {
        const client = new XMLHttpRequest();

        client.onload = () => {
            if (client.status === 200) {
                const section = document.getElementById("txt");
                const headerSection = section.querySelector("h1");
                headerSection.textContent = "Chuck Norris Joke";

                const paragraph = document.createElement("p");
                paragraph.id = "paragraph";
                paragraph.className = "paragraph";
                paragraph.textContent = JSON.parse(client.responseText).value;
                
                section.appendChild(paragraph);

                resolve(paragraph);
            } else {
                reject(new Error(clientError()));
            }
        };
        client.open(config.method, config.url);
        client.send();
    });
};

document.getElementById("btn").addEventListener("click", function () {
    const config = setConfigurationGetHttp("https://api.chucknorris.io/jokes/random", "GET");
    try {
        showJokeLoader();
        setTimeout(function() {
            const existingJoke = document.getElementById("paragraph");
            if (existingJoke) {
                existingJoke.remove();
            }
            getChuckNorrisJoke(config)
                .then(() => {
                    hideJokeLoader();
                })
        }, 500);
    } catch (error) {
        hideJokeLoader();
        clientError();
    }
});

function getExpensesList(data) {
    const table = document.createElement("table");
    table.setAttribute("id", "table");
    const tableHead = document.createElement("thead");
    const tableRow = document.createElement("tr");

    for (let key in data[0]) {
        const tableHeader = document.createElement("th");
        tableHeader.appendChild(document.createTextNode(key));
        tableRow.appendChild(tableHeader);
    }

    tableHead.appendChild(tableRow);
    table.appendChild(tableHead);

    const tableBody = document.createElement("tbody");

    for (let i = 0; i < data.length; i++) {
        const dataRow = data[i];
        const tableRow = document.createElement("tr");

        for (let key in dataRow) {
            const tableData = document.createElement("td");
            tableData.appendChild(document.createTextNode(dataRow[key]));
            tableRow.appendChild(tableData);
        }

        tableBody.appendChild(tableRow);
    }
    table.appendChild(tableBody);
    document.body.appendChild(table);
}

const tableGenerator = document.getElementById("tableGenerator").addEventListener("click", function () {
        const existingTable = document.getElementById("table");

        if (existingTable) {
            existingTable.remove();
        }

        showTableLoader();
        setTimeout(function() {
            hideTableLoader();
            expensesList(data);
        }, 500);

    });
//TODO: Quitar el sidebar con onblur y onfocus + un boton plegado
//TODO: Contemplar errores de red