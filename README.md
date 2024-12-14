<div align="center">


# 🎮 Pokémon Battle Simulator

![Head](https://github.com/user-attachments/assets/7f6b9630-8997-476e-8441-9abb8b4196c1)

Un simulateur de combat Pokémon moderne, reproduisant fidèlement le système de combat des jeux originaux, construit en PHP avec une interface interactive.

</div>

## ✨ Fonctionnalités
- 🎯 Système de combat tour par tour fidèle aux jeux Pokémon
- 🔄 Gestion des types et des affinités
- 💫 Animations d'attaques et effets visuels
- 🎨 Interface utilisateur moderne et responsive
- 🛠️ Création de Pokémon personnalisés
- 🌊 Sélection de Pokémon existants avec données de l'API
- 🎲 Système de combat équilibré avec calculs de dégâts

## 🛠️ Technologies Utilisées
- PHP 8.0+
- HTML5 & CSS3
- JavaScript
- API PokéAPI
- Architecture orientée objet
- Animations CSS avancées

## 📦 Installation
1. **Clonez le dépôt**
   ```bash
   git clone https://github.com/Samuelalhadef/Pokemon-Battle-Simulator
   ```
2. **Configurez un serveur PHP local**
   ```bash
   php -S localhost:8000
   ```
3. **Créez le dossier cache**
   ```bash
   mkdir cache
   chmod 777 cache
   ```
4. **Accédez à l'application**
   ```
   http://localhost:8000
   ```

## 📚 Structure du Projet
```
pokemon-battle/
│
├── class/
│   ├── Pokemon.php            # Classe abstraite Pokémon
│   ├── PokemonAPI.php         # Gestion API Pokémon
│   ├── Combat.php             # Logique de combat
│   ├── PokemonEau.php         # Type Eau
│   └── PokemonPersonnalise.php # Pokémon custom
│
├── interface/
│   └── Combattant.php        # Interface de combat
│
├── trait/
│   └── Soins.php             # Trait de soin
│
├── cache/                     # Cache API
├── index.php                 # Page d'accueil
├── select_pokemon.php        # Sélection Pokémon
├── create_pokemon.php        # Création Pokémon
├── combat.php               # Page de combat
└── autoload.php             # Chargement classes
```

## 🎮 Gameplay
### 🏠 Menu Principal
- Choix entre Pokémon existants ou création
- Interface style jeu vidéo
- Animations fluides

### ⚔️ Combat
- Système de tour par tour
- Attaques normales et spéciales
- Gestion des PV et soins
- Animations d'attaques
- Journal de combat détaillé

### 🛠️ Création de Pokémon
- Personnalisation complète
- Choix du type
- Équilibrage des stats
- Capacités spéciales

## 🔄 État du Projet
🚧 **En Développement**: Notre Pokédex est encore en train de se remplir !

Futures améliorations prévues :
- Plus de types de Pokémon
- Effets sonores
- Nouvelles animations
- Mode multijoueur
- Sauvegarde des combats

## 🙏 Remerciements
- [PokéAPI](https://pokeapi.co/) pour leur API exceptionnelle
- Nintendo et The Pokémon Company pour l'univers Pokémon
- La communauté open source

## 📫 Contact
SAMUEL ALHADEF - [TWITTER](https://x.com/SAMUELALHADEF)
               - [LINKEDIN](https://www.linkedin.com/in/samuel-alhadef-190951257/)

Lien du projet: [https://github.com/Samuelalhadef/Pokemon-Battle-Simulator](https://github.com/Samuelalhadef/Pokemon_Fight)

---
<div align="center">
  
Fait avec ❤️ par [SAMUEL ALHADEF](https://github.com/Samuelalhadef)

</div>
