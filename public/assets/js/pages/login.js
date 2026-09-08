const form = document.querySelector("form");
const username = document.querySelector("#userInput");
const email = document.querySelector("#emailInput")
const passwd = document.querySelector("#passwdInput");
const passwdVerify = document.querySelector("#passwdVerifyInput");
const submitBtn = document.querySelector("#submitBtn");
const aBtn = document.querySelector("#sign-in-btn");
const message = document.querySelector("#response-message");
const inputs = document.querySelectorAll("input")
let registerMode = false;

const timeGap = (ms) => new Promise(resolve => setTimeout(resolve, ms));

function showMessage(element, text) {
    element.classList.remove("killed");
    element.textContent = text;
}

function hideMessage(element) {
    element.classList.add("killed");
    element.textContent = "";
}

aBtn.addEventListener('click', async (e) => {
    e.preventDefault(); // Impede o '#' aparecer na URL
    hideMessage(message);
    registerMode = !registerMode;
    submitBtn.classList.add("invisible-text");
    await timeGap(400);
    if (registerMode){
        submitBtn.textContent = "Register";
        aBtn.textContent = "Already have an account?";
        email.classList.remove("hidden");
        passwdVerify.classList.remove("hidden");
    } else {
        submitBtn.textContent = "Login";
        aBtn.textContent = "Create account";
        email.classList.add("hidden");
        passwdVerify.classList.add("hidden");
        passwd.classList.remove("warning");
        passwdVerify.classList.remove("warning");
    }
    submitBtn.classList.remove("invisible-text");
    submitBtn.classList.add("highlight-border");
    await timeGap(1000);
    submitBtn.classList.remove("highlight-border");
});

form.addEventListener("submit", async (e) => {
    e.preventDefault();

    inputs.forEach(input =>  {
        input.classList.remove("failed-input");
        input.classList.remove("warning");
    });

    hideMessage(message);

    const userValue = username.value.trim();
    const emailValue = email.value.trim();
    const passwdValue = passwd.value.trim();
    const verifyValue = passwdVerify.value.trim();

    const toValidate = registerMode ? [username, email, passwd, passwdVerify] : [username, passwd];
    let isEmpty = false;

    toValidate.forEach((field) => {
        if (field.value.trim() === "") {
            field.classList.add("failed-input");
            isEmpty = true;
        }
    });

    if (isEmpty) {
        showMessage(message,"Please, fill all fields to proceed.");
        return;
    }

    // !RegisterMode
    if (userValue.length < 3) {
        username.classList.add("warning")
        showMessage(message, "User must have more than 3 characters.");
        return;
    } else if (userValue.length > 20) {
        username.classList.add("warning")
        showMessage(message, "User must have less or equal to 20 characters.");
        return;
    } 

    if (passwdValue.length < 8) {
        passwd.classList.add("warning")
        showMessage(message, "Password must have atleast 8 characters.");
        return;
    }

    // RegisterMode
    if (registerMode) {
        const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

        if (!emailRegex.test(emailValue)) {
            email.classList.add("warning");
            showMessage(message, "Please enter a valid email address.");
            return;
        }

        if (passwdValue !== verifyValue) {
            passwd.classList.add("warning");
            passwdVerify.classList.add("warning");
            showMessage(message, "Passwords do not match!");
            return;
        }
    }

    const url = registerMode ? "/register" : "/login";
    const formData = new FormData(form);

    try {
        const response = await fetch(url, {
            method: "POST",
            body: formData
        });

        const data = await response.json();

        if (response.ok && data.success) {
            if (data.redirect) {
                window.location.href = data.redirect;
            }
        } else {
            showMessage(message, data.message || "Authentication failed.");
            
            // Aplica as classes se a mensagem do erro menciona o campo.
            if (data.message && data.message.toLowerCase().includes("username")) {
                username.classList.add("warning");
            } if (data.message && data.message.toLowerCase().includes("email")) {
                email.classList.add("warning");
            } if (data.message && data.message.toLowerCase().includes("password")) {
                passwd.classList.add("warning");
            }
        } 
    } catch (error) {
        console.error("Error:", error)
        showMessage(message, "Something went wrong. Try again later.")
    }
});

inputs.forEach((input) => {
    input.addEventListener("focus", () => {
        hideMessage(message);
        input.classList.remove("warning");
    })
    input.addEventListener("input", () => {
        input.classList.remove("failed-input") // Abordagem otimista (Remove a borda vermelha assim que algo mudar)
        input.classList.remove("warning");
    })
})

// Impede o usuário de digitar caracteres proibidos em tempo real
// Permitindo apenas letras, números e underline _
username.addEventListener("input", () => {
    username.value = username.value.replace(/[^a-zA-Z0-9_]/g, "");
});