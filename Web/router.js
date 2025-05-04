import PostPage from './page/PostPage.js'
import BoardPage from './page/BoardPage.js'
import ThreadPage from './page/ThreadPage.js'
import BoardList from './components/board/BoardList.js'

const routes = [
    { href: '/', component: "board-page" },
    { href: '/board/:id', component: "thread-page" },
    { href: '/post/follow/:id', component: "post-page" },
    { href: '/404', component: "error-page" }
]

class RouterHandler extends HTMLElement {
    #routes = [];
    container = {};
    currentDomain = "";

    constructor() {
        super()
        this.currentDomain = window.location.href;
    }

    async connectedCallback() {
        //Build section WEB
        let aside = document.createElement("ASIDE")
        let section = document.createElement("SECTION")
        aside.className = "col-4 pt-2";
        section.className = "col pt-2 bg-white overflow-auto";
        aside.appendChild(new BoardList())

        this.appendChild(aside)
        this.appendChild(section)
        this.container = section;

        //Build redirect click link
        let watch = this.watch.bind(this);
        document.addEventListener('click', watch, false);

        //Parse routes
        routes.forEach(element => {
            this.#parseRoute(element);
        });
        //Go route default
        this.#applyPage('/');
    }

    watch(event) {
        event.preventDefault();
        const a = event.target;
        if (a.tagName == "A" && a.href.includes(this.currentDomain)) {
            //push URL on History Navigator
            window.history.pushState({}, '', event.target.href)
            let path = '/' + a.href.replace(this.currentDomain, '');
            this.#applyPage(path);
        }
    }

    #parseRoute(item) {
        const tag = /:\w+/i
        const route = { parameter: [], regex: '', path: item.href || '' }
        if (item.href) {
            let key = item.href;
            if (tag.test(key)) {
                route.parameter = key.match(tag)
                route.regex = new RegExp(`^${key.replace(tag, '(\\w+)')}$`, 'i')
            } else {
                route.regex = new RegExp(`^${key}$`, 'i')
                route.parameter = []
            }
            route.component = item.component || null;
            this.#routes.push(route);
        }
    }

    #matchRoute(path) {
        let found = this.#routes.find((route) => route.regex.test(path))
        return found
    }

    #applyPage(path) {
        this.container.innerHTML = ''
        let route = this.#matchRoute(path) || this.#matchRoute('/404')
        let element = `<${route.component} class="d-flex"></${route.component}>`;
        this.container.insertAdjacentHTML('beforeend', element);
    }
}
window.customElements.define("router-outlet", RouterHandler);
