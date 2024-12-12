<?php

abstract class Pokemon implements Combattant {
    use Soins;

    protected string $nom;
    protected string $type;
    protected int $pointsDeVie;
    protected int $puissanceAttaque;
    protected int $defense;
    protected int $precision;
    protected int $pvMax;
    protected string $nomCapacite;

    public function __construct(string $nom, string $type, int $pointsDeVie, int $puissanceAttaque, int $defense, int $precision, string $nomCapacite) {
        $this->nom = $nom;
        $this->type = $type;
        $this->pointsDeVie = $pointsDeVie;
        $this->pvMax = $pointsDeVie;
        $this->puissanceAttaque = $puissanceAttaque;
        $this->defense = $defense;
        $this->precision = $precision;
        $this->nomCapacite = $nomCapacite;
    }

    public function attaquer(Pokemon $adversaire): void {
        echo "{$this->nom} attaque {$adversaire->nom} avec une attaque classique !<br>";
        $degats = max(0, $this->puissanceAttaque - $adversaire->defense);
        $adversaire->pointsDeVie = max(0, $adversaire->pointsDeVie - $degats);
        echo "{$adversaire->nom} perd $degats points de vie et en a désormais {$adversaire->pointsDeVie}.<br>";
    }

    public function estKo(): bool {
        return $this->pointsDeVie <= 0;
    }

    public abstract function utiliserAttaqueSpeciale(Pokemon $adversaire): void;

    // Getters pour les propriétés protégées
    public function getPointsDeVie(): int {
        return $this->pointsDeVie;
    }

    public function getPvMax(): int {
        return $this->pvMax;
    }

    public function getNom(): string {
        return $this->nom;
    }

    public function getType(): string {
        return $this->type;
    }
}
