const express = require("express");
const cors = require("cors");

const app = express();
app.use(cors());

// Traductions pour **tout** le site
const translations = {
    fr: {
        home: "Accueil",
        about: "À propos",
        contact: "Contact",
        welcome: "Bienvenue sur notre site",
        description: "Découvrez nos services et offres exceptionnelles.",
        button: "En savoir plus",
    },
    en: {
        home: "Home",
        about: "About",
        contact: "Contact",
        welcome: "Welcome to our website",
        description: "Discover our services and amazing offers.",
        button: "Learn more",
    },
    es: {
        home: "Inicio",
        about: "Sobre nosotros",
        contact: "Contacto",
        welcome: "Bienvenido a nuestro sitio",
        description: "Descubre nuestros servicios y ofertas excepcionales.",
        button: "Saber más",
    },
};

// Route API pour récupérer toutes les traductions
app.get("/api/lang/:lang", (req, res) => {
    const lang = req.params.lang;
    res.json(translations[lang] || translations["fr"]);
});

// Démarrer le serveur
const PORT = 3000;
app.listen(PORT, () => console.log(`API multilingue sur http://localhost:${PORT}`));
