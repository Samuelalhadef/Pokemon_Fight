<?php
// Inclure l'autoloader
require_once __DIR__ . '/autoload.php';

// Démarrer la session
session_start();

// Vérifier si le combat est initialisé
if (!isset($_SESSION['combat'])) {
    header('Location: index.php');
    exit;
}

// Récupérer les données de session nécessaires
$combat = $_SESSION['combat'];
$pokemon1 = $combat->getPokemon1();
$pokemon2 = $combat->getPokemon2();
$tourActuel = $combat->getTourActuel();
$joueurActif = $combat->getJoueurActif();
$messages = $_SESSION['messages'] ?? [];

// Traitement des actions de combat
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && isset($_POST['pokemon'])) {
        $action = $_POST['action'];
        $pokemonNumber = (int)$_POST['pokemon'];
        
        // Vérifier si c'est bien le tour du joueur
        if ($pokemonNumber === $joueurActif) {
            $attaquant = $pokemonNumber === 1 ? $pokemon1 : $pokemon2;
            $defenseur = $pokemonNumber === 1 ? $pokemon2 : $pokemon1;
            
            $message = $combat->tourDeCombat($action, $attaquant, $defenseur);
            $_SESSION['messages'][] = $message;
            
            // Sauvegarder l'état du combat
            $_SESSION['combat'] = $combat;
            
            // Rediriger pour éviter la resoumission du formulaire
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        }
    }
}

// Message de début de combat si c'est le premier tour
if ($tourActuel === 1 && empty($messages)) {
    $_SESSION['messages'][] = "Le combat commence entre {$pokemon1->getNom()} et {$pokemon2->getNom()} !";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Combat Pokémon</title>
    <style>
       @import url('https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap');

body {
    font-family: 'Press Start 2P', cursive;
    background: #1a1a1a;
    margin: 0;
    padding: 20px;
    color: #333;
    line-height: 1.6;
}

.container {
    max-width: 1000px;
    margin: 0 auto;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="4" height="4"><rect width="4" height="4" fill="%23ffffff"/><rect width="1" height="1" fill="%23f0f0f0"/></svg>');
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0,0,0,0.3);
    position: relative;
    overflow: hidden;
}

.tour-info {
    text-align: center;
    padding: 15px;
    background: #ff3333;
    color: white;
    border-radius: 8px;
    margin-bottom: 30px;
    box-shadow: inset 0 0 10px rgba(0,0,0,0.2);
    text-transform: uppercase;
    font-size: 14px;
}

.pokemon-info {
    background: #fff;
    border: 4px solid #333;
    border-radius: 10px;
    padding: 20px;
    margin: 20px 0;
    position: relative;
    transition: all 0.3s ease;
}

.pokemon-info.active {
    border-color: #ff3333;
    box-shadow: 0 0 15px rgba(255,51,51,0.3);
}

.pokemon-info.inactive {
    opacity: 0.8;
    filter: grayscale(30%);
}

.pokemon-info h2 {
    color: #333;
    font-size: 18px;
    margin-bottom: 15px;
    text-transform: uppercase;
}

.hp-bar {
    background: #eee;
    border: 3px solid #333;
    border-radius: 15px;
    height: 25px;
    position: relative;
    overflow: hidden;
    margin: 15px 0;
}

.hp-bar::before {
    content: "HP";
    position: absolute;
    left: 10px;
    top: 50%;
    transform: translateY(-50%);
    color: #333;
    font-size: 12px;
    z-index: 1;
}

.hp-bar-fill {
    height: 100%;
    background: linear-gradient(to bottom, #00ff00, #00cc00);
    transition: width 0.5s ease;
    box-shadow: inset 0 2px 0 rgba(255,255,255,0.3);
}

.hp-bar-fill.yellow {
    background: linear-gradient(to bottom, #ffff00, #ffcc00);
}

.hp-bar-fill.red {
    background: linear-gradient(to bottom, #ff3333, #cc0000);
}

.actions {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 10px;
    margin-top: 20px;
}

button {
    font-family: 'Press Start 2P', cursive;
    padding: 12px;
    background: linear-gradient(to bottom, #4CAF50, #45a049);
    color: white;
    border: 3px solid #333;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s ease;
    text-transform: uppercase;
    font-size: 12px;
}

button:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

button:active {
    transform: translateY(0);
}

.battle-log {
    background: #333;
    color: white;
    padding: 20px;
    border-radius: 10px;
    margin-top: 30px;
    height: 200px;
    overflow-y: auto;
    font-size: 14px;
    border: 4px solid #222;
}

.battle-log p {
    margin: 10px 0;
    padding: 8px;
    border-bottom: 1px solid #444;
    line-height: 1.4;
}

.battle-end {
    background: rgba(255,255,255,0.9);
    padding: 30px;
    border-radius: 10px;
    text-align: center;
    margin-top: 30px;
    border: 4px solid #333;
}

.return-button {
    display: inline-block;
    padding: 15px 30px;
    background: linear-gradient(to bottom, #ff3333, #cc0000);
    color: white;
    text-decoration: none;
    border-radius: 8px;
    margin-top: 20px;
    border: 3px solid #333;
    text-transform: uppercase;
    transition: all 0.3s ease;
}

.return-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

.type-badge {
    display: inline-block;
    padding: 5px 10px;
    border-radius: 5px;
    font-size: 12px;
    margin-left: 10px;
    color: white;
    text-transform: uppercase;
}

.type-feu { background: #ff4422; }
.type-eau { background: #3399ff; }
.type-plante { background: #22cc22; }

@media (max-width: 768px) {
    body {
        padding: 10px;
    }
    
    .actions {
        grid-template-columns: 1fr;
    }
    
    button {
        font-size: 10px;
        padding: 10px;
    }
}
    </style>
</head>
<body>
    <div class="container">
        <div class="tour-info">
            <h2>Tour <?php echo $tourActuel; ?></h2>
            <p>C'est au tour de <?php echo $joueurActif === 1 ? $pokemon1->getNom() : $pokemon2->getNom(); ?> de jouer !</p>
        </div>

        <!-- Pokémon 1 -->
        <div class="pokemon-info <?php echo $joueurActif === 1 ? 'active' : 'inactive'; ?>">
            <h2><?php echo $pokemon1->getNom(); ?> (<?php echo $pokemon1->getType(); ?>)</h2>
            <div class="hp-bar">
                <?php $pourcentageVie1 = ($pokemon1->getPointsDeVie() / $pokemon1->getPvMax()) * 100; ?>
                <div class="hp-bar-fill" style="width: <?php echo $pourcentageVie1; ?>%"></div>
            </div>
            <p>PV: <?php echo $pokemon1->getPointsDeVie(); ?>/<?php echo $pokemon1->getPvMax(); ?></p>
            
            <?php if (!$pokemon1->estKo() && !$combat->estTermine() && $joueurActif === 1): ?>
                <div class="actions">
                    <form method="POST">
                        <input type="hidden" name="pokemon" value="1">
                        <button type="submit" name="action" value="Attaquer">Attaque normale</button>
                        <button type="submit" name="action" value="Attaque Spéciale">Attaque spéciale</button>
                        <button type="submit" name="action" value="Soigner">Se soigner</button>
                    </form>
                </div>
            <?php endif; ?>
        </div>

        <!-- Pokémon 2 -->
        <div class="pokemon-info <?php echo $joueurActif === 2 ? 'active' : 'inactive'; ?>">
            <h2><?php echo $pokemon2->getNom(); ?> (<?php echo $pokemon2->getType(); ?>)</h2>
            <div class="hp-bar">
                <?php $pourcentageVie2 = ($pokemon2->getPointsDeVie() / $pokemon2->getPvMax()) * 100; ?>
                <div class="hp-bar-fill" style="width: <?php echo $pourcentageVie2; ?>%"></div>
            </div>
            <p>PV: <?php echo $pokemon2->getPointsDeVie(); ?>/<?php echo $pokemon2->getPvMax(); ?></p>
            
            <?php if (!$pokemon2->estKo() && !$combat->estTermine() && $joueurActif === 2): ?>
                <div class="actions">
                    <form method="POST">
                        <input type="hidden" name="pokemon" value="2">
                        <button type="submit" name="action" value="Attaquer">Attaque normale</button>
                        <button type="submit" name="action" value="Attaque Spéciale">Attaque spéciale</button>
                        <button type="submit" name="action" value="Soigner">Se soigner</button>
                    </form>
                </div>
            <?php endif; ?>
        </div>

        <!-- Journal de combat -->
        <div class="battle-log">
            <?php foreach (array_reverse($_SESSION['messages']) as $message): ?>
                <p><?php echo htmlspecialchars($message); ?></p>
            <?php endforeach; ?>
        </div>

        <!-- Fin de combat -->
        <?php if ($combat->estTermine()): ?>
            <div class="battle-end">
                <h2>Combat terminé !</h2>
                <?php
                $vainqueur = $combat->getVainqueur();
                if ($vainqueur) {
                    echo "<p>Le vainqueur est " . htmlspecialchars($vainqueur->getNom()) . " !</p>";
                }
                ?>
                <a href="index.php" class="return-button">Retour au menu principal</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>