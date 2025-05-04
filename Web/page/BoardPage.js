const html = `
<fieldset style="width:90%">
    <legend class="fs-5">Que es ESTO</legend>
    <div class="fs-6 m-2">
        <p>ESTO es un sencillo foro de imágenes donde cualquiera puede publicar comentarios y compartir imágenes.
        Hay foros dedicados a diversos temas, desde animación y cultura japonesa hasta videojuegos, música y fotografía. No es necesario registrarse para participar en la comunidad.
        ¡Haz clic en el foro que te interese y empieza a participar!</p>
        <p>Asegúrate de leer las reglas antes de publicar y lee las preguntas frecuentes si quieres saber más sobre el uso del sitio.</p>
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