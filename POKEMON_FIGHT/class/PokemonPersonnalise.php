<?php

class PokemonPersonnalise extends Pokemon {
    public function __construct($nom, $type, $pointsDeVie, $puissanceAttaque, $defense, $precision, $nomCapacite) {
        parent::__construct($nom, $type, $pointsDeVie, $puissanceAttaque, $defense, $precision, $nomCapacite);
    }

    public function utiliserAttaqueSpeciale(Pokemon $adversaire): void {
        echo "{$this->nom} utilise {$this->nomCapacite} !<br>";
        $degats = $this->puissanceAttaque;

        // Modificateur de type
        if ($this->typeAvantageuxContre($adversaire->getType())) {
            $degats *= 2;
            echo "C'est super efficace !<br>";
        } elseif ($this->typeDesavantageuxContre($adversaire->getType())) {
            $degats = (int)($degats / 2);
            echo "Ce n'est pas très efficace...<br>";
        }

        $adversaire->pointsDeVie = max(0, $adversaire->pointsDeVie - $degats);
        echo "{$adversaire->getNom()} perd $degats points de vie et en a désormais {$adversaire->pointsDeVie}.<br>";
    }

    private function typeAvantageuxContre($typeAdverse): bool {
        $avantages = [
            'feu' => 'plante',
            'eau' => 'feu',
            'plante' => 'eau',
        ];

        return isset($avantages[$this->type]) && $avantages[$this->type] === $typeAdverse;
    }

    private function typeDesavantageuxContre($typeAdverse): bool {
        $desavantages = [
            'feu' => 'eau',
            'eau' => 'plante',
            'plante' => 'feu',
        ];

        return isset($desavantages[$this->type]) && $desavantages[$this->type] === $typeAdverse;
    }
}
