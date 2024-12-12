<?php

trait Soins {
    public function soigner(): void {
        // Calcul du soin reçu
        $soinRecu = rand(5, 10);

        // Points de vie avant le soin
        $pvAvantSoin = $this->pointsDeVie;

        // Application du soin sans dépasser le maximum
        $this->pointsDeVie = min($this->pvMax, $this->pointsDeVie + $soinRecu);

        // Calcul du soin effectif
        $soinEffectif = $this->pointsDeVie - $pvAvantSoin;

        echo "{$this->nom} récupère {$soinEffectif} points de vie !<br>";
    }
}
