<?php

class PokemonEau extends Pokemon {
    public function __construct() {
        parent::__construct("Carapuce", "eau", 44, 48, 35, 85, "Hydrocanon");
    }

    public function utiliserAttaqueSpeciale(Pokemon $adversaire): void {
        echo "{$this->nom} utilise {$this->nomCapacite} !<br>";
        $degats = 15;
        if ($adversaire->getType() === "feu") {
            $degats *= 2;
            echo "C'est super efficace !<br>";
        } elseif ($adversaire->getType() === "plante") {
            $degats = (int)($degats / 2);
            echo "Ce n'est pas très efficace...<br>";
        }
        $adversaire->pointsDeVie = max(0, $adversaire->pointsDeVie - $degats);
        echo "{$adversaire->getNom()} perd $degats points de vie et en a désormais {$adversaire->pointsDeVie}.<br>";
    }
}
