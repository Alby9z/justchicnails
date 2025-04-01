async function changeLanguage(lang) {
    const response = await fetch(`http://localhost:3000/api/lang/${lang}`);
    const translations = await response.json();

    // Mettre à jour **tous** les textes avec data-i18n
    document.querySelectorAll("[data-i18n]").forEach((element) => {
        const key = element.getAttribute("data-i18n");
        if (translations[key]) {
            element.textContent = translations[key];
        }
    });

    localStorage.setItem("lang", lang); // Sauvegarde la langue
}

// Appliquer la langue sauvegardée
const savedLang = localStorage.getItem("lang") || "fr";
document.getElementById("languageSwitcher").value = savedLang;
changeLanguage(savedLang);

// Changer la langue au choix
document.getElementById("languageSwitcher").addEventListener("change", (e) => {
    changeLanguage(e.target.value);
});