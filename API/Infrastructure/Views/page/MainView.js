import PostList from "../components/PostList.js";
import PostForm from '../components/PostForm.js'
import BoardList from '../components/BoardList.js'
//import * as $global from '/global.js';

export default class MainView extends HTMLElement {

    constructor() {
        super()
    }
    async connectedCallback() {
        this.innerHTML = '';
        //let main = document.createElement("MAIN")
        let aside = document.createElement("ASIDE")
        let section = document.createElement("SECTION")

        aside.appendChild(new BoardList())
        section.appendChild(new PostForm())
        section.appendChild(new PostList())

        this.appendChild(aside)
        this.appendChild(section)
        //this.appendChild(main)
    }
}

window.customElements.define("main-view", MainView);