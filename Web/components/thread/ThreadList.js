import API from '../../services/API_Fetch.js'
import PostItem from '../post/PostItem.js'
import $global from '../../global.js'

const css =`
thread-list .card .card-body .d-flex {
    margin-left:50px;
    border-left: 1px solid black;
}
thread-list .card .card-body :first-child.d-flex {
    margin-left:0px;
    border-left: 0;
    border-bottom: 1px solid black;
}`
export default class ThreadList extends HTMLElement {

    constructor() {
        super()
    }
    async connectedCallback() {
        this.innerHTML = '';
        const style = document.createElement("STYLE");
        style.innerHTML = css;
        this.appendChild(style);
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
            let posts = item.posts.map(({subject, thumb_path, message }) =>
                this.#CreateItem(subject, thumb_path, message)
            );
            return this.#CreateBlock(item.id, item.subject, posts, item.total_posts);
        });
        html.forEach(item => this.append(item));
    }

    #CreateBlock(id, subject, body, total) {
        let card = document.createElement("div");
        let header = document.createElement("div");
        let container = document.createElement("div");
        card.appendChild(header)
        card.appendChild(container)

        card.className = "card mb-2";
        header.className = "card-header d-flex justify-content-between";
        container.className = "card-body d-flex flex-column";

        header.innerHTML = `<span>${subject}</span> <small><a href="/post/follow/${id}">Reply ${total}</a></small>`;
        container.insertAdjacentHTML('beforeend', body.join(""))
        return card;

    }

    #CreateItem(subject, thumb_path, message) {
        return `
<div class="d-flex" >
    <img src="/static/${thumb_path}" class="rounded-start m-2" style="height:100px; width:200px;"/>
    <div>
        <span class="fs-5">${subject}</span>
        <blockquote class="fs-6 word-wrap">${message}</blockquote>
    </div>        
</div>`;
    }

    async #GetTree(boardId = 'none', currentPage = 1, pageSize = 10) {
        const url = `${$global.url_api}/thread/${boardId}/${currentPage}/${pageSize}`;
        const response = await API.get(url);
        return response.json();
    }
}

window.customElements.define("thread-list", ThreadList);