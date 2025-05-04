import PostForm from '../components/post/PostForm.js';
import PostItem from "../components/post/PostItem.js";
import API from '../../services/API_Fetch.js';
import $global from '../../global.js';

export default class PostView extends HTMLElement {
    #id = 0;
    constructor() {
        super()
    }
    async connectedCallback() {
        this.innerHTML = '';
        this.className += "row m-0";

        const form = new PostForm();
        form.classList.add("col-12");
        this.appendChild(form);

        let id = window.location.href.split('/').pop()
        if (id) {
            this.#id = id;
            this.#render();
        }
    }

    async attributeChangedCallback(attr, oldValue, newValue) {
        if (attr === 'id') {
            this.#id = newValue;
            this.#render();
        }
    }
    static get observedAttributes() { return ['id']; }

    async #render() {
        let list = await this.#GetPost(this.#id);
        let html = list.map(({ id, subject, thumb_path, message }) => {
            message = message.length > 200 ? message.slice(0, 197) + '...' : message;
            let post = new PostItem();
            post.classList.add("col-12")
            post.dataset['json'] = JSON.stringify({ id, subject, thumb_path, message });
            return post;
        });
        html.forEach(item => this.appendChild(item));
    }

    async #GetPost(threadId = 0, currentPage = 1, pageSize = 10) {
        const url = `${$global.url_api}/post/${threadId}/${currentPage}/${pageSize}`;
        const response = await API.get(url);
        return response.json();
    }
}

window.customElements.define("post-page", PostView);