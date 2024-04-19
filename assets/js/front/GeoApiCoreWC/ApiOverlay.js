export class ApiOverlay {
    constructor() {
        this.overlay = this.#createOverlay();
        this.loader  = this.#createLoader();
    }
    show() {
        document.body.appendChild(this.overlay);
        document.body.appendChild(this.loader);
    }

    remove() {
        this.overlay.remove();
        this.loader.remove();
    }

    // Helper methods for creating overlay and loader elements
    #createOverlay() {
        const overlay = document.createElement('div');

        overlay.classList.add('overlay'); // Add a class for styling
        overlay.style.backgroundColor = 'rgba(0, 0, 0, 0.5)'; // Example styling
        overlay.style.position = 'fixed';
        overlay.style.top = '0';
        overlay.style.left = '0';
        overlay.style.width = '100%';
        overlay.style.height = '100%';

        return overlay;
    }

    #createLoader() {
        const loader = document.createElement('div');

        loader.classList.add('loader'); // Add a class for styling
        loader.style.position = 'absolute';
        loader.style.top = '50%';
        loader.style.left = '50%';

        return loader;
    }
}