import API from '../services/API_Fetch.js'
import $global from '../global.js'

export default class BoardList extends HTMLElement {

    constructor() {
        super()
    }
    async connectedCallback() {
        this.innerHTML = '';
        let card = document.createElement("fieldset");
        let header = document.createElement("legend");
        let body = document.createElement("menu");

        card.className="card";
        header.className="card-title";
        header.textContent="Board"
        body.className="card-main";
        card.appendChild(header);
        card.appendChild(body);
        this.appendChild(card);
        let list = await this.#Get();
        list.forEach(item=>{
            let li = document.createElement("li")
            let a = document.createElement("a")
            a.setAttribute("href",`post/${item.id}`)
            a.textContent = item.name;
            li.appendChild(a);
            body.appendChild(li);
        });
    }

    async #Get(){
        const url =`${$global.url_api}/Board/GetAll`
        const response = await API.get(url);
        return response.json();
    }
}

window.customElements.define("board-list", BoardList);