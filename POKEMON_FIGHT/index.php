<?php
session_start();

// Inclure l'autoloader
require_once 'autoload.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Réinitialiser la session si nécessaire


// Gestion du formulaire pour lancer le combat
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'Lancer le combat') {
    // Rediriger vers le choix des Pokémon
    header('Location: select_pokemon.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Menu Principal - Combat Pokémon</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Press Start 2P', cursive;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #1a1a1a url('/api/placeholder/1920/1080') center/cover no-repeat;
            position: relative;
            overflow: hidden;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            z-index: 1;
        }

        .container {
            position: relative;
            z-index: 2;
            width: 90%;
            max-width: 800px;
            text-align: center;
        }

        h1 {
            color: #ffffff;
            font-size: clamp(24px, 5vw, 48px);
            margin-bottom: 50px;
            text-shadow: 0 0 10px rgba(255, 0, 0, 0.8),
                         0 0 20px rgba(0, 0, 255, 0.8);
            animation: glow 2s ease-in-out infinite alternate;
        }

        @keyframes glow {
            from {
                text-shadow: 0 0 10px rgba(255, 0, 0, 0.8),
                            0 0 20px rgba(0, 0, 255, 0.8);
            }
            to {
                text-shadow: 0 0 20px rgba(255, 0, 0, 0.8),
                            0 0 30px rgba(0, 0, 255, 0.8),
                            0 0 40px rgba(255, 255, 255, 0.8);
            }
        }

        .start-button {
            padding: 20px 40px;
            font-size: clamp(16px, 3vw, 24px);
            font-family: 'Press Start 2P', cursive;
            color: white;
            background: linear-gradient(45deg, #ff0000, #cc0000);
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            position: relative;
            overflow: hidden;
        }

        .start-button::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(
                transparent,
                rgba(255, 255, 255, 0.2),
                transparent
            );
            transform: rotate(45deg);
            animation: shine 3s infinite;
        }

        @keyframes shine {
            0% { transform: translateX(-100%) rotate(45deg); }
            100% { transform: translateX(100%) rotate(45deg); }
        }

        .start-button:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.4);
        }

        .start-button:active {
            transform: translateY(-2px);
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>
<body>
    <div class="overlay"></div>
    <div class="container">
        <h1>Arène Pokémon</h1>
        <form method="POST">
            <button type="submit" name="action" value="Lancer le combat" class="start-button">
                Commencer le Combat
            </button>
        </form>
    </div>
</body>
</html>