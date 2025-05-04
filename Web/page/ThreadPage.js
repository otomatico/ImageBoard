import ThreadList from "../components/thread/ThreadList.js";
import ThreadForm from '../components/thread/ThreadForm.js';

export default class ThreadView extends HTMLElement {

    constructor() {
        super()
    }
    async connectedCallback() {
        this.className += "row m-0";
        let key = window.location.href.split('/').pop()
        const form = new ThreadForm();
        const thread = new ThreadList();
        thread.setAttribute("key", key);
        form.classList.add("col-12")
        thread.classList.add("col-12")
        this.appendChild(form);
        this.appendChild(thread);
    }
}

window.customElements.define("thread-page", ThreadView);