import ThreadList from "../components/thread/ThreadList.js";
import ThreadForm from '../components/thread/ThreadForm.js';

export default class ThreadView extends HTMLElement {

    constructor() {
        super()
    }
    async connectedCallback() {
        this.className += " flex-column";
        let key = window.location.href.split('/').pop()
        const form = new ThreadForm();
        const thread = new ThreadList();
        thread.setAttribute("key", key);
        
        thread.classList.add("p-2")
        this.appendChild(form);
        this.appendChild(thread);
    }
    async Create(){
        /*
        var input = document.querySelector('input[type="file"]')
        var data = new FormData()
        data.append('file', input.files[0])
        data.append('user', 'hubot')

        fetch('/avatars', {
        method: 'POST',
        body: data
        })
        */
    }
}

window.customElements.define("thread-page", ThreadView);