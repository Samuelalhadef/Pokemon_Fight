<?php

class PokemonPlante extends Pokemon {
    // Définition explicite des propriétés utilisées
    private int $compteurTours = 0;
    private int $frequenceRegeneration = 3;
    private int $regenerationMinimum = 2;
    private int $regenerationMaximum = 5;
    private int $toursAvantRegeneration = 3;
    private int $toursDepuisRegenerationPV = 0;
    private int $toursPourRegeneration = 3;
    private int $minRegenerationPV = 2;
    private int $maxRegenerationPV = 5;

    public function __construct() {
        parent::__construct("Bulbizarre", "plante", 45, 49, 39, 70, "Fouet Lianes");
    }

    public function seBattre(Pokemon $adversaire): void {
        echo "Un combat verdoyant commence entre {$this->nom} et {$adversaire->nom} !<br>";

        while (!$this->estKo() && !$adversaire->estKo()) {
            $this->compteurTours++;
            if ($this->compteurTours % $this->frequenceRegeneration === 0) {
                $this->regenerationNaturelle();
            }

            $this->attaquer($adversaire);

            if (!$adversaire->estKo()) {
                $adversaire->attaquer($this);
            }
        }

        if ($this->estKo()) {
            echo "Les feuilles de {$this->nom} se fanent, {$adversaire->nom} remporte le combat !<br>";
        } else {
            echo "La force de la nature triomphe, {$this->nom} gagne le combat !<br>";
        }
    }

    private function regenerationNaturelle(): void {
        $regeneration = rand($this->regenerationMinimum, $this->regenerationMaximum);
        $pvAvantSoin = $this->pointsDeVie;
        $this->pointsDeVie = min($this->pvMax, $this->pointsDeVie + $regeneration);
        $regenerationReelle = $this->pointsDeVie - $pvAvantSoin;

        if ($regenerationReelle > 0) {
            echo "La nature nourrit {$this->nom} qui récupère {$regenerationReelle} PV !<br>";
            echo "Points de vie : {$this->pointsDeVie}/{$this->pvMax}<br>";
        }
    }

    public function utiliserAttaqueSpeciale(Pokemon $adversaire): void {
        echo "{$this->nom} utilise {$this->nomCapacite} !<br>";
        $degats = 12;
        if ($adversaire->getType() === "eau") {
            $degats *= 2;
            echo "C'est super efficace !<br>";
        } elseif ($adversaire->getType() === "feu") {
            $degats = (int)($degats / 2);
            echo "Ce n'est pas très efficace...<br>";
        }
        $adversaire->pointsDeVie = max(0, $adversaire->pointsDeVie - $degats);
        echo "{$adversaire->getNom()} perd $degats points de vie et en a désormais {$adversaire->pointsDeVie}.<br>";
    }
}
