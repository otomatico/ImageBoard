export default class PostItem extends HTMLElement {

    constructor() {
        super()
    }
    async connectedCallback() {
        let json = JSON.parse(this.dataset["json"]);
        let html = this.#CreateItem(json.id, json.subject, json.thumb_path, json.message);
        this.insertAdjacentHTML('beforeend', html);
    }

    #CreateItem(id, subject, thumb_path, message) {
        return `
<div class="d-flex" >
    <img src="/static/${thumb_path}" class="rounded-start m-2" style="height:100px; width:200px;"/>
    <div>
        <span class="fs-5">${subject}</span> <a href="/post/follow/${id}" class="">[more]</a>
        <blockquote class="fs-6 word-wrap">${message}</blockquote>
    </div>        
</div>`;
    }

}

window.customElements.define("post-item", PostItem);