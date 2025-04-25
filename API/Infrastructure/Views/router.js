//import Login from '/pages/login.js'
import Layout from '/pages/layout.js'
class Router extends HTMLElement{
    constructor() {
        super()
    }
    async connectedCallback() {
        this.innerHTML = '';
        let element; //= new Login;
        //if (!!window.localStorage.getItem('auth')) {
            element = new Layout;
        //}
        this.appendChild(element)
    }
}
window.customElements.define("router-parse", Router);