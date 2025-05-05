const html = `
<fieldset style="width:90%">
    <legend class="fs-5">What is THIS?</legend>
    <div class="fs-6 m-2">
        <p>THIS is a simple image forum where anyone can post comments and share images. There are forums dedicated to a variety of topics, from animation and Japanese culture to video games, music, and photography. No registration is required to participate in the community. ¡Click on the forum that interests you and start participating!</p>
        <p>Be sure to read the rules before posting and read the FAQ if you want to learn more about using the site.</p>
    </div>
</fieldset>`;

export default class BoardView extends HTMLElement {

    constructor() {
        super()
    }
    async connectedCallback() {
        this.innerHTML = html;
    }
}

window.customElements.define("board-page", BoardView);