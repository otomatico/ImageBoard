import API from '../services/API_Fetch.js'
import $global from '../global.js'

const html=`
<figure class="post">
    <img src="assets/none.png" />
    <figcaption>None Test Image</figcaption>
    <article>
        Lorem ipsum recusive mode
    </article>
</figure>`
export default class PostList extends HTMLElement {

    constructor() {
        super()
    }
    async connectedCallback() {
        this.innerHTML = '';
        let list = await this.#GetTree();
        let html = list.map((item)=>{
            let items = item.posts.map(({subject,thumb_path,message})=>
                this.#CreateItem(subject,thumb_path,message)
            );
            return this.#CreateBlock(item.subject,items.join(""));
        });
        this.insertAdjacentHTML( 'beforeend', html.join("") );
    }

    #CreateBlock(subject,body){
        return `
<div class="card border-0">
    <h3 class="card-title">${subject}</h3>
    <article class="card-main">${body}</article>
</div>`;
    }
    #CreateItem(subject,thumb_path,message){
        return `
<figure class="post">
    <img src="./static/${thumb_path}" />
    <figcaption>${subject}</figcaption>
    <article>${message}</article>
</figure>`;
    }

    async #GetTree(id=1){
        const url =`${$global.url_api}/thread/treebyboard/${id}`
        const response = await API.get(url);
        return response.json();
    }
}

window.customElements.define("post-list", PostList);