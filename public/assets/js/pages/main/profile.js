import Modal from '../../components/modal.js';

const profileBtns = document.querySelectorAll(".js-profile-tab");
profileBtns.forEach((button) => {
    button.addEventListener("click", () => {
        const section = button.dataset.section;
        btnAction(section);
    });
});

const typeToTitle = {
    "titles": "My Titles",
    "games": "Played Games",
    "bio": "Biography",
    "avatar": "Avatar",
    "users": "Users"
};

const modalCache = {}; // Evita requisições desnecessárias para o usuário (Cache)

async function btnAction(type){
    const url = new URL(window.location.href);
    switch (type) {
        case "titles":
        case "games":
        case "bio":
        case "avatar":
        case "users":
            url.searchParams.set('type', type);
            Modal.open(typeToTitle[type]);

            if (modalCache[type]) {
                Modal.injectContent(modalCache[type]);
                initDynamicFeatures(); 
                return;
            }

            Modal.injectContent("<p>Loading...</p>");
            
            try {
                const response = await fetch(`/api/profile?type=${type}`);
                if (!response.ok) throw new Error('Bad Request');
                const htmlInject = await response.text();
                
                modalCache[type] = htmlInject;
                Modal.injectContent(htmlInject);
                initDynamicFeatures();

            } catch(e) {
                console.error("Fetch failed.", e);
                Modal.injectContent("<p>Something went wrong.</p>");
            }

            Modal.automaticHeight(true);

            break;
        case "plus":
            window.location.href = '/plus';
            break;
        case "logout":
            window.location.href = '/logout';
            break;
        default:
            console.error("Error: Client modified.");
    }
}


function initDynamicFeatures() {
    initBioFeature();
    initAvatarFeature();
}

function initBioFeature() {
    const bioText = document.getElementById("bioInput");
    const charCount = document.getElementById("char-count");
    const charText = document.getElementById("char-text");
    const charLimit = 150;

    if (!bioText || !charCount || !charText) return;

    // Garante inicialmente que a contagem esteja sincronizada com o BD
    const initialLength = bioText.value ? bioText.value.length : 0;
    charCount.textContent = charLimit - initialLength; 

    // Remove listeners antigos se houver (evita duplicação) e adiciona o novo
    bioText.removeEventListener("input", handleBioInput);
    bioText.addEventListener("input", handleBioInput);

    function handleBioInput() {
        const count = charLimit - bioText.value.length;
        charCount.textContent = count;
        if (count >= 0) {
            charText.classList.remove("error-message");
            charCount.classList.remove("error-message");
        } else {
            charText.classList.add("error-message");
            charCount.classList.add("error-message");
        }
    }
}

function initAvatarFeature() {
    const avatarInput = document.getElementById("avatar-input");
    const pfpPreview = document.getElementById("pfp-preview");
    const uploadLabel = document.querySelector(".upload-label");

    if (!avatarInput || !pfpPreview || !uploadLabel) return;

    avatarInput.removeEventListener("change", handleAvatarChange);
    avatarInput.addEventListener("change", handleAvatarChange);

    function handleAvatarChange() {
        if (avatarInput.files && avatarInput.files[0]) {
            const file = avatarInput.files[0];
            const reader = new FileReader();

            reader.onload = (e) => {
                pfpPreview.src = e.target.result; 
            };

            reader.readAsDataURL(file);

            const shortName = file.name.length > 20 ? file.name.substring(0, 20) + "..." : file.name;
            uploadLabel.textContent = `✔ ${shortName}`;
        }
    }
}