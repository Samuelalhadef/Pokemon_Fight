<?php
require_once __DIR__ . '/autoload.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (
        isset($_POST['nom1'], $_POST['type1'], $_POST['pv1'], $_POST['attaque1'], $_POST['defense1'], $_POST['precision1'], $_POST['capacite1']) &&
        isset($_POST['nom2'], $_POST['type2'], $_POST['pv2'], $_POST['attaque2'], $_POST['defense2'], $_POST['precision2'], $_POST['capacite2'])
    ) {
        $pokemon1 = new PokemonPersonnalise(
            $_POST['nom1'],
            $_POST['type1'],
            (int)$_POST['pv1'],
            (int)$_POST['attaque1'],
            (int)$_POST['defense1'],
            (int)$_POST['precision1'],
            $_POST['capacite1']
        );

        $pokemon2 = new PokemonPersonnalise(
            $_POST['nom2'],
            $_POST['type2'],
            (int)$_POST['pv2'],
            (int)$_POST['attaque2'],
            (int)$_POST['defense2'],
            (int)$_POST['precision2'],
            $_POST['capacite2']
        );

        $combat = new Combat($pokemon1, $pokemon2);
        $_SESSION['combat'] = $combat;
        $_SESSION['message'] = [];

        header('Location: combat.php');
        exit;
    } else {
        $error = "Veuillez remplir tous les champs.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer vos Pokémon</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Press Start 2P', cursive;
        }

        body {
            background: linear-gradient(135deg, #a8e6cf 0%, #dcedc1 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
            font-size: 24px;
        }

        .pokemon-creators {
            display: flex;
            gap: 30px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .pokemon-form {
            flex: 1;
            min-width: 300px;
            max-width: 450px;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
            font-size: 18px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
            font-size: 12px;
        }

        input, select {
            width: 100%;
            padding: 8px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            transition: border-color 0.3s;
        }

        input:focus, select:focus {
            border-color: #a8e6cf;
            outline: none;
        }

   

        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .submit-button {
            display: block;
            width: 100%;
            max-width: 300px;
            margin: 30px auto 0;
            padding: 15px;
            background: linear-gradient(45deg, #a8e6cf, #dcedc1);
            border: none;
            border-radius: 8px;
            color: #333;
            font-size: 16px;
            cursor: pointer;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .submit-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .error {
            padding: 10px;
            background-color: #ffe6e6;
            border: 2px solid #ffcccc;
            border-radius: 5px;
            color: #cc0000;
            text-align: center;
            margin-top: 20px;
        }

        @media (max-width: 768px) {
            .pokemon-creators {
                flex-direction: column;
            }

            .pokemon-form {
                max-width: 100%;
            }
        }

        .type-selector {
            margin-bottom: 20px;
        }

        .type-feu { border-left: 4px solid #ff4422; }
        .type-eau { border-left: 4px solid #3399ff; }
        .type-plante { border-left: 4px solid #22cc22; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Créer vos Pokémon</h1>
        <form method="POST">
            <div class="pokemon-creators">
                <?php foreach ([1, 2] as $num): ?>
                    <div class="pokemon-form">
                        <h2>Pokémon <?php echo $num; ?></h2>
                        
                        <div class="form-group">
                            <label>Nom</label>
                            <input type="text" name="nom<?php echo $num; ?>" required>
                        </div>
                        
                        <div class="form-group type-selector">
                            <label>Type</label>
                            <select name="type<?php echo $num; ?>" required>
                                <option value="feu">Feu</option>
                                <option value="eau">Eau</option>
                                <option value="plante">Plante</option>
                            </select>
                        </div>
                        
                        <div class="stats-grid">
                            <div class="form-group">
                                <label>Points de Vie (10-100)</label>
                                <input type="number" name="pv<?php echo $num; ?>" min="10" max="100" required>
                            </div>
                            
                            <div class="form-group">
                                <label>Attaque (10-100)</label>
                                <input type="number" name="attaque<?php echo $num; ?>" min="10" max="100" required>
                            </div>
                            
                            <div class="form-group">
                                <label>Défense (10-100)</label>
                                <input type="number" name="defense<?php echo $num; ?>" min="10" max="100" required>
                            </div>
                            
                            <div class="form-group">
                                <label>Précision (50-100)</label>
                                <input type="number" name="precision<?php echo $num; ?>" min="50" max="100" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label>Capacité Spéciale</label>
                            <input type="text" name="capacite<?php echo $num; ?>" required>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <button type="submit" class="submit-button">Lancer le Combat !</button>
        </form>
        
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
    </div>

    <script>
        // Ajoute une bordure colorée selon le type sélectionné
        document.querySelectorAll('select[name^="type"]').forEach(select => {
            select.addEventListener('change', function() {
                const form = this.closest('.pokemon-form');
                form.className = 'pokemon-form type-' + this.value;
            });
        });
    </script>
</body>
</html>