import API from '../../services/API_Fetch.js'
import $global from '../../global.js'

const html = `
<button class="btn btn-outline-dark" id="createThreadDialog"><i class="bi bi-image-fill"></i> Add Thread</button>
<dialog id="threadDialog">
    <div class="d-flex justify-content-center mt-4">
        <fieldset>
            <legend>Add Thread</legend>
            <form class="card border-0" method="dialog">
                <div class="card-body">
                    <input class="form-control mb-2" type="text" name="title" placeholder="Thread Name" />
                    <input class="form-control mb-2" type="text" name="alias" placeholder="Name or Alias" />
                    <input class="form-control mb-2" type="text" name="subtitle" placeholder="Title Post" />
                    <textarea class="form-control mb-2" type="text" name="message" placeholder="Message" rows="7"></textarea>
                </div>
                <footer class="card-footer d-flex justify-content-between">
                    <label class="btn btn-outline-dark" for="image" title="Open Image"><i class="bi bi-image-fill"></i> Image</label>
                    <!--input type="file" class="hidden" id="image" name="image" /-->
                    <span class="separate">&nbsp;</span>
                    <div>
                        <button class="btn btn-outline-secondary" id="cancel" type="reset"><i class="bi bi-x-lg"></i> Cancel</button>
                        <button class="btn btn-outline-dark" type="submit" title="Thread"><i class="bi bi-floppy2-fill"></i> Save</button>
                    </div>
                </footer>
            </form>
        </fieldset>
    </div>
</dialog>`;
export default class ThreadForm extends HTMLElement {
    //#dialog = {}
    constructor() {
        super()
    }
    async connectedCallback() {
        await this.render()
        this.setupEventListener()
        this.classList.add("formElement")
    }
    async #Create(buffer) {
        const url = `${$global.url_api}/thread/create`
        const response = await API.post(url, JSON.stringify(buffer));
        console.log(await response.text())
    }

    async render() {
        //let divTemplate =  document.createElement("template")
        let divTemplate =  document.createElement("div")
        document.body.appendChild(divTemplate)
        divTemplate.innerHTML = html;        
        //this.append(divTemplate.content.cloneNode(true));
        this.append(divTemplate);
    }
    setupEventListener() {
        var threadDialog = this.querySelector("#threadDialog");
        var updateButton = this.querySelector("#createThreadDialog");
        var cancelButton = threadDialog.querySelector("#cancel");
        var submitButton = threadDialog.querySelector("[type=submit]")
        threadDialog.returnValue = false;
        let Create = this.#Create.bind(this)

        submitButton.addEventListener("click", async function () {
            let buffer = {};
            threadDialog.querySelectorAll("[name]").forEach(input => {
                if (input.type == "file") {
                    buffer[input.name] = input.files[0];
                } else {
                    buffer[input.name] = input.value;
                }
            })
            await Create(buffer);
            threadDialog.returnValue = true;
        });

        threadDialog.addEventListener("close", function () {
            alert(threadDialog.returnValue);
        });
        //threadDialog.querySelector("[for=image]").addEventListener("click",function(){
        //    document.querySelector("#image").click();
        //})
        updateButton.addEventListener("click", function () {
            threadDialog.showModal();
        });

        cancelButton.addEventListener("click", function () {
            threadDialog.close();
        });
    }
}

window.customElements.define("thread-form", ThreadForm);