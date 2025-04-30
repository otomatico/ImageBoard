import ThreadList from "../components/ThreadList.js";
import ThreadForm from '../components/ThreadForm.js'
import BoardList from '../components/BoardList.js'
//import * as $global from '/global.js';

export default class BoardView extends HTMLElement {

    constructor() {
        super()
    }
    async connectedCallback() {
        this.innerHTML = '';
        let aside = document.createElement("ASIDE")
        let section = document.createElement("SECTION")
        aside.className = "col-4 pt-2 ps-2";
        section.className = "col p-2 bg-white overflow-auto";
        aside.appendChild(new BoardList())
        section.appendChild(new ThreadForm())
        section.appendChild(new ThreadList())

        this.appendChild(aside)
        this.appendChild(section)
        //this.appendChild(main)
    }
}

window.customElements.define("board-view", BoardView);