const initialTheme = localStorage.getItem("theme") || "dark"; // Fallback - Assume que é dark
import Modal from "../components/modal.js";

const themeBtn = document.querySelectorAll(".js-theme-toggle");
const timeGap = (ms) => new Promise(resolve => setTimeout(resolve, ms));

let isClicking = false // Flag pra controlar clicks desenfreados

themeBtn.forEach(button => {
    button.addEventListener("click", async () => {
        if (isClicking) return;
        isClicking = true;

        // Muda o tema (Localmente)
        document.body.classList.add("no-transition");
        document.body.classList.toggle("dark-mode");

        const isDark = document.body.classList.contains("dark-mode");
        const finalTheme = isDark ? "dark" : "light";

        // Salva no localStorage para backups locais
        localStorage.setItem("theme", finalTheme);
        
        // Envia a preferência para o banco de dados
        try {
            const response = await fetch("/api/change-theme", {
                method: "POST",
                body: JSON.stringify({ theme: finalTheme }),
                headers: { "Content-Type": "application/json" }
            });
            if (!response.ok) throw new Error("Action could not be completed:" + response.status);
        } catch(error) {
            console.log("Error: Could not change on database.")
            document.body.classList.toggle("dark-mode"); // Retorna para o tema anterior
            localStorage.setItem("theme", !isDark ? "dark" : "light");
        } finally {
            await timeGap(100);
            document.body.classList.remove("no-transition");
            isClicking = false;
        }
    })
});