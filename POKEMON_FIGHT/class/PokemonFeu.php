<?php

class PokemonFeu extends Pokemon {
    public function __construct() {
        parent::__construct("Salamèche", "feu", 39, 52, 33, 75, "Lance-Flammes");
    }

    public function utiliserAttaqueSpeciale(Pokemon $adversaire): void {
        echo "{$this->nom} utilise {$this->nomCapacite} !<br>";
        $degats = 18;
        if ($adversaire->getType() === "plante") {
            $degats *= 2;
            echo "C'est super efficace !<br>";
        } elseif ($adversaire->getType() === "eau") {
            $degats = (int)($degats / 2);
            echo "Ce n'est pas très efficace...<br>";
        }
        $adversaire->pointsDeVie = max(0, $adversaire->pointsDeVie - $degats);
        echo "{$adversaire->getNom()} perd $degats points de vie et en a désormais {$adversaire->pointsDeVie}.<br>";
    }
}
