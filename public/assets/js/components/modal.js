const Modal = {
    el: document.querySelector("dialog"),

    init() {
        if (!this.el) return;

        this.el.addEventListener("click", (event) => {
            const rect = this.el.getBoundingClientRect();
            const clickedOutside = (
                event.clientX < rect.left ||
                event.clientX > rect.right ||
                event.clientY < rect.top ||
                event.clientY > rect.bottom
            );

            if (clickedOutside) {
                this.close();
            }
        });

        this.el.addEventListener("close", () => {
            this.bodyScroll(true);
        });
    },

    open(title) {
        this.el.querySelector("h1").textContent = title;
        this.el.showModal();
        this.bodyScroll(false);
    },

    close() {
        this.el.close();
        this.el.querySelector(".modal-body").innerHTML = ""; 
        this.el.querySelector("h1").textContent = "";
        this.bodyScroll(true);
        this.automaticHeight(false);
    },

    bodyScroll(statement) {
        if (statement) document.body.classList.remove("modal-open");
        else document.body.classList.add("modal-open");
    },

    injectContent(content) {
        const body = this.el.querySelector(".modal-body");
        if (body) body.innerHTML = content
    },

    automaticHeight(auto) {
        this.el.classList.toggle("auto-height", auto);
        const body = this.el.querySelector(".modal-body");
        body?.classList.toggle("auto-height", auto);
    }
};

Modal.init();
export default Modal;