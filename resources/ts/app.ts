import "./bootstrap";
import OverType from "overtype";

document.addEventListener("DOMContentLoaded", () => {
    console.log("TS is running!");

    document.querySelectorAll<HTMLElement>(".editor").forEach((el) => {
        // find the hidden input right after this editor
        const hiddenInput = el.nextElementSibling as HTMLInputElement | null;

        if (!hiddenInput || hiddenInput.type !== "hidden") {
            console.warn("No matching hidden input found for editor:", el);
            return;
        }

        // initialize editor with hidden input's current value
        const [editor] = new OverType(el, {
            value: hiddenInput.value || "",
            toolbar: true,
            theme: "solar",
            onChange: (value) => {
                hiddenInput.value = value;
            },
        });

        // optional: final sync before form submit
        const form = el.closest("form");
        if (form) {
            form.addEventListener("submit", () => {
                hiddenInput.value = editor.getValue();
            });
        }
    });
});
