const html=`
<button id="createPostDialog">Agregar Image</button>
<dialog id="postDialog">
    <!--document.querySelector("dialog").show()-->
    <fieldset class="card center">
        <legend class="card-title">Agregar Image</legend>
        <form class="form" method="dialog">
            <input class="form-item" type="text" name="alias" placeholder="Name" />
            <input class="form-item" type="text" name="title" placeholder="Title" />
            <textarea class="form-item" type="text" name="message" placeholder="Message" rows="7"></textarea>
            <footer>
                <label class="btn" for="image" title="Open Image">&#x1F5FB; Image</label><input type="file"
                    class="hidden" id="image" name="image" />
                <button type="submit" title="Post">&#x1F4BE; Guardar</button>
                <button id="cancel" type="reset">&#x274C; Cancel</button>
            </footer>
        </form>
    </fieldset>
</dialog>`;
export default class PostForm extends HTMLElement {

    constructor() {
        super()
    }
    async connectedCallback() {
        this.innerHTML = html;
        var updateButton = document.getElementById("createPostDialog");
        var cancelButton = document.getElementById("cancel");
        var postDialog = document.getElementById("postDialog");

        updateButton.addEventListener("click", function () {
            postDialog.showModal();
          });
      
          // Form cancel button closes the dialog box
          cancelButton.addEventListener("click", function () {
            postDialog.close();
          });
    }

    async #Post(){
        const url ="/Board/GetAll"
        const response = await fetch(url);
        return response.json();
    }
}

window.customElements.define("post-form", PostForm);