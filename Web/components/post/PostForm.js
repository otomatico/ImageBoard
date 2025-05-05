const html = `
<button class="btn btn-outline-dark" id="createPostDialog"><i class="bi bi-image-fill"></i> Add Image</button>
<dialog id="postDialog">
    <div class="d-flex justify-content-center mt-4">
        <fieldset>
            <legend>Add Image</legend>
            <form class="card border-0" method="dialog">
                <div class="card-body">
                    <input class="form-control mb-2" type="text" name="alias" placeholder="Name" />
                    <input class="form-control mb-2" type="text" name="title" placeholder="Title" />
                    <textarea class="form-control mb-2" type="text" name="message" placeholder="Message" rows="7"></textarea>
                </div>
                <footer class="card-footer d-flex justify-content-between">
                    <label class="btn btn-outline-dark" for="image" title="Open Image"><i class="bi bi-image-fill"></i> Image</label><input type="file"
                        class="hidden" id="image" name="image" />
                    <span class="separate">&nbsp;</span>
                    <div>
                    <button class="btn btn-outline-secondary" id="cancel" type="reset"><i class="bi bi-x-lg"></i> Cancel</button>
                        <button class="btn btn-outline-dark" type="submit" title="Post"><i class="bi bi-floppy2-fill"></i> Save</button>
                    </div>
                </footer>
            </form>
        </fieldset>
    </div>
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
        this.classList.add("formElement");
    }

    async #Post() {
        const url = "/Board/GetAll"
        const response = await fetch(url);
        return response.json();
    }
}

window.customElements.define("post-form", PostForm);