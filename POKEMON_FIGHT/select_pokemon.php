<?php
require_once 'autoload.php';
session_start();

// Gestion du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['choix']) && $_POST['choix'] === 'existant') {
        header('Location: select_existing_pokemon.php');
        exit;
    } elseif (isset($_POST['choix']) && $_POST['choix'] === 'personnalise') {
        header('Location: create_pokemon.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mode de Jeu - Pokémon</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Press Start 2P', cursive;
            background: #1a1a1a;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        .background-pattern {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                linear-gradient(45deg, #ff000015 25%, transparent 25%) -10px 0,
                linear-gradient(45deg, transparent 75%, #0000ff15 75%),
                linear-gradient(45deg, #0000ff15 25%, transparent 25%) 0 0,
                linear-gradient(45deg, transparent 75%, #ff000015 75%) 10px -20px;
            background-size: 60px 60px;
            animation: patternMove 20s linear infinite;
            z-index: 1;
        }

        @keyframes patternMove {
            0% { background-position: 0 0, 30px 30px, 0 0, 30px 30px; }
            100% { background-position: 60px 60px, 90px 90px, 60px 60px, 90px 90px; }
        }

        .container {
            position: relative;
            z-index: 2;
            max-width: 800px;
            width: 90%;
            padding: 40px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.3);
        }

        h1 {
            text-align: center;
            margin-bottom: 40px;
            font-size: clamp(20px, 4vw, 32px);
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .mode-selection {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            margin-bottom: 30px;
        }

        .mode-card {
            background: rgba(255, 255, 255, 0.05);
            padding: 20px;
            border-radius: 15px;
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
        }

        .mode-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .mode-card input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }

        .mode-card-content {
            text-align: center;
            padding: 20px;
        }

        .mode-card h3 {
            margin-bottom: 15px;
            font-size: 16px;
        }

        .mode-card p {
            font-size: 12px;
            line-height: 1.6;
            color: #ccc;
        }

        .mode-card.selected {
            background: rgba(255, 0, 0, 0.2);
            box-shadow: 0 0 20px rgba(255, 0, 0, 0.3);
        }

        button[type="submit"] {
            display: block;
            width: 200px;
            margin: 30px auto 0;
            padding: 15px 30px;
            font-family: 'Press Start 2P', cursive;
            font-size: 14px;
            color: white;
            background: linear-gradient(45deg, #ff0000, #cc0000);
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        button[type="submit"]:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 0, 0, 0.3);
        }

        button[type="submit"]:active {
            transform: translateY(0);
        }
    </style>
</head>
<body>
    <div class="background-pattern"></div>
    <div class="container">
        <h1>Choisissez votre mode de jeu</h1>
        <form method="POST">
            <div class="mode-selection">
                <label class="mode-card">
                    <input type="radio" name="choix" value="existant" required>
                    <div class="mode-card-content">
                        <h3>Pokémon Existants</h3>
                        <p>Choisissez parmi une sélection de Pokémon classiques et affrontez vos adversaires dans des combats épiques !</p>
                    </div>
                </label>

                <label class="mode-card">
                    <input type="radio" name="choix" value="personnalise">
                    <div class="mode-card-content">
                        <h3>Créer un Pokémon</h3>
                        <p>Créez votre propre Pokémon unique avec des statistiques personnalisées pour des combats inédits !</p>
                    </div>
                </label>
            </div>
            <button type="submit">Commencer</button>
        </form>
    </div>

    <script>
        // Ajouter la classe 'selected' aux cartes sélectionnées
        document.querySelectorAll('.mode-card input').forEach(input => {
            input.addEventListener('change', function() {
                document.querySelectorAll('.mode-card').forEach(card => {
                    card.classList.remove('selected');
                });
                if (this.checked) {
                    this.closest('.mode-card').classList.add('selected');
                }
            });
        });
    </script>
</body>
</html>