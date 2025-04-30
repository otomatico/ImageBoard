import API from '../services/API_Fetch.js'
import $global from '../global.js'

export default class ThreadList extends HTMLElement {

    constructor() {
        super()
    }
    async connectedCallback() {
        this.innerHTML = '';
        let list = await this.#GetTree();
        let html = list.map((item) => {
            let items = item.posts.map(({ id, subject, thumb_path, message }) => {
                let text = message.length > 200 ? message.slice(0, 197) + '...' : message;
                return this.#CreateItem(id, subject, thumb_path, text);
            }
            );
            return this.#CreateBlock(item.subject, items.join(""));
        });
        this.insertAdjacentHTML('beforeend', html.join(""));
    }

    #CreateBlock(subject, body) {
        return `
<div class="card">
    <h3 class="card-header">${subject}</h3>
    <article class="card-body d-flex d-flex-column">${body}</article>
</div>`;

    }
    #CreateItem(id, subject, thumb_path, message) {
        return `
<div class="d-flex" >
    <img src="./static/${thumb_path}" class="rounded-start m-2" style="height:100px; width:200px;"/>
    <div>
        <span class="fs-5">${subject}</span> <a href="/post/follow/${id}" class="">[more]</a>
        <blockquote class="fs-6 word-wrap">${message}</blockquote>
    </div>        
</div>`;
    }

    async #GetTree(boardId = 1,currentPage = 1,pageSize = 10) {
        const url = `${$global.url_api}/thread/${boardId}/${currentPage}/${pageSize}`;
        //const url = `${$global.url_api}/thread/${boardId}`
        const response = await API.get(url);
        return response.json();
    }
}

window.customElements.define("thread-list", ThreadList);