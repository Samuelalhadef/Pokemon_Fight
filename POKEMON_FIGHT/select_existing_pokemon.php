<?php
require_once 'autoload.php';
session_start();

// Configuration des Pokémon disponibles par type
$availablePokemon = [
    // Type Feu
    'charmander' => ['name' => 'Salamèche', 'id' => 4, 'type' => 'feu'],
    'charmeleon' => ['name' => 'Reptincel', 'id' => 5, 'type' => 'feu'],
    'charizard'  => ['name' => 'Dracaufeu',  'id' => 6, 'type' => 'feu'],
    'vulpix'     => ['name' => 'Goupix',     'id' => 37, 'type' => 'feu'],
    'ninetales'  => ['name' => 'Feunard',    'id' => 38, 'type' => 'feu'],
    'growlithe'  => ['name' => 'Caninos',    'id' => 58, 'type' => 'feu'],
    'arcanine'   => ['name' => 'Arcanin',    'id' => 59, 'type' => 'feu'],

    // Type Plante
    'bulbasaur'  => ['name' => 'Bulbizarre', 'id' => 1, 'type' => 'plante'],
    'ivysaur'    => ['name' => 'Herbizarre', 'id' => 2, 'type' => 'plante'],
    'venusaur'   => ['name' => 'Florizarre', 'id' => 3, 'type' => 'plante'],
    'oddish'     => ['name' => 'Mystherbe',  'id' => 43, 'type' => 'plante'],
    'gloom'      => ['name' => 'Ortide',     'id' => 44, 'type' => 'plante'],
    'vileplume'  => ['name' => 'Rafflesia',  'id' => 45, 'type' => 'plante'],
    'bellsprout' => ['name' => 'Chétiflor',  'id' => 69, 'type' => 'plante'],
    'weepinbell' => ['name' => 'Boustiflor', 'id' => 70, 'type' => 'plante'],
    'victreebel' => ['name' => 'Empiflor',   'id' => 71, 'type' => 'plante'],

    // Type Eau
    'squirtle'   => ['name' => 'Carapuce',   'id' => 7,   'type' => 'eau'],
    'wartortle'  => ['name' => 'Carabaffe',  'id' => 8,   'type' => 'eau'],
    'blastoise'  => ['name' => 'Tortank',    'id' => 9,   'type' => 'eau'],
    'goldeen'    => ['name' => 'Poissirène', 'id' => 118, 'type' => 'eau'],
    'seaking'    => ['name' => 'Poissoroy',  'id' => 119, 'type' => 'eau'],
    'staryu'     => ['name' => 'Stari',      'id' => 120, 'type' => 'eau'],
    'starmie'    => ['name' => 'Staross',    'id' => 121, 'type' => 'eau'],
    'magikarp'   => ['name' => 'Magicarpe',  'id' => 129, 'type' => 'eau'],
    'gyarados'   => ['name' => 'Léviator',   'id' => 130, 'type' => 'eau'],
];

// Initialisation de l'API et chargement des données
$api = new PokemonAPI();
$pokemonData = [];

// Charger les données des Pokémon
foreach ($availablePokemon as $key => $pokemon) {
    $data = $api->getPokemonData($pokemon['id']);
    if ($data) {
        $pokemonData[$key] = [
            'name' => $pokemon['name'],
            'image' => $api->getPokemonImageUrl($data),
            'stats' => $api->getPokemonStats($data),
            'type' => $pokemon['type']
        ];
    }
}

// Traitement de la sélection des Pokémon
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pokemon1'], $_POST['pokemon2'])) {
    if (isset($pokemonData[$_POST['pokemon1']], $pokemonData[$_POST['pokemon2']])) {
        $pokemon1Data = $pokemonData[$_POST['pokemon1']];
        $pokemon2Data = $pokemonData[$_POST['pokemon2']];

        // Création des Pokémon pour le combat
        $pokemon1 = new PokemonPersonnalise(
            $pokemon1Data['name'],
            $pokemon1Data['type'],
            intval($pokemon1Data['stats']['hp']),
            intval($pokemon1Data['stats']['attack']),
            intval($pokemon1Data['stats']['defense']),
            85,
            "Attaque Spéciale"
        );

        $pokemon2 = new PokemonPersonnalise(
            $pokemon2Data['name'],
            $pokemon2Data['type'],
            intval($pokemon2Data['stats']['hp']),
            intval($pokemon2Data['stats']['attack']),
            intval($pokemon2Data['stats']['defense']),
            85,
            "Attaque Spéciale"
        );

        // Stockage en session
        $_SESSION['pokemon1_image'] = $pokemon1Data['image'];
        $_SESSION['pokemon2_image'] = $pokemon2Data['image'];
        $_SESSION['combat'] = new Combat($pokemon1, $pokemon2);
        $_SESSION['messages'] = ['Le combat commence !'];

        // Redirection vers le combat
        header('Location: combat.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Sélection des Pokémon</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap');

        body {
            font-family: 'Press Start 2P', sans-serif;
            margin: 0;
            padding: 20px;
            min-height: 100vh;
            transition: background 0.5s ease;
            background: linear-gradient(270deg, #C62828, #E53935, #B71C1C);
            background-size: 600% 600%;
            animation: gradientShift 10s ease infinite;
        }

        body.player2-selecting {
            background: linear-gradient(270deg, #1E3F66, #1E88E5, #1565C0);
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .selection-header {
            text-align: center;
            color: white;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            margin-bottom: 30px;
        }

        .pokemon-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            padding: 20px;
        }

        .pokemon-card {
            background: rgba(255, 255, 255, 0.9);
            border: 4px solid transparent;
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .pokemon-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .pokemon-image {
            width: 120px;
            height: 120px;
            display: block;
            margin: 0 auto;
            image-rendering: pixelated;
        }

        .pokemon-info {
            margin-top: 10px;
            font-size: 12px;
        }

        .selected-p1 { border-color: #ff0000; }
        .selected-p2 { border-color: #0000ff; }
        .selected-both {
            border-image: linear-gradient(to right, #ff0000 50%, #0000ff 50%) 1;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="selection-header">
            <h1>Sélection des Pokémon</h1>
            <div id="turn-indicator">JOUEUR 1 - Choisissez votre Pokémon !</div>
        </div>

        <div class="pokemon-grid">
            <?php foreach ($pokemonData as $key => $pokemon): ?>
                <div class="pokemon-card" data-pokemon="<?php echo htmlspecialchars($key); ?>">
                    <img src="<?php echo htmlspecialchars($pokemon['image']); ?>" 
                         alt="<?php echo htmlspecialchars($pokemon['name']); ?>" 
                         class="pokemon-image">
                    <div class="pokemon-info">
                        <h3><?php echo htmlspecialchars($pokemon['name']); ?></h3>
                        <p>PV: <?php echo htmlspecialchars($pokemon['stats']['hp']); ?></p>
                        <p>Attaque: <?php echo htmlspecialchars($pokemon['stats']['attack']); ?></p>
                        <p>Défense: <?php echo htmlspecialchars($pokemon['stats']['defense']); ?></p>
                        <p>Type: <?php echo ucfirst(htmlspecialchars($pokemon['type'])); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <form id="selection-form" method="POST" style="display: none;">
        <input type="hidden" name="pokemon1" id="pokemon1-input">
        <input type="hidden" name="pokemon2" id="pokemon2-input">
    </form>

    <script>
        let currentPlayer = 1;
        let selection = { player1: null, player2: null };
        const turnIndicator = document.getElementById('turn-indicator');
        const body = document.body;

        document.querySelectorAll('.pokemon-card').forEach(card => {
            card.addEventListener('click', function() {
                const pokemonKey = this.dataset.pokemon;

                if (currentPlayer === 1) {
                    // Réinitialiser la sélection précédente
                    if (selection.player1) {
                        document.querySelector(`[data-pokemon="${selection.player1}"]`)
                            .classList.remove('selected-p1', 'selected-both');
                    }
                    
                    selection.player1 = pokemonKey;
                    this.classList.add('selected-p1');
                    
                    // Passer au joueur 2
                    currentPlayer = 2;
                    body.classList.add('player2-selecting');
                    turnIndicator.textContent = "JOUEUR 2 - Choisissez votre Pokémon !";
                    
                } else if (currentPlayer === 2) {
                    selection.player2 = pokemonKey;
                    
                    if (selection.player1 === selection.player2) {
                        this.classList.remove('selected-p1');
                        this.classList.add('selected-both');
                    } else {
                        this.classList.add('selected-p2');
                    }

                    // Soumettre le formulaire
                    document.getElementById('pokemon1-input').value = selection.player1;
                    document.getElementById('pokemon2-input').value = selection.player2;
                    
                    setTimeout(() => {
                        document.getElementById('selection-form').submit();
                    }, 500);
                }
            });
        });
    </script>
</body>
</html>