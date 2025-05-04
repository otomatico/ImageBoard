import API from '../../services/API_Fetch.js'
import PostItem from '../post/PostItem.js'
import $global from '../../global.js'

export default class ThreadList extends HTMLElement {

    constructor() {
        super()
    }
    async connectedCallback() {
        this.innerHTML = '';
        if (this.getAttribute("key")) {
            this.#render();
        }

    }
    async attributeChangedCallback(attr, oldValue, newValue) {
        if (attr === 'key') {
            this.#render();
        }
    }
    static get observedAttributes() { return ['key']; }

    async #render() {
        let key = this.getAttribute("key");
        let list = await this.#GetTree(key);
        let html = list.Items.map((item) => {
            let posts = item.posts.map(({ id, subject, thumb_path, message }) =>
                this.#CreateItem(id, subject, thumb_path, message)
            );
            return this.#CreateBlock(item.subject, posts, item.total_posts);
        });
        html.forEach(item => this.append(item));
    }

    #CreateBlock(subject, body, total) {
        let card = document.createElement("div");
        let header = document.createElement("div");
        let container = document.createElement("div");
        card.appendChild(header)
        card.appendChild(container)

        card.className = "card";
        header.className = "card-header d-flex justify-content-between";
        container.className = "card-body d-flex d-flex-column";

        header.innerHTML = `<span>${subject}</span> <small>Total ${total}</small>`;
        container.insertAdjacentHTML('beforeend', body.join(""))
        return card;

    }
    #CreateItem(id, subject, thumb_path, message) {
        message = message.length > 200 ? message.slice(0, 197) + '...' : message;
        return `<post-item data-json='${JSON.stringify({ id, subject, thumb_path, message })}'></post-item>`;
    }

    async #GetTree(boardId = 'none', currentPage = 1, pageSize = 10) {
        const url = `${$global.url_api}/thread/${boardId}/${currentPage}/${pageSize}`;
        const response = await API.get(url);
        return response.json();
    }
}

window.customElements.define("thread-list", ThreadList);